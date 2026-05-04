import 'package:flutter/material.dart';
import 'package:mobile/screens/login_screen.dart';
import 'package:mobile/services/activity_service.dart';
import 'package:mobile/services/auth_service.dart';
import 'package:mobile/services/presence_service.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({super.key});

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  final _auth = AuthService();
  final _presenceService = PresenceService();
  final _activityService = ActivityService();
  bool _loading = false;
  String _message = '';
  List<dynamic> _presences = [];
  List<dynamic> _activites = [];

  final _titleCtrl = TextEditingController();
  final _descCtrl = TextEditingController();

  @override
  void initState() {
    super.initState();
    _refreshData();
  }

  @override
  void dispose() {
    _titleCtrl.dispose();
    _descCtrl.dispose();
    super.dispose();
  }

  Future<void> _refreshData() async {
    setState(() => _loading = true);
    final pres = await _presenceService.listMine();
    final act = await _activityService.list();
    if (!mounted) return;
    setState(() {
      _presences = (pres['data'] as List<dynamic>?) ?? [];
      _activites = (act['data'] as List<dynamic>?) ?? [];
      _loading = false;
    });
  }

  Future<void> _checkIn() async {
    setState(() => _message = 'Pointage en cours...');
    final res = await _presenceService.checkIn();
    setState(() => _message = (res['message'] ?? 'Pointage arrivée').toString());
    await _refreshData();
  }

  Future<void> _checkOut() async {
    setState(() => _message = 'Pointage en cours...');
    final res = await _presenceService.checkOut();
    setState(() => _message = (res['message'] ?? 'Pointage départ').toString());
    await _refreshData();
  }

  Future<void> _submitActivity() async {
    if (_titleCtrl.text.trim().isEmpty || _descCtrl.text.trim().isEmpty) {
      setState(() => _message = 'Titre et description sont requis');
      return;
    }
    final today = DateTime.now().toIso8601String().split('T').first;
    final res = await _activityService.create(
      date: today,
      titre: _titleCtrl.text.trim(),
      description: _descCtrl.text.trim(),
    );
    setState(() => _message = (res['message'] ?? 'Activité soumise').toString());
    _titleCtrl.clear();
    _descCtrl.clear();
    await _refreshData();
  }

  Future<void> _logout() async {
    await _auth.logout();
    if (!mounted) return;
    Navigator.of(context).pushReplacement(
      MaterialPageRoute(builder: (_) => const LoginScreen()),
    );
  }

  @override
  Widget build(BuildContext context) {
    return DefaultTabController(
      length: 2,
      child: Scaffold(
        appBar: AppBar(
          title: const Text('PAC Internship'),
          bottom: const TabBar(
            tabs: [
              Tab(text: 'Présences'),
              Tab(text: 'Activités'),
            ],
          ),
          actions: [
            IconButton(onPressed: _refreshData, icon: const Icon(Icons.refresh)),
            IconButton(onPressed: _logout, icon: const Icon(Icons.logout)),
          ],
        ),
        body: _loading
            ? const Center(child: CircularProgressIndicator())
            : TabBarView(
                children: [
                  _buildPresences(),
                  _buildActivities(),
                ],
              ),
      ),
    );
  }

  Widget _buildPresences() {
    return Padding(
      padding: const EdgeInsets.all(16),
      child: Column(
        children: [
          Row(
            children: [
              Expanded(
                child: ElevatedButton.icon(
                  onPressed: _checkIn,
                  icon: const Icon(Icons.login),
                  label: const Text('Check-in'),
                ),
              ),
              const SizedBox(width: 12),
              Expanded(
                child: ElevatedButton.icon(
                  onPressed: _checkOut,
                  icon: const Icon(Icons.logout),
                  label: const Text('Check-out'),
                ),
              ),
            ],
          ),
          const SizedBox(height: 12),
          if (_message.isNotEmpty) Text(_message),
          const SizedBox(height: 12),
          Expanded(
            child: ListView.builder(
              itemCount: _presences.length,
              itemBuilder: (context, index) {
                final p = _presences[index] as Map<String, dynamic>;
                return ListTile(
                  title: Text((p['date'] ?? '').toString()),
                  subtitle: Text(
                    'Arrivée: ${p['heure_arrivee'] ?? '-'} | Départ: ${p['heure_depart'] ?? '-'}',
                  ),
                  trailing: Icon(
                    (p['is_valid'] == true) ? Icons.check_circle : Icons.warning,
                    color: (p['is_valid'] == true) ? Colors.green : Colors.orange,
                  ),
                );
              },
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildActivities() {
    return Padding(
      padding: const EdgeInsets.all(16),
      child: Column(
        children: [
          TextField(
            controller: _titleCtrl,
            decoration: const InputDecoration(labelText: 'Titre activité'),
          ),
          const SizedBox(height: 8),
          TextField(
            controller: _descCtrl,
            maxLines: 3,
            decoration: const InputDecoration(labelText: 'Description'),
          ),
          const SizedBox(height: 8),
          Align(
            alignment: Alignment.centerRight,
            child: ElevatedButton(
              onPressed: _submitActivity,
              child: const Text('Soumettre'),
            ),
          ),
          const SizedBox(height: 12),
          Expanded(
            child: ListView.builder(
              itemCount: _activites.length,
              itemBuilder: (context, index) {
                final a = _activites[index] as Map<String, dynamic>;
                return ListTile(
                  title: Text((a['titre'] ?? '').toString()),
                  subtitle: Text((a['description'] ?? '').toString()),
                  trailing: Text((a['statut'] ?? '').toString()),
                );
              },
            ),
          ),
        ],
      ),
    );
  }
}

import 'package:flutter/material.dart';
import 'package:mobile/screens/home_screen.dart';
import 'package:mobile/services/auth_service.dart';

class LoginScreen extends StatefulWidget {
  const LoginScreen({super.key});

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final _formKey = GlobalKey<FormState>();
  final _emailController = TextEditingController();
  final _passwordController = TextEditingController();
  final _auth = AuthService();
  bool _isLoading = false;
  String? _error;

  @override
  void dispose() {
    _emailController.dispose();
    _passwordController.dispose();
    super.dispose();
  }

  Future<void> _submit() async {
    if (!_formKey.currentState!.validate()) return;

    setState(() {
      _isLoading = true;
      _error = null;
    });

    final res = await _auth.login(
      email: _emailController.text.trim(),
      password: _passwordController.text,
    );

    if (!mounted) return;

    setState(() => _isLoading = false);
    if ((res['http_status'] as int?) == 200) {
      Navigator.of(context).pushReplacement(
        MaterialPageRoute(builder: (_) => const HomeScreen()),
      );
      return;
    }

    setState(() => _error = (res['message'] ?? 'Échec de connexion').toString());
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Connexion')),
      body: Padding(
        padding: const EdgeInsets.all(16),
        child: Form(
          key: _formKey,
          child: Column(
            children: [
              TextFormField(
                controller: _emailController,
                decoration: const InputDecoration(labelText: 'Email'),
                validator: (v) => (v == null || v.isEmpty) ? 'Champ requis' : null,
              ),
              const SizedBox(height: 12),
              TextFormField(
                controller: _passwordController,
                obscureText: true,
                decoration: const InputDecoration(labelText: 'Mot de passe'),
                validator: (v) => (v == null || v.length < 6) ? 'Min 6 caractères' : null,
              ),
              const SizedBox(height: 16),
              if (_error != null) Text(_error!, style: const TextStyle(color: Colors.red)),
              const SizedBox(height: 12),
              ElevatedButton(
                onPressed: _isLoading ? null : _submit,
                child: Text(_isLoading ? 'Connexion...' : 'Se connecter'),
              ),
            ],
          ),
        ),
      ),
    );
  }
}

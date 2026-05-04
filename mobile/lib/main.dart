import 'package:flutter/material.dart';
import 'package:mobile/screens/home_screen.dart';
import 'package:mobile/screens/login_screen.dart';
import 'package:mobile/services/auth_service.dart';

Future<void> main() async {
  WidgetsFlutterBinding.ensureInitialized();
  final hasSession = await AuthService().hasValidSession();
  runApp(PacInternshipApp(startOnHome: hasSession));
}

class PacInternshipApp extends StatelessWidget {
  const PacInternshipApp({super.key, required this.startOnHome});

  final bool startOnHome;

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'PAC Internship Manager',
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(seedColor: Colors.blue),
        useMaterial3: true,
      ),
      home: startOnHome ? const HomeScreen() : const LoginScreen(),
    );
  }
}

import 'package:mobile/models/user_model.dart';
import 'package:mobile/services/api_client.dart';
import 'package:shared_preferences/shared_preferences.dart';

class AuthService {
  static const _tokenKey = 'auth_token';
  final ApiClient _api = ApiClient();

  Future<bool> hasValidSession() async {
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString(_tokenKey);
    return token != null && token.isNotEmpty;
  }

  Future<String?> token() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString(_tokenKey);
  }

  Future<Map<String, dynamic>> login({
    required String email,
    required String password,
  }) async {
    final response = await _api.post('/auth/login', body: {
      'email': email,
      'password': password,
    });

    final token = (response['data']?['token'] ?? '') as String;
    if (response['http_status'] == 200 && token.isNotEmpty) {
      final prefs = await SharedPreferences.getInstance();
      await prefs.setString(_tokenKey, token);
    }

    return response;
  }

  Future<void> logout() async {
    final t = await token();
    if (t != null && t.isNotEmpty) {
      await _api.post('/auth/logout', token: t);
    }
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove(_tokenKey);
  }

  Future<UserModel?> me() async {
    final t = await token();
    if (t == null) return null;
    final response = await _api.get('/auth/me', token: t);
    if (response['http_status'] == 200 && response['data'] is Map<String, dynamic>) {
      return UserModel.fromJson(response['data'] as Map<String, dynamic>);
    }
    return null;
  }
}

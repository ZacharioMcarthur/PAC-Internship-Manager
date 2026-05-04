import 'package:mobile/services/api_client.dart';
import 'package:mobile/services/auth_service.dart';

class ActivityService {
  final ApiClient _api = ApiClient();
  final AuthService _auth = AuthService();

  Future<Map<String, dynamic>> list() async {
    final token = await _auth.token();
    return _api.get('/activites', token: token);
  }

  Future<Map<String, dynamic>> create({
    required String date,
    required String titre,
    required String description,
  }) async {
    final token = await _auth.token();
    return _api.post('/activites', token: token, body: {
      'date': date,
      'titre': titre,
      'description': description,
    });
  }
}

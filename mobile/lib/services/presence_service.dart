import 'package:geolocator/geolocator.dart';
import 'package:mobile/services/api_client.dart';
import 'package:mobile/services/auth_service.dart';

class PresenceService {
  final ApiClient _api = ApiClient();
  final AuthService _auth = AuthService();

  Future<Position> _currentPosition() async {
    final serviceEnabled = await Geolocator.isLocationServiceEnabled();
    if (!serviceEnabled) {
      throw Exception('La géolocalisation est désactivée');
    }

    var permission = await Geolocator.checkPermission();
    if (permission == LocationPermission.denied) {
      permission = await Geolocator.requestPermission();
    }
    if (permission == LocationPermission.deniedForever || permission == LocationPermission.denied) {
      throw Exception('Permission GPS refusée');
    }

    return Geolocator.getCurrentPosition();
  }

  Future<Map<String, dynamic>> checkIn() async {
    final token = await _auth.token();
    final pos = await _currentPosition();
    return _api.post('/presences/check-in', token: token, body: {
      'latitude': pos.latitude,
      'longitude': pos.longitude,
    });
  }

  Future<Map<String, dynamic>> checkOut() async {
    final token = await _auth.token();
    final pos = await _currentPosition();
    return _api.post('/presences/check-out', token: token, body: {
      'latitude': pos.latitude,
      'longitude': pos.longitude,
    });
  }

  Future<Map<String, dynamic>> listMine() async {
    final token = await _auth.token();
    return _api.get('/presences', token: token);
  }
}

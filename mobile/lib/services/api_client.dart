import 'dart:convert';

import 'package:http/http.dart' as http;
import 'package:mobile/config/app_config.dart';

class ApiClient {
  Uri _uri(String path) => Uri.parse('${AppConfig.baseUrl}$path');

  Future<Map<String, dynamic>> get(String path, {String? token}) async {
    final response = await http.get(_uri(path), headers: _headers(token));
    return _decode(response);
  }

  Future<Map<String, dynamic>> post(
    String path, {
    String? token,
    Map<String, dynamic>? body,
  }) async {
    final response = await http.post(
      _uri(path),
      headers: _headers(token),
      body: jsonEncode(body ?? {}),
    );
    return _decode(response);
  }

  Map<String, String> _headers(String? token) {
    return {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      if (token != null && token.isNotEmpty) 'Authorization': 'Bearer $token',
    };
  }

  Map<String, dynamic> _decode(http.Response response) {
    final payload = response.body.isNotEmpty
        ? jsonDecode(response.body) as Map<String, dynamic>
        : <String, dynamic>{};

    payload['http_status'] = response.statusCode;
    return payload;
  }
}

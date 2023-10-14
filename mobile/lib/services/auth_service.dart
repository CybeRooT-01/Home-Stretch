import 'dart:convert';

import 'package:http/http.dart' as http;
import 'package:mobile/services/global.dart';

class AuthService {
  static Future<http.Response> login(String login, String password) async {
    Map data = {"login": login, "password": password};
    var body = json.encode(data);
    var url = Uri.parse('$baseUrl/login');
    http.Response response = await http.post(
      url,
      headers: headers,
      body: body,
    );
    return response;
  }
}

// ignore_for_file: use_build_context_synchronously

import 'dart:convert';

import 'package:dio/dio.dart';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:mobile/services/global.dart';
import 'package:mobile/shared/auth_interceptor.dart';
import 'package:mobile/views/dashboard.view.dart';
import 'package:mobile/views/login.view.dart';
import 'package:shared_preferences/shared_preferences.dart';

class AuthService {
  final Dio _dio = Dio();

  intercept() {
    _dio.interceptors.add(AuthInterceptor());
  }

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

  static Future<void> authenticateUser(
      BuildContext context, String login, String password) async {
    if (login.isNotEmpty && password.isNotEmpty) {
      final response = await AuthService.login(login, password);
      if (response.statusCode == 200) {
        final Map<String, dynamic> responseData = json.decode(response.body);
        final String token = responseData['token'];
        final SharedPreferences prefs = await SharedPreferences.getInstance();
        await prefs.setString('token', token);
        Navigator.push(
          context,
          MaterialPageRoute(
            builder: (context) => const Dashboard(),
          ),
        );
      } else {
        errorSnackBar(context, 'Échec de la connexion');
      }
    } else {
      errorSnackBar(context, 'Veuillez remplir tous les champs');
    }
  }

  static Future<void> logout(context) async {
    var url = Uri.parse('$baseUrl/logout');
    final dio = Dio();
    dio.interceptors.add(AuthInterceptor());
    final response = await dio.post(url.toString());
    if (response.statusCode == 200) {
      final SharedPreferences prefs = await SharedPreferences.getInstance();
      await prefs.remove('token');
      Navigator.push(
        context,
        MaterialPageRoute(
          builder: (context) => const Login(),
        ),
      );
    } else {
      errorSnackBar(context, 'Échec de la déconnexion');
    }
  }
}

import 'package:flutter/material.dart';

const String baseUrl = 'http://10.0.2.2:8000/api';
Map<String, String> headers = {'Content-Type': 'application/json'};
errorSnackBar(BuildContext context, String text) {
  ScaffoldMessenger.of(context).showSnackBar(
    SnackBar(
      backgroundColor: Colors.red,
      content: Text(text),
      duration: const Duration(seconds: 1),
    ),
  );
}

succsessSnackBar(BuildContext context, String text) {
  ScaffoldMessenger.of(context).showSnackBar(
    SnackBar(
      backgroundColor: Colors.green,
      content: Text(text),
      duration: const Duration(seconds: 1),
    ),
  );
}

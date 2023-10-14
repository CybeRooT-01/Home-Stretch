// // ignore_for_file: use_build_context_synchronously
// ignore_for_file: use_build_context_synchronously

import 'package:flutter/material.dart';
import 'package:mobile/services/auth_service.dart';
import 'package:mobile/services/global.dart';
import 'package:mobile/utils/global.colors.dart';
import 'package:mobile/views/dashboard.view.dart';
import 'package:mobile/widgets/text.form.global.dart';

class Login extends StatefulWidget {
  const Login({super.key});

  @override
  State<Login> createState() => _LoginState();
}

class _LoginState extends State<Login> {
  final TextEditingController emailController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();
  loginPressed(BuildContext context) {
    _authenticateUser(context);
  }

  Future<void> _authenticateUser(BuildContext context) async {
    final String login = emailController.text;
    final String password = passwordController.text;
    if (login.isNotEmpty && password.isNotEmpty) {
      final response = await AuthService.login(login, password);
      if (response.statusCode == 200) {
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

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SingleChildScrollView(
        child: Column(
          children: <Widget>[
            Container(
              height: MediaQuery.of(context).size.height * 0.5,
              decoration: const BoxDecoration(
                image: DecorationImage(
                  image: AssetImage('assets/wave.png'),
                  fit: BoxFit.cover,
                ),
              ),
            ),
            Container(
              padding: const EdgeInsets.all(6.0),
              child: Column(
                children: [
                  SizedBox(
                    width: 350,
                    child: TextFormGlobal(
                      controller: emailController,
                      text: "email",
                      obscure: false,
                      textInputType: TextInputType.emailAddress,
                    ),
                  ),
                  const SizedBox(height: 30),
                  SizedBox(
                    width: 350,
                    child: TextFormGlobal(
                      controller: passwordController,
                      obscure: true,
                      text: "mot de passe",
                      textInputType: TextInputType.text,
                    ),
                  ),
                  const SizedBox(height: 30),
                  ElevatedButton(
                    onPressed: () => loginPressed(context),
                    style: ElevatedButton.styleFrom(
                      minimumSize: const Size(200, 50),
                      backgroundColor: GlobalColors.mainColor,
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(50),
                      ),
                    ),
                    child: const Text(
                      'Se connecter',
                      style: TextStyle(
                        color: Colors.white,
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}

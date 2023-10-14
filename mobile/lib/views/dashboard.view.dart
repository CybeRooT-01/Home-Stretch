import 'package:flutter/material.dart';
import 'package:mobile/services/auth_service.dart';
import 'package:mobile/utils/global.colors.dart';

class Dashboard extends StatefulWidget {
  const Dashboard({super.key});

  @override
  State<Dashboard> createState() => _DashboardState();
}

class _DashboardState extends State<Dashboard> {
  deconnexion(context) async {
    await AuthService.logout(context);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      //faire un appbar avec un bouton de deconnexion
      appBar: AppBar(
        automaticallyImplyLeading: false,
        backgroundColor: GlobalColors.mainColor,
        title: const Text('Tableau de bord'),
        actions: [
          IconButton(
            icon: const Icon(Icons.logout),
            onPressed: () => deconnexion(context),
          ),
        ],
      ),
    );
  }
}

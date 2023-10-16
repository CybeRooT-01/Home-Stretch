import 'dart:convert';
import 'package:mobile/models/class_id_etudiant_id.dart';
import 'package:provider/provider.dart';
import 'package:flutter/material.dart';
import 'package:mobile/models/User.dart';
import 'package:mobile/services/auth_service.dart';
import 'package:mobile/shared/class_id__etudiant_id_provider.dart';
import 'package:mobile/utils/global.colors.dart';
import 'package:mobile/views/home_page.view.dart';
import 'package:mobile/views/profil.view.dart';

class Dashboard extends StatefulWidget {
  const Dashboard({super.key});

  @override
  State<Dashboard> createState() => _DashboardState();
}

class _DashboardState extends State<Dashboard> {
  late Future<User> userFuture;

  int currentPage = 0;
  int classeId = 0;
  int etudiantId = 0;

  List<Widget> pages = const [
    ProfilPage(),
    HomePage(),
  ];

  @override
  void initState() {
    super.initState();
    userFuture = AuthService.fetchCurrentUser();
  }

  deconnexion(context) async {
    await AuthService.logout(context);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        automaticallyImplyLeading: false,
        backgroundColor: GlobalColors.mainColor,
        title: FutureBuilder<User>(
          future: userFuture,
          builder: (context, snapshot) {
            if (snapshot.hasData) {
              classeId = snapshot.data!.classe.id!;
              etudiantId = snapshot.data!.etudiant.id;

              return Row(
                children: [
                  Text(snapshot.data!.nom),
                  // Text(" ${snapshot.data!.classe.id}"),
                ],
              );
            } else if (snapshot.hasError) {
              return const Text('Échec de la récupération de l\'utilisateur');
            } else {
              return const Text('Chargement de l\'utilisateur...');
            }
          },
        ),
        actions: [
          IconButton(
            icon: const Icon(Icons.logout),
            onPressed: () => deconnexion(context),
          ),
        ],
      ),
      body: ClasseIdEtudiantIdProvider(
        classeIdEtudiantId: ClasseIdEtudiantId(
          classeId: classeId,
          etudiantId: etudiantId,
        ),
        classeId: 0,
        etudiantId: 0,
        child: pages[currentPage],
      ),
      bottomNavigationBar: NavigationBar(
        destinations: const [
          NavigationDestination(icon: Icon(Icons.person), label: "profil"),
          NavigationDestination(icon: Icon(Icons.home), label: "Acceuille"),
        ],
        onDestinationSelected: (int index) {
          setState(() {
            currentPage = index;
          });
        },
        selectedIndex: currentPage,
      ),
    );
  }
}

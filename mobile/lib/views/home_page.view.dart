import 'package:flutter/material.dart';
import 'package:mobile/models/Session_cours.dart';
import 'package:mobile/services/dashboard_service.dart';
import 'package:mobile/utils/global.colors.dart';

class HomePage extends StatefulWidget {
  const HomePage({super.key});
  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  late Future<List<SessionCour>> sessionCourFuture;
  @override
  void initState() {
    super.initState();
    sessionCourFuture = DashboardService.getSessionsCours();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: FutureBuilder<List<SessionCour>>(
        future: sessionCourFuture,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(
              child: CircularProgressIndicator(),
            );
          } else if (snapshot.hasData) {
            final sessions = snapshot.data;
            return ListView.builder(
              itemCount: sessions!.length,
              itemBuilder: (context, index) {
                final session = sessions[index];
                return Card(
                  elevation: 5,
                  margin: const EdgeInsets.all(16),
                  child: Padding(
                    padding: const EdgeInsets.all(16),
                    child: Column(
                      children: [
                        Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            Text('Date: ${session.date}'),
                            IconButton(
                              icon: const Icon(Icons.fingerprint),
                              color: GlobalColors.mainColor,
                              iconSize: 40,
                              onPressed: () {
                                //marquer presence
                              },
                              tooltip: 'Marquer la présence',
                            ),
                          ],
                        ),
                        const SizedBox(height: 10),
                        Text('Heure de début: ${session.heureDebut}'),
                        Text('Heure de fin: ${session.heureFin}'),
                        Text('Salle: ${session.salle!.nom}'),
                        Text('Professeur: ${session.cours!.nomProfesseur}'),
                      ],
                    ),
                  ),
                );
              },
            );
          } else if (snapshot.hasError) {
            return Center(
              child: Text(
                  'Échec de la récupération des données: ${snapshot.error.toString()}'),
            );
          } else {
            return const Center(
              child: Text('Aucune donnée disponible'),
            );
          }
        },
      ),
    );
  }
}

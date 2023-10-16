import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:mobile/models/Session_cours.dart';
import 'package:mobile/services/dashboard_service.dart';
import 'package:mobile/shared/class_id__etudiant_id_provider.dart';
import 'package:mobile/utils/global.colors.dart';

class HomePage extends StatefulWidget {
  const HomePage({super.key});

  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  late Future<List<SessionCour>> sessionCourFuture;
  int classeId = 0;
  int etudiantId = 0;

  @override
  void initState() {
    super.initState();
    sessionCourFuture = DashboardService.getSessionsCours();
  }

  marquerPresence(context, session) async {
    int sessId = session.id;
    var date = session.date;
    date = date.replaceAll('-', '/');
    print(date);
    var etudiantId = await ClasseIdEtudiantIdProvider.of(context)
        .classeIdEtudiantId
        .etudiantId;
    await DashboardService.marquerPresence(context, etudiantId, sessId, date);
    // print(sss.message);
  }

  @override
  Widget build(BuildContext context) {
    var classeId =
        ClasseIdEtudiantIdProvider.of(context).classeIdEtudiantId.classeId;
    var etudiantId =
        ClasseIdEtudiantIdProvider.of(context).classeIdEtudiantId.etudiantId;

    return FutureBuilder<List<SessionCour>>(
      future: sessionCourFuture,
      builder: (context, snapshot) {
        if (snapshot.connectionState == ConnectionState.waiting) {
          return const Center(
            child: CircularProgressIndicator(),
          );
        } else if (snapshot.hasData && snapshot.data!.isNotEmpty) {
          final sessions = snapshot.data;
          final filteredSessions = sessions!.where((session) {
            return session.classe!.id == classeId;
          }).toList();
          return ListView.builder(
            itemCount: filteredSessions.length,
            itemBuilder: (context, index) {
              final session = filteredSessions[index];
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
                          // Text('Classe: $classeId'),
                          // Text('etudiant: $etudiantId'),
                          IconButton(
                            icon: const Icon(Icons.fingerprint),
                            color: GlobalColors.mainColor,
                            iconSize: 40,
                            onPressed: () => marquerPresence(context, session),
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
            child: Text(
              'Aucune session de cours trouvée',
              style: TextStyle(color: Colors.red),
            ),
          );
        }
      },
    );
  }
}
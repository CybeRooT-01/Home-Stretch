import 'package:dio/dio.dart';
import 'package:mobile/models/Session_cours.dart';
import 'package:mobile/services/global.dart';
import 'package:mobile/shared/auth_interceptor.dart';

class DashboardService {
  static Future<List<SessionCour>> getSessionsCours() async {
    var url = Uri.parse('$baseUrl/sessioncours');
    final dio = Dio();
    dio.interceptors.add(AuthInterceptor());
    final response = await dio.get(url.toString());
    if (response.statusCode == 200) {
      List<dynamic> jsonData = response.data;
      List<SessionCour> sessions = [];
      for (var item in jsonData) {
        sessions.add(SessionCour.fromJson(item));
      }
      return sessions;
    } else {
      throw Exception('Échec de la récupération des sessions de cours');
    }
  }

  static Future marquerPresence(
      context, int etudiantId, int sessionId, date) async {
    var url = Uri.parse('$baseUrl/absence');
    final dio = Dio();
    dio.interceptors.add(AuthInterceptor());
    var data = {
      "etudiant_id": etudiantId,
      "sessionCours_id": sessionId,
      "date": date
    };

    final response = await dio.post(url.toString(), data: {
      "etudiant_id": etudiantId,
      "sessionCours_id": sessionId,
      "date": date
    });
    if (response.statusCode == 201) {
      succsessSnackBar(context, 'Présence marquée avec succès');
      return response.data;
    } else {
      errorSnackBar(context, response.data['message']);
    }
  }
}

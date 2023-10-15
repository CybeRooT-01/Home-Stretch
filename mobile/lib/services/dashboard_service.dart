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
}

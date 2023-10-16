// ignore_for_file: non_constant_identifier_names

class User {
  final int id;
  final String nom;
  final String login;
  final String email;
  final String role;
  final Etudiant etudiant;
  final Classe classe;

  User({
    required this.id,
    required this.nom,
    required this.login,
    required this.email,
    required this.role,
    required this.etudiant,
    required this.classe,
  });

  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      id: json['data']['id'],
      nom: json['data']['nom'],
      login: json['data']['login'],
      email: json['data']['email'],
      role: json['data']['role'],
      etudiant: Etudiant.fromJson(json['data']['etudiant']),
      classe: Classe.fromJson(json['data']['classe']),
    );
  }
}

class Etudiant {
  final int id;
  final int user_id;
  final String nomComplet;
  final String email;
  final String matricule;

  Etudiant({
    required this.id,
    required this.user_id,
    required this.nomComplet,
    required this.email,
    required this.matricule,
  });

  factory Etudiant.fromJson(Map<String, dynamic> json) {
    return Etudiant(
      id: json['id'],
      user_id: json['user_id'],
      nomComplet: json['nomComplet'],
      email: json['email'],
      matricule: json['matricule'],
    );
  }
}

class Classe {
  int? id;
  int? annee_id;
  String libelle;
  String filiere;
  String niveau;
  int etat;

  Classe({
    required this.id,
    required this.annee_id,
    required this.libelle,
    required this.filiere,
    required this.niveau,
    required this.etat,
  });

  factory Classe.fromJson(Map<String, dynamic> json) {
    return Classe(
      id: json['id'],
      annee_id: json['annee_id'],
      libelle: json['libelle'],
      filiere: json['filiere'],
      niveau: json['niveau'],
      etat: json['etat'],
    );
  }
}

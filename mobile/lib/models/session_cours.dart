// ignore_for_file: unnecessary_new, unnecessary_this, prefer_collection_literals

class SessionCour {
  int? id;
  String? date;
  String? heureDebut;
  String? heureFin;
  int? validee;
  Salle? salle;
  Cours? cours;
  Classe? classe;

  SessionCour(
      {this.id,
      this.date,
      this.heureDebut,
      this.heureFin,
      this.validee,
      this.salle,
      this.cours,
      this.classe});

  SessionCour.fromJson(Map<String, dynamic> json) {
    id = json['id'];
    date = json['date'];
    heureDebut = json['heure_debut'];
    heureFin = json['heure_fin'];
    validee = json['validee'];
    salle = json['salle'] != null ? new Salle.fromJson(json['salle']) : null;
    cours = json['cours'] != null ? new Cours.fromJson(json['cours']) : null;
    classe =
        json['classe'] != null ? new Classe.fromJson(json['classe']) : null;
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['id'] = this.id;
    data['date'] = this.date;
    data['heure_debut'] = this.heureDebut;
    data['heure_fin'] = this.heureFin;
    data['validee'] = this.validee;
    if (this.salle != null) {
      data['salle'] = this.salle!.toJson();
    }
    if (this.cours != null) {
      data['cours'] = this.cours!.toJson();
    }
    if (this.classe != null) {
      data['classe'] = this.classe!.toJson();
    }
    return data;
  }
}

class Salle {
  int? id;
  String? nom;
  String? numero;
  String? capacite;

  Salle({this.id, this.nom, this.numero, this.capacite});

  Salle.fromJson(Map<String, dynamic> json) {
    id = json['id'];
    nom = json['nom'];
    numero = json['numero'];
    capacite = json['capacite'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['id'] = this.id;
    data['nom'] = this.nom;
    data['numero'] = this.numero;
    data['capacite'] = this.capacite;
    return data;
  }
}

class Cours {
  int? id;
  String? quotaHoraireGlobale;
  String? module;
  String? nomProfesseur;
  int? idProfesseur;
  String? specialiteProfesseur;
  String? gradeProfeseur;

  Cours(
      {this.id,
      this.quotaHoraireGlobale,
      this.module,
      this.nomProfesseur,
      this.idProfesseur,
      this.specialiteProfesseur,
      this.gradeProfeseur});

  Cours.fromJson(Map<String, dynamic> json) {
    id = json['id'];
    quotaHoraireGlobale = json['quota_horaire_globale'];
    module = json['module'];
    nomProfesseur = json['nom_professeur'];
    idProfesseur = json['idProfesseur'];
    specialiteProfesseur = json['specialite_professeur'];
    gradeProfeseur = json['grade_profeseur'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['id'] = this.id;
    data['quota_horaire_globale'] = this.quotaHoraireGlobale;
    data['module'] = this.module;
    data['nom_professeur'] = this.nomProfesseur;
    data['idProfesseur'] = this.idProfesseur;
    data['specialite_professeur'] = this.specialiteProfesseur;
    data['grade_profeseur'] = this.gradeProfeseur;
    return data;
  }
}

class Classe {
  int? id;
  int? anneeId;
  String? libelle;
  String? filiere;
  String? niveau;
  int? etat;

  Classe(
      {this.id,
      this.anneeId,
      this.libelle,
      this.filiere,
      this.niveau,
      this.etat});

  Classe.fromJson(Map<String, dynamic> json) {
    id = json['id'];
    anneeId = json['annee_id'];
    libelle = json['libelle'];
    filiere = json['filiere'];
    niveau = json['niveau'];
    etat = json['etat'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['id'] = this.id;
    data['annee_id'] = this.anneeId;
    data['libelle'] = this.libelle;
    data['filiere'] = this.filiere;
    data['niveau'] = this.niveau;
    data['etat'] = this.etat;
    return data;
  }
}

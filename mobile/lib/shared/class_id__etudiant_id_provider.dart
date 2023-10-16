import 'package:flutter/material.dart';
import 'package:mobile/models/class_id_etudiant_id.dart';

class ClasseIdEtudiantIdProvider extends InheritedWidget {
  final ClasseIdEtudiantId  classeIdEtudiantId;

  const ClasseIdEtudiantIdProvider(
      {Key? key, required this.classeIdEtudiantId, required Widget child, required int classeId, required int etudiantId})
      : super(key: key, child: child);

  static ClasseIdEtudiantIdProvider of(BuildContext context) {
    final provider = context
        .dependOnInheritedWidgetOfExactType<ClasseIdEtudiantIdProvider>();
    if (provider == null) {
      throw FlutterError.fromParts(
        <DiagnosticsNode>[
          ErrorSummary("nope !!! cherche ailleurs ton classID."),
        ],
      );
    }
    return provider;
  }

  @override
  bool updateShouldNotify(ClasseIdEtudiantIdProvider oldWidget) =>
      classeIdEtudiantId != oldWidget.classeIdEtudiantId;
}

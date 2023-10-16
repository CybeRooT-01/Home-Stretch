import 'package:flutter/material.dart';

class EtudiantIdProvider extends InheritedWidget {
  final int etudiantId;

  const EtudiantIdProvider(
      {Key? key, required this.etudiantId, required Widget child})
      : super(key: key, child: child);

  static EtudiantIdProvider of(BuildContext context) {
    final provider =
        context.dependOnInheritedWidgetOfExactType<EtudiantIdProvider>();
    if (provider == null) {
      throw FlutterError.fromParts(
        <DiagnosticsNode>[
          ErrorSummary("etudaint id introivable dans ce context."),
        ],
      );
    }
    return provider;
  }

  @override
  bool updateShouldNotify(EtudiantIdProvider oldWidget) =>
      etudiantId != oldWidget.etudiantId;
}

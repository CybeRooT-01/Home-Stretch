import 'package:flutter/material.dart';

class ClassIdProvider extends InheritedWidget {
  final int classId;

  const ClassIdProvider(
      {Key? key, required this.classId, required Widget child})
      : super(key: key, child: child);

  static ClassIdProvider? of(BuildContext context) {
    return context.dependOnInheritedWidgetOfExactType<ClassIdProvider>();
  }

  @override
  bool updateShouldNotify(ClassIdProvider oldWidget) =>
      classId != oldWidget.classId;
}

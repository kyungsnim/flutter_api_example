import 'package:flutter/material.dart';
import 'package:flutter_api_example/screens/create.dart';
import 'package:flutter_api_example/screens/details.dart';
import 'package:flutter_api_example/screens/edit.dart';
import 'package:flutter_api_example/screens/home.dart';

void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Flutter + PHP CRUD',
      initialRoute: '/',
      routes: {
        '/': (context) => Home(),
        '/create': (context) => Create(),
        '/details': (context) => Details(),
        '/edit': (context) => Edit(),
      },
    );
  }
}

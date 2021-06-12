import 'package:dio/dio.dart';
import 'package:flutter/material.dart';
import 'dart:convert';

import 'package:http/http.dart' as http;
import '../env.dart';
import '../models/student.dart';
import './details.dart';
import './create.dart';

class Home extends StatefulWidget {
  Home({Key key}) : super(key: key);
  @override
  HomeState createState() => HomeState();
}

class HomeState extends State<Home> {
  Future<List<Student>> students;
  final studentListKey = GlobalKey<HomeState>();
  Dio dio = Dio();

  @override
  void initState() {
    super.initState();
    students = getStudentList();
  }

  Future<List<Student>> getStudentList() async {
    var responseWithDio;
    List<Student> students;

    // Dio 이용하여 통신
    try {
      // 서버로 요청
      responseWithDio = await dio.get("${Env.URL_PREFIX}/list.php");

      students = (responseWithDio.data).map<Student>((json) {
        return Student.fromJson(json);
      }).toList();
    } catch (e) {
      print(e);
    }

    return students;
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      key: studentListKey,
      appBar: AppBar(
        title: Text('Dio, mysqli 이용한 CRUD'),
      ),
      body: Center(
        child: FutureBuilder<List<Student>>(
          future: students,
          builder: (BuildContext context, AsyncSnapshot snapshot) {
            // By default, show a loading spinner.
            if (!snapshot.hasData) return CircularProgressIndicator();
            // Render student lists
            return ListView.builder(
              itemCount: snapshot.data.length,
              itemBuilder: (BuildContext context, int index) {
                var data = snapshot.data[index];
                return Card(
                  child: ListTile(
                    leading: Icon(Icons.person),
                    trailing: Icon(Icons.view_list),
                    title: Text(
                      data.name,
                      style: TextStyle(fontSize: 20),
                    ),
                    onTap: () {
                      Navigator.push(
                        context,
                        MaterialPageRoute(
                            builder: (context) => Details(student: data)),
                      );
                    },
                  ),
                );
              },
            );
          },
        ),
      ),
      floatingActionButton: FloatingActionButton(
        child: Icon(Icons.add),
        onPressed: () {
          Navigator.push(context, MaterialPageRoute(builder: (_) {
            return Create();
          }));
        },
      ),
    );
  }
}

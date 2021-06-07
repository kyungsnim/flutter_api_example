import 'package:dio/dio.dart';
import 'package:flutter/material.dart';

import '../env.dart';
import '../models/student.dart';
import '../widgets/form.dart';
import 'home.dart';

class Edit extends StatefulWidget {
  final Student student;

  Edit({this.student});

  @override
  _EditState createState() => _EditState();
}

class _EditState extends State<Edit> {
  // This is  for form validations
  final formKey = GlobalKey<FormState>();

  // This is for text onChange
  TextEditingController nameController;
  TextEditingController ageController;

  Response response;
  var dio = Dio();

  // Dio post request
  Future editStudent() async {
    return await dio.post("${Env.URL_PREFIX}/update.php", data: {
      "id": widget.student.id.toString(),
      "name": nameController.text,
      "age": ageController.text
    });
  }

  void _onConfirm(context) async {
    await editStudent();
  }

  @override
  void initState() {
    nameController = TextEditingController(text: widget.student.name);
    ageController = TextEditingController(text: widget.student.age.toString());
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Edit"),
      ),
      bottomNavigationBar: BottomAppBar(
        child: RaisedButton(
          child: Text('CONFIRM'),
          color: Colors.blue,
          textColor: Colors.white,
          onPressed: () {
            _onConfirm(context);
            Navigator.of(context)
                .pushNamedAndRemoveUntil('/', (Route<dynamic> route) => false);
          },
        ),
      ),
      body: Container(
        height: double.infinity,
        padding: EdgeInsets.all(20),
        child: Center(
          child: Padding(
            padding: EdgeInsets.all(12),
            child: AppForm(
              formKey: formKey,
              nameController: nameController,
              ageController: ageController,
            ),
          ),
        ),
      ),
    );
  }
}

class Student {
  final int id;
  final String name;
  final int age;
  final String createdAt;

  Student({this.id, this.name, this.age, this.createdAt});

  factory Student.fromJson(Map<String, dynamic> json) {
    return Student(
        id: int.parse(json['id']),
        name: json['name'],
        age: int.parse(json['age']),
        createdAt: json['createdAt']);
  }

  Map<String, dynamic> toJson() =>
      {'name': name, 'age': age, 'createdAt': createdAt};
}

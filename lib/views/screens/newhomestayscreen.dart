import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:geolocator/geolocator.dart';
import 'package:http/http.dart' as http;
import 'package:os/serverconfig.dart';
import 'package:permission_handler/permission_handler.dart';
import 'package:geocoding/geocoding.dart';
import '../../models/user.dart';
import 'LoginScreen.dart';

void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'User Location',
      theme: ThemeData(
        primarySwatch: Colors.blue,
      ),
      // Add routes for navigation
      routes: {
  
        '/login': (context) => LoginScreen(),
      },
    );
  }
}

class MyHomePage extends StatefulWidget {
  final User user;

  const MyHomePage({super.key, required this.user});
  @override
  _MyHomePageState createState() => _MyHomePageState();
}

class _MyHomePageState extends State<MyHomePage> {
  String? userName;
  String? userId;
  String latitude = '';
  String longitude = '';
  String locality = '';
  String state = '';

  Future<void> getLocation() async {
    var status = await Permission.location.request();

    if (status.isGranted) {
      Position position = await Geolocator.getCurrentPosition(
        desiredAccuracy: LocationAccuracy.high,
      );
      setState(() {
        latitude = position.latitude.toString();
        longitude = position.longitude.toString();
      });

      getAddressFromCoordinates();
    } else {
      print('Location permission denied');
    }
  }

  void getAddressFromCoordinates() async {
    try {
      List<Placemark> placemarks = await placemarkFromCoordinates(
        double.parse(latitude),
        double.parse(longitude),
      );

      if (placemarks.isNotEmpty) {
        Placemark placemark = placemarks[0];
        setState(() {
          locality = placemark.locality ?? 'N/A';
          state = placemark.administrativeArea ?? 'N/A';
        });

        sendDataToDatabase();
      }
    } catch (e) {
      print('Error retrieving address: $e');
    }
  }

  void sendDataToDatabase() async {
    final url = Uri.parse('${Config.SERVER}/php/insert_homestay.php');

    final response = await http.post(
      url,
      body: {
        'userid': userId ?? '',
        'name': userName ?? '',
        'state': state,
        'local': locality,
        'lat': latitude,
        'lon': longitude,
      },
    );

    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      if (data['status'] == 'success') {
        Fluttertoast.showToast(
          msg: 'Success',
          toastLength: Toast.LENGTH_SHORT,
          gravity: ToastGravity.BOTTOM,
          timeInSecForIosWeb: 1,
          fontSize: 14.0,
        );
        // Clear the input fields after successful insertion
        setState(() {
          userName = null;
          userId = null;
        });
      } else {
        Fluttertoast.showToast(
          msg: 'Failed',
          toastLength: Toast.LENGTH_SHORT,
          gravity: ToastGravity.BOTTOM,
          timeInSecForIosWeb: 1,
          fontSize: 14.0,
        );
      }
    } else {
      print('Error sending data to the database!');
    }
  }

  Future<List<User>> fetchUser() async {
    final url = Uri.parse('${Config.SERVER}/php/get_user.php');
    final response = await http.get(url);
    print(userName);

    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      final userList = List<User>.from(data['data'].map((userJson) => User.fromJson(userJson)));
      return userList;
    } else {
      throw Exception('Failed to fetch user');
    }
  }

  // Add this function for logging out
  void logout() {
    // Navigate back to the login screen using the alternative approach
    Navigator.pushReplacement(context, MaterialPageRoute(builder: (context) => LoginScreen()));
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('User Location'),
        actions: [
          // Add a logout button to the app bar
          IconButton(
            icon: Icon(Icons.exit_to_app),
            onPressed: logout,
          ),
        ],
      ),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            FutureBuilder<List<User>>(
              future: fetchUser(),
              builder: (context, snapshot) {
                if (snapshot.hasData) {
                  final userList = snapshot.data!;
                  if (userList.isNotEmpty) {
                    // Automatically select the first user
                    userId = widget.user.id;
                    userName = widget.user.name;
                  }
                  return Column(
                    children: userList.map((user) => Column(
                      
                    )).toList(),
                  );
                } else if (snapshot.hasError) {
                  return Text('Error: ${snapshot.error}');
                }

                return CircularProgressIndicator();
              },
            ),
            SizedBox(height: 20),
            Text('Latitude: $latitude'),
            Text('Longitude: $longitude'),
            Text('Locality: $locality'),
            Text('State: $state'),
            SizedBox(height: 20),
            ElevatedButton(
              onPressed: getLocation,
              child: Text('Check-in'),
            ),
          ],
        ),
      ),
    );
  }
}

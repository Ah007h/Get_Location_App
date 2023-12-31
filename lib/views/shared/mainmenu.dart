import 'package:flutter/material.dart';
import 'package:os/models/user.dart';
import 'package:os/views/screens/loginscreen.dart';


class MainMenuWidget extends StatefulWidget {
  final User user;
  const MainMenuWidget({super.key, required this.user});

  @override
  State<MainMenuWidget> createState() => _MainMenuWidgetState();
}

class _MainMenuWidgetState extends State<MainMenuWidget> {
  @override
  Widget build(BuildContext context) {
    return Drawer(
      width: 250,
      elevation: 10,
      child: ListView(
        children: [
          UserAccountsDrawerHeader(
            accountEmail: Text(widget.user.email.toString()),
            accountName: Text(widget.user.name.toString()),
            currentAccountPicture: const CircleAvatar(
              radius: 30.0,
            ),
          ),
          
          
          
          ListTile(
            title: const Text('Login'),
            onTap: () {
              Navigator.pop(context);
              Navigator.pushReplacement(context,
            MaterialPageRoute(builder: (content) => const LoginScreen()));
              
            },
          ),
        ],
      ),
    );
  }
}
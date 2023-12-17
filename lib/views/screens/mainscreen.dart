import 'package:flutter/material.dart';
import 'package:os/views/screens/newhomestayscreen.dart';
import 'package:os/views/shared/mainmenu.dart';

import '../../models/user.dart';




class MainScreen extends StatefulWidget {
final User user;
  const MainScreen({super.key, required this.user});
  @override
  State<MainScreen> createState() => _MainScreenState();
}

class _MainScreenState extends State<MainScreen> {
  @override
  Widget build(BuildContext context) {
     return WillPopScope(
      onWillPop: () async => false,
      child: Scaffold(
          appBar: AppBar(title: const Text("Client")),
          body: const Center(child: Text("Client")),
          
          drawer: MainMenuWidget(user: widget.user,)),
    );
  }
}
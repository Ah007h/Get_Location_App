<!DOCTYPE html>
<html>
<head>
    <title>Admin Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
        }

        h1 {
            text-align: center;
            margin-top: 30px;
            color: #333;
        }

        .registration-container {
            max-width: 400px;
            margin: 0 auto;
            margin-top: 100px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .registration-container input[type="text"],
        .registration-container input[type="email"],
        .registration-container input[type="tel"],
        .registration-container input[type="password"] {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 3px;
            border: 1px solid #ccc;
        }

        .registration-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Admin Registration</h1>

    <div class="registration-container">
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="tel" name="phone" placeholder="Phone Number" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="repassword" placeholder="Re-Password" required>
            <input type="submit" value="Register">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Connect to the database
            $host = 'localhost';
            $username = 'root';
            $password = '';
            $database = 'os_db';

            $conn = new mysqli($host, $username, $password, $database);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Sanitize user inputs
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];
            $repassword = $_POST['repassword'];

            // Check if email already exists
            $emailExists = false;
            $checkEmailQuery = "SELECT * FROM tbl_admins WHERE admin_email = '$email'";
            $checkEmailResult = $conn->query($checkEmailQuery);
            if ($checkEmailResult->num_rows > 0) {
                $emailExists = true;
                echo "<p class='error-message'>Email already exists. Please choose a different email.</p>";
            }

            // If email doesn't exist and passwords match, save the information
            if (!$emailExists && $password === $repassword) {
                // Hash the password
                $hashedPassword = sha1($password);

                // Save the information to the database
                $saveQuery = "INSERT INTO tbl_admins (admin_name, admin_email, admin_phone, admin_password)
                              VALUES ('$name', '$email', '$phone', '$hashedPassword')";
                if ($conn->query($saveQuery) === TRUE) {
                    echo "<p>Registration successful!</p>";
                } else {
                    echo "<p class='error-message'>Registration failed. Please try again.</p>";
                }
            } elseif ($password !== $repassword) {
                echo "<p class='error-message'>Passwords do not match. Please re-enter the passwords.</p>";
            }

            // Close the database connection
            $conn->close();
        }
        ?>
    </div>
</body>
</html>

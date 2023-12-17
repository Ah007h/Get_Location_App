<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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

        .login-container {
            width: 300px;
            margin: 0 auto;
            margin-top: 100px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            box-sizing: border-box;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 3px;
            border: 1px solid #ccc;
        }

        .login-container input[type="submit"] {
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
    <script>
        function redirectToIndex() {
            window.location.href = "index.php";
        }
    </script>
</head>
<body>
    <h1>Login</h1>

    <div class="login-container">
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
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
            $email = $_POST['email'];
            $password = $_POST['password'];
            $hashedPassword = sha1($password);

            // Verify user credentials
            $sql = "SELECT * FROM tbl_admins WHERE admin_email = '$email' AND admin_password = '$hashedPassword'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Successful login
                echo "<script>redirectToIndex();</script>";
                exit();
            } else {
                // Incorrect email or password
                if (!empty($email) || !empty($password)) {
                    echo "<p class='error-message'>Incorrect email or password. Please try again.</p>";
                }
            }

            // Close the database connection
            $conn->close();
        }
        ?>
    </div>
</body>
</html>

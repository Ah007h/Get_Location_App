<!DOCTYPE html>
<html>
<head>
    <title>Location Information</title>
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

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:nth-child(odd) {
            background-color: #e6e6e6;
        }
    </style>
</head>
<body>
    <h1>Location Information</h1>

    <table>
        <tr>
            <th>Person ID</th>
            <th>User ID</th>
            <th>User Name</th>
            <th>User State</th>
            <th>User Local</th>
            <th>User Latitude</th>
            <th>User Longitude</th>
            <th>User Date</th>
        </tr>

        <?php
        // Connect to the database
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'os_db';

        $conn = new mysqli($host, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve data from the table
        $sql = "SELECT person_id, user_id, user_name, user_state, user_local, user_lat, user_long, user_date FROM tbl_locations";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            $rowColor = 0;
            while ($row = $result->fetch_assoc()) {
                $rowColor = 1 - $rowColor; // Toggle between 0 and 1
                $bgColor = $rowColor ? '#f2f2f2' : '#e6e6e6';
                echo "<tr style='background-color: ".$bgColor."'>";
                echo "<td>".$row['person_id']."</td>";
                echo "<td>".$row['user_id']."</td>";
                echo "<td>".$row['user_name']."</td>";
                echo "<td>".$row['user_state']."</td>";
                echo "<td>".$row['user_local']."</td>";
                echo "<td>".$row['user_lat']."</td>";
                echo "<td>".$row['user_long']."</td>";
                echo "<td>".$row['user_date']."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No results found</td></tr>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </table>
</body>
</html>

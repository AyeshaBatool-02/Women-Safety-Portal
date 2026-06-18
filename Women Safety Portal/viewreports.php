<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Incident Reports</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #eef2f7;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
            animation: fadeIn 0.5s ease;
        }

        table {
            width: 90%;
            max-width: 1200px;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            margin: 20px 0;
            animation: fadeIn 0.5s ease;
        }

        th, td {
            padding: 12px 20px;
            text-align: left;
            border-bottom: 1px solid #e1e1e1;
        }

        th {
            background-color: #2980b9; /* Light Blue */
            color: white;
            font-weight: bold;
        }

        td:nth-child(4), /* Phone */
        td:nth-child(8), /* Details */
        td:nth-child(6), /* Date */
        td:nth-child(7) { /* Time */
            white-space: nowrap;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        tbody tr {
            animation: fadeIn 0.5s ease;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f0f0f0;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }


    </style>
</head>
<body>
<div class="container">
    <h1>Incident Reports</h1>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Location</th>
            <th>Date</th>
            <th>Time</th>
            <th>Details</th>
            <th>Witnesses</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Database connection parameters
        $servername = "localhost";
        $username = "root"; // Replace with your MySQL username
        $password = ""; // Replace with your MySQL password
        $dbname = "dbs_contact"; // Replace with your MySQL database name

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve incident reports data from the database
        $sql = "SELECT * FROM incident_reports";
        $result = $conn->query($sql);

        // Check if there are any incident reports
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["name"] . "</td>
                <td>" . $row["email"] . "</td>
                <td>" . $row["phone"] . "</td>
                <td>" . $row["location"] . "</td>
                <td>" . $row["date"] . "</td>
                <td>" . $row["time"] . "</td>
                <td>" . $row["details"] . "</td>
                <td>" . $row["witnesses"] . "</td>
            </tr>";
            }
        } else {
            echo "<tr><td colspan='9'>0 results</td></tr>";
        }
        $conn->close();
        ?>
        </tbody>
    </table>
</div>
</body>
</html>

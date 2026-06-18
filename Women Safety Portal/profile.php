<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbs_contact";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['id'];

// Fetch user profile details
$user_query = $conn->prepare("SELECT username, Email FROM users WHERE id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_result = $user_query->get_result()->fetch_assoc();

$username = isset($user_result['username']) ? $user_result['username'] : '';
$email = isset($user_result['Email']) ? $user_result['Email'] : '';

// Fetch user reports
$report_query = $conn->prepare("SELECT * FROM incident_reports WHERE user_id = ?");
$report_query->bind_param("i", $user_id);
$report_query->execute();
$report_result = $report_query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ecf0f1;
        }
        .heading{
            text-align: center;
            font-size: 3rem;
            color:#333;
            padding:1rem;
            margin:2rem 0;

        }

        .heading span{
            color:rgb(38, 143, 208);
        }

        h1 {
            color: #2c3e50;
            text-align: center;
            margin-top: 20px;
        }

        p {
            color: #34495e;
            font-size: 18px;
            text-align: center;
            margin-top: 10px;
        }

        h2 {
            color: #2c3e50;
            text-align: center;
            margin-top: 40px;
            font-size: 24px;
        }

        div {
            background-color: #fff;
            margin: 20px auto;
            padding: 20px;
            width: 80%;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h3 {
            color: #2c3e50;
            margin-top: 0;
        }

        p {
            color: #34495e;
            margin: 5px 0;
        }

        /* Custom styling */
        h1, h2, h3, p {
            color: rgb(38, 143, 208);
        }

        div {
            border: 2px solid #e67e22; /* Orange */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body background="bg5.jpg">
<h1 class="heading">Welcome,<span> <?php echo htmlspecialchars($username); ?></span></h1>


<h1 class="heading"> Incident <span>Reports</span> </h1>
<?php
if ($report_result && $report_result->num_rows > 0) {
    while ($report = $report_result->fetch_assoc()) {
        echo "<div>";
        echo "<h3>Report ID: " . htmlspecialchars($report['id']) . "</h3>";
        echo "<p>Name: " . htmlspecialchars($report['name']) . "</p>";
        echo "<p>Email: " . htmlspecialchars($report['email']) . "</p>";
        echo "<p>Phone: " . htmlspecialchars($report['phone']) . "</p>";
        echo "<p>Location: " . htmlspecialchars($report['location']) . "</p>";
        echo "<p>Date: " . htmlspecialchars($report['date']) . "</p>";
        echo "<p>Time: " . htmlspecialchars($report['time']) . "</p>";
        echo "<p>Details: " . htmlspecialchars($report['details']) . "</p>";
        echo "<p>Witnesses: " . htmlspecialchars($report['witnesses']) . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>No incident reports found.</p>";
}
?>
</body>
</html>

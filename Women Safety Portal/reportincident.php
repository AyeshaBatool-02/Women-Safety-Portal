<?php
session_start();

$submitMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    if (!isset($_SESSION['id'])) {
        die("User is not logged in.");
    }

    $user_id = $_SESSION['id'];

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO incident_reports (user_id, name, email, phone, location, date, time, details, witnesses) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssss", $user_id, $name, $email, $phone, $location, $date, $time, $details, $witnesses);

    // Set parameters and execute
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $details = $_POST['details'];
    $witnesses = $_POST['witnesses'];

    $stmt->execute();

    $submitMessage = "Form submitted successfully";

    $stmt->close();
    $conn->close();

    // Set session variable to control success message visibility
    $_SESSION['success_message'] = true;
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Check if success message should be displayed
if (isset($_SESSION['success_message']) && $_SESSION['success_message'] === true) {
    $submitMessage = "Form submitted successfully";
    // Reset session variable
    unset($_SESSION['success_message']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incident Reporting Form</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            background-image: url('bg2.png'); /* Replace 'background-image.jpg' with the path to your image */
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background for better readability */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            box-sizing: border-box;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            animation: fadeInText 1s ease-in-out;
        }

        @keyframes fadeInText {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 10px; /* Decrease margin */
            font-weight: bold;
            color: #333; /* Adjust color */
            animation: slideIn 1s ease-in-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="date"],
        input[type="time"],
        textarea {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            animation: fadeInInput 1s ease-in-out;
        }

        @keyframes fadeInInput {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #7f8c8d;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        textarea {
            resize: vertical;
        }

        button {
            background-color: #2c3e50; /* Change button color to blue */
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 10px 20px; /* Adjust padding */
            border-radius: 4px;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            animation: fadeInButton 1s ease-in-out;
        }

        @keyframes fadeInButton {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        button:hover {
            background-color:#2980b9;
            transform: scale(1.05);
        }

        button:active {
            transform: scale(0.95);
        }

        .submit-message {
            text-align: center;
            margin-bottom: 20px;
            color: #fff; /* Change text color to white */
            background-color: #3498db; /* Change background color to blue */
            border: 1px solid #2980b9;
            padding: 10px;
            border-radius: 4px;
            animation: fadeIn 0.5s ease;
        }
    </style>
    <script>
        // Redirect to homepage after showing the success message
        window.onload = function() {
            const submitMessage = document.querySelector('.submit-message');
            if (submitMessage) {
                setTimeout(() => {
                    window.location.href = 'women.html'; // Replace 'index.php' with your homepage URL
                }, 3000); // Redirect after 3 seconds
            }
        }
    </script>
</head>
<body>
<div class="container">
    <h1>Incident Reporting Form</h1>
    <?php if (!empty($submitMessage)) : ?>
        <div class="submit-message"><?php echo $submitMessage; ?></div>
    <?php endif; ?>
    <form id="incidentForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone" required>

        <label for="location">Location of Incident</label>
        <input type="text" id="location" name="location" required>

        <label for="date">Date of Incident</label>
        <input type="date" id="date" name="date" required>

        <label for="time">Time of Incident</label>
        <input type="time" id="time" name="time" required>

        <label for="details">Details of Incident</label>
        <textarea id="details" name="details" rows="5" required></textarea>

        <label for="witnesses">Witnesses (if any)</label>
        <input type="text" id="witnesses" name="witnesses">

        <label for="attachment">Attachment (if any)</label>
        <input type="file" id="attachment" name="attachment">

        <button type="submit">Submit</button>
    </form>
</div>
</body>
</html>

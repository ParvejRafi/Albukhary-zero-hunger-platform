<?php
// Start session
session_start();

// Connect to the database
$connection = mysqli_connect("localhost", "root", "", "nohunger");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $amount = (float)$_POST['amount'];
    $reason = $_POST['reason'];

    // Prepare and execute the SQL statement
    $stmt = $connection->prepare("INSERT INTO applydonation (fullname, email, phonenumber, residential, reason_to_apply, amount) 
                                  VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sssssd", $fullname, $email, $phone, $address, $reason, $amount);
        if ($stmt->execute()) {
            echo "<script>alert('Your application has been successfully submitted!'); window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Failed to submit your application. Please try again.');</script>";
        }
        

        $stmt->close();
    } else {
        echo "<script>alert('Error preparing the statement: " . htmlspecialchars($connection->error) . "');</script>";
    }

    // Close the connection
    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Form for Donation</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body class="application-page">
    <div class="application-container">
        <h1>Apply for Donation Assistance</h1>
        <p>Fill out the form below to apply for assistance. All information provided will remain confidential.</p>

        <form id="application-form" action="" method="POST">
            <div class="form-section">
                <h2>Personal Information</h2>
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required>

                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email address" required>

                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>

                <label for="address">Residential Address:</label>
                <textarea id="address" name="address" rows="3" placeholder="Enter your address" required></textarea>
            </div>

            <div class="form-section">
                <h2>Financial Request</h2>
                <label for="amount">Requested Amount:</label>
                <input type="number" id="amount" name="amount" placeholder="Enter the amount needed" required>
            </div>

            <div class="form-section">
                <h2>Verification Details</h2>
                <label for="reason">Reason for Assistance:</label>
                <textarea id="reason" name="reason" rows="5" placeholder="Explain why you need assistance" required></textarea>
            </div>

            <div class="form-section">
                <button type="submit" class="submit-btn">Submit Application</button>
            </div>
        </form>
    </div>
</body>
</html>

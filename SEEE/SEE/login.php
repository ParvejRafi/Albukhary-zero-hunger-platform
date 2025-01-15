<?php
// Start session
session_start();

// Connect to the database
$connection = new mysqli("localhost", "root", "", "nohunger");

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Initialize error message
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure both fields are submitted
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Prepare and execute query to check if the email exists
        $stmt = $connection->prepare("SELECT id, email, password FROM signup WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        // Bind the result to variables
        $stmt->bind_result($userId, $userEmail, $userPassword);

        if ($stmt->num_rows > 0) {
            $stmt->fetch();

            // Email found, now verify password
            if (password_verify($password, $userPassword)) {
                // Successful login
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $userId;
                $_SESSION['email'] = $userEmail;

                // Redirect to the calculate page
                header("Location: index.php");
                exit();
            } else {
                // Invalid password
                $error = "Invalid email or password.";
            }
        } else {
            // Email not found in the database
            $error = "You do not have an account. Please create an account.";
        }

        $stmt->close();
    } else {
        $error = "Please fill in all fields.";
    }
}

// Close the database connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Include your CSS here */
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: #333;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: #ffffff;
            width: 100%;
            max-width: 400px;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #3b82f6;
            margin-bottom: 1rem;
            font-size: 1.8rem;
            font-weight: bold;
        }
        form .form-group {
            margin-bottom: 1rem;
        }
        form label {
            font-size: 1rem;
            font-weight: 600;
            display: block;
            margin-bottom: 0.5rem;
        }
        form input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
            font-size: 1rem;
            margin-bottom: 20px;
        }
        form button {
            width: 100%;
            padding: 0.8rem;
            background: linear-gradient(135deg, #3b82f6, #6ee7b7);
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
        }
        p {
            text-align: center;
            margin-top: 1rem;
        }
        p a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Sign up here</a>.</p>
    </div>
</body>
</html>

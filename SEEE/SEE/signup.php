<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Your CSS styles here */
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease-in-out;
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

        h2 {
            text-align: center;
            color: #3b82f6;
            margin-bottom: 1rem;
            font-size: 1.8rem;
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            font-size: 1rem;
            font-weight: 600;
            display: block;
            margin-bottom: 0.5rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-top: 0.5rem;
            outline: none;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 5px rgba(59, 130, 246, 0.3);
        }

        button {
            width: 100%;
            padding: 0.8rem;
            background: linear-gradient(135deg, #3b82f6, #6ee7b7);
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        button:hover {
            background: linear-gradient(135deg, #2563eb, #4ade80);
        }

        .cancelbtn {
            background-color: #f44336;
            margin-right: 0.5rem;
        }

        .cancelbtn:hover {
            background-color: #d32f2f;
        }

        .clearfix button {
            width: 48%;
            margin: 0.5rem 1%;
        }

        hr {
            border: none;
            border-top: 1px solid #ccc;
            margin: 1.5rem 0;
        }

        .switch-form {
            text-align: center;
            margin-top: 1.5rem;
        }

        .switch-form a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .switch-form a:hover {
            color: #2563eb;
        }

        input[type="checkbox"] {
            margin-right: 0.5rem;
        }

        .clearfix {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <?php
    // Connect to the database
    $connection = new mysqli("localhost", "root", "", "nohunger");

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sanitize and validate input
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $password = trim($_POST['psw']);
        $password_repeat = trim($_POST['psw-repeat']);

        if (!empty($email) && !empty($password) && !empty($password_repeat)) {
            if ($password === $password_repeat) {
                // Password hashing
                $password_hashed = password_hash($password, PASSWORD_BCRYPT);

                // Insert user into the database
                $stmt = $connection->prepare("INSERT INTO signup (email, password) VALUES (?, ?)");
                $stmt->bind_param("ss", $email, $password_hashed);

                if ($stmt->execute()) {
                    // Registration successful, redirect to sign-in page
                    header("Location: login.php");
                    exit();
                } else {
                    echo "Error: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "<p style='color: red;'>Passwords do not match.</p>";
            }
        } else {
            echo "<p style='color: red;'>Please fill in all fields.</p>";
        }
    }

    $connection->close();
    ?>
    
    <div class="container">
        <h2>Create an Account</h2>
        <form action="signup.php" method="POST">
            <div class="form-group">
                <label for="email"><b>Email</b></label>
                <input type="email" placeholder="Enter Email" name="email" required>
            </div>
            <div class="form-group">
                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" required>
            </div>
            <div class="form-group">
                <label for="psw-repeat"><b>Repeat Password</b></label>
                <input type="password" placeholder="Repeat Password" name="psw-repeat" required>
            </div>
            <label>
                <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
            </label>
            <div class="clearfix">
                <button type="button" class="cancelbtn">Cancel</button>
                <button type="submit" class="signupbtn">Sign Up</button>
            </div>
        </form>
        <div class="switch-form">
            <p>Already have an account? <a href="login.php">Sign In</a></p>
        </div>
    </div>
</body>
</html>

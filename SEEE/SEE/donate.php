<?php
// Start session
session_start();

// Connect to the database
$connection = mysqli_connect("localhost", "root", "", "nohunger");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize message variable
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and validate donation type
    $donationType = $_POST['donation-type'] ?? null;
    $validDonationTypes = ['monthly', 'one-time'];

    if (!in_array($donationType, $validDonationTypes)) {
        die("Invalid donation type.");
    }

    // Retrieve and validate common fields
    $currency = $_POST['currency'] ?? '';
    $name = $_POST['name-' . $donationType] ?? '';
    $email = $_POST['email-' . $donationType] ?? '';

    if (empty($name) || empty($email)) {
        die("Name and email are required.");
    }

    // Handle 'amount' and 'other amount'
    $amount = $_POST['amount-' . $donationType] ?? 0;
    if ($amount == 'other') {
        $amount = $_POST['amount-other-' . $donationType] ?? 0;
    }

    if (!is_numeric($amount) || $amount <= 0) {
        die("Invalid donation amount.");
    }

    // Prepare SQL query to insert data into donations table
    $sql = "INSERT INTO donations (donation_type, amount, currency, name, email) VALUES (?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);

    if ($stmt === false) {
        die("Error preparing the statement: " . $connection->error);
    }

    // Bind parameters
    $stmt->bind_param("sdsss", $donationType, $amount, $currency, $name, $email);

    // Execute the statement and provide feedback
    if ($stmt->execute()) {
        echo "<script>
                alert('Thank you for your donation, $name! We will contact you soon.');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "<script>
                alert('Error processing your donation: " . $stmt->error . "');
                window.location.href = 'index.php';
              </script>";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate - Food Distribution Platform</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            background-color: #f4f4f9;
            color: #333;
        }

        header {
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            color: white;
            text-align: center;
            padding: 2rem;
        }

        header h1 {
            margin: 0;
            font-size: 2.5rem;
        }

        header p {
            font-size: 1.2rem;
            margin-top: 0.5rem;
        }

        .donation-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 1rem;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .hero-section {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .hero-image {
            flex: 1;
            max-width: 400px;
            border-radius: 8px;
        }

        .hero-message {
            flex: 2;
        }

        .hero-message h2 {
            color: #ff7e5f;
        }

        section {
            margin-bottom: 2rem;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            padding: 1rem 2rem;
        }

        label {
            font-weight: bold;
        }

        select, input[type="number"], input[type="text"], input[type="email"] {
            width: 100%;
            padding: 0.5rem;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background: #ff7e5f;
            color: white;
            padding: 0.8rem;
            font-size: 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #feb47b;
        }

        .footer-content {
            text-align: center;
            padding: 1.5rem;
            background: #333;
            color: white;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-icons img {
            width: 40px;
            height: 40px;
            transition: transform 0.3s;
        }

        .social-icons img:hover {
            transform: scale(1.2);
        }

        #other-amount-container, #other-amount-container-once {
            display: none;
        }

        @media (max-width: 768px) {
            .hero-section {
                flex-direction: column;
                align-items: center;
            }

            .hero-image {
                max-width: 100%;
            }

            form {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <header class="save-child-header">
        <h1>You Can Save a Child's Life</h1>
        <p>Donate now and make a life-long impact, every single day.</p>
    </header>

    <main class="donation-container">
        <section class="hero-section">
            <img src="need.jpeg" alt="Children in need" class="hero-image">
            <div class="hero-message">
                <h2>Your Donation Makes a Difference</h2>
                <p>With your help, we can provide life-saving food to children suffering from malnutrition.</p>
            </div>
        </section>

        <section class="monthly-donation">
            <h2>Give Monthly</h2>
            <form method="POST" action="">
                <label for="currency-selector">Choose Currency:</label>
                <select id="currency-selector" name="currency">
                    <option value="MYR" selected>MYR (Malaysian Ringgit)</option>
                    <option value="USD">USD (US Dollar)</option>
                    <option value="EUR">EUR (Euro)</option>
                    <option value="GBP">GBP (British Pound)</option>
                </select>
                <input type="hidden" name="donation-type" value="monthly">

                <label for="amount">Choose Amount:</label>
                <select id="amount" name="amount-monthly" onchange="toggleOtherAmount('monthly')">
                    <option value="100">100</option>
                    <option value="80">80</option>
                    <option value="60">60</option>
                    <option value="other">Other</option>
                </select>

                <div id="other-amount-container">
                    <label for="other-amount">Enter Amount:</label>
                    <input type="number" id="other-amount" name="amount-other-monthly" min="1">
                </div>

                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name-monthly" required>

                <label for="email">Your Email:</label>
                <input type="email" id="email" name="email-monthly" required>

                <button type="submit">Donate Monthly</button>
            </form>
        </section>

        <section class="one-time-donation">
            <h2>Give Once</h2>
            <form method="POST" action="">
                <label for="currency-selector-once">Choose Currency:</label>
                <select id="currency-selector-once" name="currency">
                    <option value="MYR" selected>MYR (Malaysian Ringgit)</option>
                    <option value="USD">USD (US Dollar)</option>
                    <option value="EUR">EUR (Euro)</option>
                    <option value="GBP">GBP (British Pound)</option>
                </select>
                <input type="hidden" name="donation-type" value="one-time">

                <label for="amount">Choose Amount:</label>
                <select id="amount" name="amount-one-time" onchange="toggleOtherAmount('once')">
                    <option value="150">150</option>
                    <option value="100">100</option>
                    <option value="50">50</option>
                    <option value="other">Other</option>
                </select>

                <div id="other-amount-container-once">
                    <label for="other-amount-once">Enter Amount:</label>
                    <input type="number" id="other-amount-once" name="amount-other-one-time" min="1">
                </div>

                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name-one-time" required>

                <label for="email">Your Email:</label>
                <input type="email" id="email" name="email-one-time" required>

                <button type="submit">Donate Once</button>
            </form>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <h1>Connect with Us</h1>
            <div class="social-icons">
                <a href="https://www.facebook.com/share/14yfpNuEo7/?mibextid=wwXIfr" target="_blank">
                    <img src="fb.png" alt="Facebook">
                </a>
                <a href="https://www.instagram.com" target="_blank">
                    <img src="insta.jpeg" alt="Instagram">
                </a>
                <a href="https://x.com/hello_parvej_g?s=21" target="_blank">
                    <img src="twit.png" alt="Twitter">
                </a>
                <a href="https://wa.me/1234567890" target="_blank">
                    <img src="watsapp.png" alt="WhatsApp">
                </a>
            </div>
            <p>Our Address: Al Bukhary International University</p>
            <p>Jln Tun Rajak, Alor Setar, Kedah, Malaysia</p>
            <p>&copy; Parvej Rafi. All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        function toggleOtherAmount(type) {
            const container = type === 'monthly' ? document.getElementById('other-amount-container') : document.getElementById('other-amount-container-once');
            const amountSelector = type === 'monthly' ? document.getElementById('amount') : document.getElementById('amount');
            if (amountSelector.value === 'other') {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        }
    </script>
</body>
</html>

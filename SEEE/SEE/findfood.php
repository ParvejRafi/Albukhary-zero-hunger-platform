<?php
// Start session
session_start();

// Connect to the database
$connection = mysqli_connect("localhost", "root", "", "nohunger");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission when the "Confirm Your Payment" button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $branch = $_POST['branch'];
    $meal_item = $_POST['meal_item'];
    $quantity = $_POST['quantity'];
    $sub_total = $_POST['sub_total'];
    $payment_method = $_POST['payment_method'];

    // Insert into database
    $sql = "INSERT INTO meal_donations (date, branch, meal_item, quantity, sub_total, payment_method)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssdss", $date, $branch, $meal_item, $quantity, $sub_total, $payment_method);

    if ($stmt->execute()) {
        echo "<script>alert('Payment processed successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Meal Donation</title>
    <link rel="stylesheet" href="styles.css">
    <script defer src="script.js"></script>
</head>
<body class="donation-description-page">
    <!-- Header Section -->
    <header class="custom-header">
        <div class="logo-and-intro">
            <div class="logo">
                <img src="bukhary.png" alt="Zero Hunger Platform Logo">
                <span>Al Bukhary Zero Hunger Platform</span>
            </div>
        </div>
    </header>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <ul>
            <li><a href="team.html">About Us</a></li>
            <li><a href="apply.html">Apply For Donation</a></li>
            <li><a href="findfood.php">Provide Meals</a></li>
            <li><a href="involve.html">Get Involved</a></li>
            <li><a href="join.html">Join Our Team</a></li>
            <li><a href="donate.php">Donate</a></li>
        </ul>
    </nav>

    <!-- Form Section -->
    <form method="POST" action="">
        <div class="special-meal-container">
            <!-- Header Section -->
            <header>
                <h1>Donate Meal</h1>
            </header>

            <!-- Table Section -->
            <section>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Branch</th>
                            <th>Meal Item</th>
                            <th>Quantity</th>
                            <th>Sub Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="meal-table-body">
                        <tr>
                            <td><input type="date" name="date" value="2024-12-25" required></td>
                            <td>
                                <select name="branch" required>
                                    <option value="Any Branch">Any Branch</option>
                                    <option value="Kuala Lumpur">Kuala Lumpur</option>
                                    <option value="Penang">Penang</option>
                                    <option value="Johor Bahru">Johor Bahru</option>
                                    <option value="Alor Setar">Alor Setar</option>
                                    <option value="Albukhary Student">Albukhary Student</option>
                                </select>
                            </td>
                            <td>
                                <select name="meal_item" required>
                                    <option value="Rice, Chicken and Egg">Rice, Chicken and Egg</option>
                                    <option value="Vegetarian Meal">Vegetarian Meal</option>
                                    <option value="Fish and Chips">Fish and Chips</option>
                                </select>
                            </td>
                            <td><input type="number" name="quantity" value="113" required></td>
                            <td><input type="number" name="sub_total" value="10848" required></td>
                            <td><button class="delete-row" type="button">❌</button></td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <!-- Additional Section -->
            <section class="donation-summary">
                <div class="totals">
                <div>
    <label for="total-quantity">Total Quantity:</label>
    <input type="number" id="total-quantity" name="total_quantity" value="150" required>
</div>
<div>
    <label for="total-amount">Total Amount:</label>
    <input type="number" id="total-amount" name="total_amount" value="1000" required>
</div>

                </div>

                <!-- Payment Section -->
                <div class="payment-section">
                    <h3>Choose Payment <span class="secure-icon">🔒 SECURE</span></h3>
                    <select name="payment_method" required>
                        <option value="">Select Payment Method</option>
                        <option value="Visa">Visa</option>
                        <option value="PayPal">PayPal</option>
                        <option value="MasterCard">MasterCard</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="donate-button-container">
                    <button id="donate-now-button" class="donate-now-button" type="submit">Confirm Your Payment</button>
                </div>
            </section>
        </div>
    </form>

    <!-- Footer -->
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
            <p>Jln tun rajak, Alor Setar, Kedah, Malaysia</p>
            <p>&copy; Parvej Rafi. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>

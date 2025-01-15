<?php
// Start session
session_start();

// Connect to the database
$connection = mysqli_connect("localhost", "root", "", "nohunger");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['organization'])) { // Join Organization Form
        $organization = htmlspecialchars($_POST['organization']); // Organization name
        $country = htmlspecialchars($_POST['country']);
        $address = htmlspecialchars($_POST['address']); // Corrected field name
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Corrected field name
        $position = htmlspecialchars($_POST['position']);

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Invalid email address. Please try again.');</script>";
        } else {
            // Insert data into the database
            $stmt = $connection->prepare('INSERT INTO joinrequests (organization, country, address, email, position) VALUES (?, ?, ?, ?, ?)');
            $stmt->bind_param('sssss', $organization, $country, $address, $email, $position);

            if ($stmt->execute()) {
                echo "<script>alert('Thank you for joining! Your application has been successfully submitted.'); window.location.href = 'index.php';</script>";
            } else {
                echo "<script>alert('Failed to submit your application. Please try again.');</script>";
            }

            $stmt->close();
        }
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizations - Food Distribution Platform</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="partner-header">
        <h1>Our Partner Organizations</h1>
        <p>Join forces with leading organizations to make a difference in the fight against hunger.</p>
    </header>
    <main class="organization-list">
        <!-- Organization 1 -->
        <section class="organization-card">
            <div class="organization-content">
                <img src="bukhary.png" alt="World Food Programme Logo" class="organization-image">
                <div class="organization-info">
                    <h2>Al Bukhary Foundation</h2>
                    <p>The Albukhary Foundation focuses on education, scholarships, community development, Hajj assistance, and cultural preservation through initiatives like Albukhary International University, Islamic Arts Museum Malaysia, and global Islamic culture promotion.</p>
                </div>
            </div>
            <button class="join-button" onclick="showJoinForm('Al Bukhary Foundation')">Join Us</button>
        </section>

        <!-- Organization 2 -->
        <section class="organization-card">
            <div class="organization-content">
                <img src="unicef.png" alt="UNICEF Logo" class="organization-image">
                <div class="organization-info">
                    <h2>UNICEF</h2>
                    <p>UNICEF works to ensure children have access to nutrition, education, and health services in underprivileged communities around the world.</p>
                </div>
            </div>
            <button class="join-button" onclick="showJoinForm('UNICEF')">Join Us</button>
        </section>

        <!-- Organization 3 -->
        <section class="organization-card">
            <div class="organization-content">
                <img src="hunger.png" alt="Action Against Hunger Logo" class="organization-image">
                <div class="organization-info">
                    <h2>Action Against Hunger</h2>
                    <p>Action Against Hunger is committed to ending world hunger by addressing malnutrition and providing clean water in Asia, Africa, and Latin America.</p>
                </div>
            </div>
            <button class="join-button" onclick="showJoinForm('Action Against Hunger')">Join Us</button>
        </section>
    </main>

    <!-- Join Form -->
    <section id="join-form-section" class="join-form hidden">
        <h2 id="organization-name">Join Organization</h2>
        <form id="join-form" method="POST" action="">
            <input type="hidden" id="organization" name="organization">
            <label for="country">Country:</label>
            <input type="text" id="country" name="country" placeholder="Enter your country" required>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" placeholder="Enter your Address" required>
            <label for="email">E-Mail:</label>
            <input type="text" id="email" name="email" placeholder="Enter your E-mail" required>
            <label for="position">Position:</label>
            <select id="position" name="position" required>
                <option value="donor">Donor</option>
                <option value="helper">Helper</option>
                <option value="volunteer">Volunteer</option>
                <option value="ambassador">Ambassador</option>
            </select>

            <button type="submit" class="submit-button">Submit</button>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 Food Distribution Platform. All Rights Reserved.</p>
    </footer>

    <script>
        function showJoinForm(organization) {
            const formSection = document.getElementById('join-form-section');
            document.getElementById('organization-name').textContent = `Join ${organization}`;
            document.getElementById('organization').value = organization; // Set hidden input value
            formSection.classList.remove('hidden');
            formSection.scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>
</html>

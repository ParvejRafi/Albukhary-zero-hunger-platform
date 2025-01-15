<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page
    header('Location: login.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Distribution Platform</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="custom-header">
        <!-- Logo and Welcome Message -->
        <div class="logo-and-intro">
            <div class="logo">
                <img src="bukhary.png" alt="Platform Logo">
                <span>Al Bukhary Zero Hunger Platform</span>
            </div>
            <p class="welcome-message">Join us in the mission to end hunger and bring smiles to those in need.</p>
        </div>
    
        <!-- Navigation Bar -->
        <nav class="main-navigation">
            <ul class="nav-list">
                <li><a href="team.html">About Us</a></li>
                <li><a href="apply.html">Apply for Donation</a></li>
                </li> <a href="findfood.php">Provide Meals</a></li>
                <li><a href="involve.html">Get Involved</a></li>
                <li><a href="join.html"> Join our team</a></li>

                
                <li><a href="donate.php">Donate</a></li>
            </ul>
            <div class="nav-icons">
                <a href="mailto:info@foodplatform.com" class="icon email-icon" title="Email">
                    <img src="email.png" alt="Email Icon">
                </a>
                <a href="tel:+123456789" class="icon phone-icon" title="Call Us">
                    <img src="phone.png" alt="Phone Icon">
                </a>
            </div>
        </nav>
    </header>
    

   

    <main>
        <!-- Hero Section -->
        <section id="hero" class="hero-section">
            <div class="hero-text">
                <h2>Fighting Hunger, One Meal at a Time</h2>
                <p>Every contribution counts. Together, we can build a world without hunger.</p>
                <a href="donate.php" class="hero-button">Donate Now</a>
                
                
         </div>
            <img src="SDG2.png" alt="Helping hands" class="hero-image">
        </section>

        <!-- Photo Section -->
        <section id="photos" class="photo-section">
            <h2>Our Mission in Action</h2>
            <div class="photo-grid">
                <div class="photo-card">
                    <img src="food.jpeg" alt="Food distribution">
                    <p>“Every meal distributed is a step closer to hope.”</p>
                </div>
                <div class="photo-card">
                    <img src="aiu.jpeg" alt="Volunteers working">
                    <p>“Together, we can make the impossible possible.”</p>
                </div>
                <div class="photo-card">
                    <img src="download.jpeg" alt="Happy children receiving food">
                    <p>“A child’s smile is worth every effort.”</p>
                </div>
                <div class="photo-card">
                    <img src="cook.jpeg" alt="Community event">
                    <p>“Unity in action brings lasting change.”</p>
                </div>
            </div>
        </section>
        <section class="connect-with-organization">
            <h2>Connect with Organizations</h2>
            <p>Explore organizations making a difference in the fight against hunger and malnutrition.</p>
            <a href="organizations.php" class="connect-button">Learn More</a>
        </section>
        <section id="newsletter" class="newsletter-section">
            <div class="newsletter-container">
                <h2>Stay Informed</h2>
                <p>Subscribe to our weekly newsletter and receive updates on world hunger, research papers, and inspiring stories.</p>
                <form id="newsletter-form" onsubmit="subscribeToNewsletter(event)">
                    <input type="email" id="newsletter-email" placeholder="Enter your email address" required>
                    <button type="submit" class="newsletter-button">Subscribe</button>
                </form>
                <div id="newsletter-message" class="hidden"></div>
            </div>
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
            <p>Jln tun rajak ,Alor setar , kedah , malaysia </p>
            <p>&copy; Parvej Rafi. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>


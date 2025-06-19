<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags for character encoding and responsive design -->
    <meta charset="UTF-8">  <!-- Sets the character encoding to UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  <!-- Ensures proper scaling on all devices -->
    <title>CarMarket - Buy & Sell Cars Easily</title>  <!-- The title of the webpage displayed in the browser tab -->
    
    <!-- Link to external CSS file for styling -->
    <link rel="stylesheet" href="../CSS/IndexStyles.css">
</head>
<body>

<!-- PHP code to include header file -->
<?php
// Include header
include '../PHP/header.php';
?>

<main>
    <!-- Hero section with background image and introductory text -->
    <div class="hero">
        <div class="hero-text">
            <h1>Welcome to CarMarket</h1>  <!-- Main heading of the hero section -->
            <p>Easy, Fast, and Secure Car Transactions.</p>  <!-- Subheading under the main heading -->
            <!-- Button links to the "about" section -->
            <a href="#about" class="btn">Learn More</a>
            <br><br>
            <!-- Button links to the Car Search page -->
            <a href="CarSearch.php" class="btn">Search</a>
        </div>
    </div>

    <!-- About section with information about the platform -->
    <section id="about" class="container">
        <h2>About Us</h2>  <!-- Heading for the About section -->
        <p>
            At CarMarket, we provide a seamless platform for buying, selling, and exploring vehicles.
            Whether you're looking for a brand-new car or a pre-owned gem, our platform offers everything you need for a hassle-free experience.
        </p>
    </section>

    <!-- Feature section showcasing three main features of the platform -->
    <section class="feature-box">
        <!-- Feature 1: Wide Selection of Cars -->
        <div class="feature">
            <div class="feature-image">
                <!-- Image for wide selection of cars -->
                <img src="../Images/IndexImages/car1.jpg" alt="Wide Selection of Cars">
            </div>
            <div class="feature-text">
                <h2>Wide Selection</h2>  <!-- Heading for this feature -->
                <p>Explore thousands of new and used cars from trusted sellers worldwide.</p>  <!-- Description of this feature -->
            </div>
        </div>

        <!-- Feature 2: Secure Transactions -->
        <div class="feature">
            <div class="feature-image">
                <!-- Image for secure transactions -->
                <img src="../Images/IndexImages/Transactions.jpg" alt="Secure Transactions">
            </div>
            <div class="feature-text">
                <h2>Secure Transactions</h2>  <!-- Heading for this feature -->
                <p>Our advanced security measures ensure a safe and reliable car purchasing experience.</p>  <!-- Description of this feature -->
            </div>
        </div>

        <!-- Feature 3: Verified Dealers -->
        <div class="feature">
            <div class="feature-image">
                <!-- Image for verified dealers -->
                <img src="../Images/IndexImages/Dealers.jpg" alt="Verified Dealers">
            </div>
            <div class="feature-text">
                <h2>Verified Dealers</h2>  <!-- Heading for this feature -->
                <p>We work only with certified dealers to guarantee quality and satisfaction.</p>  <!-- Description of this feature -->
            </div>
        </div>
    </section>

    <!-- Testimonials section showcasing customer feedback -->
    <section class="testimonials">
        <h2>What Our Customers Say</h2>  <!-- Heading for the testimonials section -->
        <!-- Example customer testimonial -->
        <p>"CarMarket made it so easy to find my dream car at the best price!" - John Doe</p>
    </section>

    <!-- Call to Action (CTA) section encouraging users to register -->
    <section class="cta">
        <h2>Ready to Buy or Sell?</h2>  <!-- Heading for the CTA section -->
        <p>Join CarMarket today and experience the future of car trading.</p>  <!-- Short message encouraging users to take action -->
        <!-- Button that links to the registration page -->
        <a href="../WebPages/RegisterPage.php" class="btn">Get Started</a>
    </section>
</main>

<!-- PHP code to include footer file -->
<?php
// Include footer
include '../PHP/footer.php';
?>

</body>
</html>

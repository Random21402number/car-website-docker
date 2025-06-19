<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Buy a Car | CarMarket</title>
    <link rel="stylesheet" href="../CSS/BuyCar.css">
    <script src="../JS/BuyCar.js" defer></script>
</head>
<body>
    <?php
    // Include header
    include '../PHP/header.php';
    ?> 

    <main class="buy-car-page">
        <div class="buy-car-container">
            <h1>Buy Your Dream Car</h1>
            <div class="page-header-actions">
                <a href="../WebPages/CarSearch.php" class="back-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                    Back to Search
                </a>
            </div>

            <div class="buying-process">
                <div class="process-step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>Find Your Perfect Match</h3>
                        <p>Browse our extensive inventory and use filters to narrow down your options. Save your favorites for later comparison.</p>
                        <a href="../WebPages/CarSearch.php" class="step-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            Start Searching
                        </a>
                    </div>
                </div>

                <div class="process-step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3>Get Pre-Approved</h3>
                        <p>Check your buying power and secure financing before visiting a dealership. Get pre-approved in minutes with our secure application.</p>
                    </div>
                </div>

                <div class="process-step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3>Schedule a Test Drive</h3>
                        <p>Experience the car firsthand. Book a test drive appointment with your local dealer or request a home test drive service.</p>
                    </div>
                </div>

                <div class="process-step">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h3>Make an Offer</h3>
                        <p>Found the one? Make an offer online or negotiate with the dealer. Our price analysis tool helps ensure you get a fair deal.</p>
                    </div>
                </div>

                <div class="process-step">
                    <div class="step-number">5</div>
                    <div class="step-content">
                        <h3>Complete Purchase</h3>
                        <p>Finalize paperwork, payment, and arrange delivery or pickup. Our concierge service can assist with all final steps.</p>
                    </div>
                </div>
            </div>

            <div class="buying-tools">
                <h2>Helpful Buying Tools</h2>
                <div class="tools-grid">
                    <div class="tool-card">
                        <div class="tool-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        </div>
                        <h3>Payment Calculator</h3>
                        <p>Estimate your monthly payments based on price, down payment, interest rate and terms.</p>
                        <a href="#" class="tool-link">Calculate Payments</a>
                    </div>

                    <div class="tool-card">
                        <div class="tool-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>
                        </div>
                        <h3>Trade-In Value</h3>
                        <p>Get an instant estimate of your current vehicle's trade-in value.</p>
                        <a href="#" class="tool-link">Value Your Trade</a>
                    </div>

                    <div class="tool-card">
                        <div class="tool-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                        </div>
                        <h3>Price Comparison</h3>
                        <p>See how a vehicle's price compares to similar models in your area.</p>
                        <a href="#" class="tool-link">Compare Prices</a>
                    </div>

                    <div class="tool-card">
                        <div class="tool-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <h3>Vehicle History</h3>
                        <p>Check accident history, ownership, and service records before you buy.</p>
                        <a href="#" class="tool-link">Get History Report</a>
                    </div>
                </div>
            </div>

            <div class="testimonials">
                <h2>What Our Customers Say</h2>
                <div class="testimonial-grid">
                    <div class="testimonial-card">
                        <div class="testimonial-rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                        <p class="testimonial-text">"The buying process was incredibly smooth. From finding my car to finalizing the paperwork, everything was straightforward and transparent."</p>
                        <p class="testimonial-author">- Michael D.</p>
                    </div>

                    <div class="testimonial-card">
                        <div class="testimonial-rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                        <p class="testimonial-text">"I was hesitant to buy a car online, but CarMarket made it easy and secure. The home test drive option was a game-changer for me."</p>
                        <p class="testimonial-author">- Sarah L.</p>
                    </div>

                    <div class="testimonial-card">
                        <div class="testimonial-rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">☆</span>
                        </div>
                        <p class="testimonial-text">"The financing options were excellent and helped me get a better rate than my bank offered. The process was quick and painless."</p>
                        <p class="testimonial-author">- Robert K.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    // Include footer
    include '../PHP/footer.php';
    ?>
</body>
</html>
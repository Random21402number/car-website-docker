<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Car Details | CarMarket</title>
    <link rel="stylesheet" href="../CSS/CarDetails.css">
    <script src="../JS/CarDetails.js" defer></script>
</head>
<body>
    <?php
    // Include header
    include '../PHP/header.php';
    
    // Get car ID from URL
    $car_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    
    // Database connection
    require_once '../PHP/Connection.php';
    
    // Fetch car details
    $car = null;
    $features = [];
    
    if ($car_id > 0) {
        // Car details query
        $stmt = $pdo->prepare("SELECT * FROM Cars WHERE car_id = :car_id");
        $stmt->bindValue(':car_id', $car_id, PDO::PARAM_INT);
        $stmt->execute();
        $car = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Car features query
        if ($car) {
            $features_stmt = $pdo->prepare("
                SELECT f.feature_name 
                FROM Features f 
                JOIN Car_Features cf ON f.feature_id = cf.feature_id 
                WHERE cf.car_id = :car_id
            ");
            $features_stmt->bindValue(':car_id', $car_id, PDO::PARAM_INT);
            $features_stmt->execute();
            $features = $features_stmt->fetchAll(PDO::FETCH_COLUMN);
        }
    }
    
    // If car not found, show error
    if (!$car) {
        echo '<div class="error-message">Car not found or has been removed.</div>';
        include '../PHP/footer.php';
        exit();
    }
    ?> 

    <main class="car-details-page">
        <div class="back-button-container">
            <a href="javascript:history.back()" class="back-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5"></path>
                    <path d="M12 19l-7-7 7-7"></path>
                </svg>
                Back to Search
            </a>
        </div>

        <div class="car-details-container">
            <div class="car-gallery">
                <?php if (!empty($car['image_path'])): ?>
                    <div class="main-image">
                        <img src="<?php echo htmlspecialchars($car['image_path']); ?>" alt="<?php echo htmlspecialchars($car['maker'] . ' ' . $car['model']); ?>" id="mainCarImage">
                    </div>
                    <div class="thumbnail-gallery">
                        <div class="thumbnail active" onclick="changeMainImage('<?php echo htmlspecialchars($car['image_path']); ?>')">
                            <img src="<?php echo htmlspecialchars($car['image_path']); ?>" alt="Thumbnail 1">
                        </div>
                        <!-- Add additional thumbnails if you have more images -->
                        <!-- For example: -->
                        <?php
                        // If you have additional images, you would loop through them here
                        // This is just a placeholder for illustration
                        $additionalImages = [
                            // Add paths to additional images if available
                        ];
                        
                        foreach ($additionalImages as $index => $imagePath): ?>
                            <div class="thumbnail" onclick="changeMainImage('<?php echo htmlspecialchars($imagePath); ?>')">
                                <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Thumbnail <?php echo $index + 2; ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="placeholder-gallery">
                        <div class="main-image">
                            <div class="car-placeholder">No Image Available</div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="car-info">
                <h1><?php echo htmlspecialchars($car['maker'] . ' ' . $car['model']); ?></h1>
                
                <div class="price-badge">
                    $<?php echo number_format($car['price'], 2); ?>
                </div>
                
                <div class="car-specs-grid">
                    <div class="spec-item">
                        <span class="spec-label">Year</span>
                        <span class="spec-value"><?php echo htmlspecialchars($car['year']); ?></span>
                    </div>
                    
                    <?php if (isset($car['mileage'])): ?>
                    <div class="spec-item">
                        <span class="spec-label">Mileage</span>
                        <span class="spec-value"><?php echo number_format($car['mileage']); ?> miles</span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (isset($car['fuel_type'])): ?>
                    <div class="spec-item">
                        <span class="spec-label">Fuel Type</span>
                        <span class="spec-value"><?php echo htmlspecialchars($car['fuel_type']); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (isset($car['transmission'])): ?>
                    <div class="spec-item">
                        <span class="spec-label">Transmission</span>
                        <span class="spec-value"><?php echo htmlspecialchars($car['transmission']); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (isset($car['color'])): ?>
                    <div class="spec-item">
                        <span class="spec-label">Color</span>
                        <span class="spec-value"><?php echo htmlspecialchars($car['color']); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (isset($car['body_type'])): ?>
                    <div class="spec-item">
                        <span class="spec-label">Body Type</span>
                        <span class="spec-value"><?php echo htmlspecialchars($car['body_type']); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="car-actions">
                    <button class="secondary-button contact-seller-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        Contact Seller
                    </button>
                </div>
            </div>
        </div>
        
        <div class="car-details-tabs">
            <div class="tabs-header">
                <button class="tab-button active" data-tab="description">Description</button>
                <button class="tab-button" data-tab="features">Features</button>
                <button class="tab-button" data-tab="specifications">Specifications</button>
            </div>
            
            <div class="tab-content active" id="description-tab">
                <div class="description-content">
                    <?php if (isset($car['description']) && !empty($car['description'])): ?>
                        <p><?php echo nl2br(htmlspecialchars($car['description'])); ?></p>
                    <?php else: ?>
                        <p>No description available for this vehicle.</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="tab-content" id="features-tab">
                <div class="features-list">
                    <?php if (!empty($features)): ?>
                        <ul>
                            <?php foreach ($features as $feature): ?>
                                <li>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 6L9 17l-5-5"></path>
                                    </svg>
                                    <?php echo htmlspecialchars($feature); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No features listed for this vehicle.</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="tab-content" id="specifications-tab">
                <div class="specifications-grid">
                    <?php
                    // Display technical specifications if available
                    $specifications = [
                        'Engine' => isset($car['engine']) ? $car['engine'] : null,
                        'Horsepower' => isset($car['horsepower']) ? $car['horsepower'] . ' hp' : null,
                        'Torque' => isset($car['torque']) ? $car['torque'] . ' lb-ft' : null,
                        'Fuel Economy' => isset($car['fuel_economy']) ? $car['fuel_economy'] . ' mpg' : null,
                        'Drive Type' => isset($car['drive_type']) ? $car['drive_type'] : null,
                        'VIN' => isset($car['vin']) ? $car['vin'] : null,
                        'Stock Number' => isset($car['stock_number']) ? $car['stock_number'] : null
                    ];
                    
                    $hasSpecs = false;
                    foreach ($specifications as $label => $value):
                        if ($value): 
                            $hasSpecs = true;
                    ?>
                        <div class="spec-row">
                            <div class="spec-label"><?php echo htmlspecialchars($label); ?></div>
                            <div class="spec-value"><?php echo htmlspecialchars($value); ?></div>
                        </div>
                    <?php 
                        endif;
                    endforeach;
                    
                    if (!$hasSpecs):
                    ?>
                        <p>No detailed specifications available for this vehicle.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <section class="related-cars">
            <h2>Similar Vehicles</h2>
            <div class="cars-grid">
                <?php
                // Get similar cars (same maker or model, excluding current car)
                $similar_stmt = $pdo->prepare("
                    SELECT * FROM Cars 
                    WHERE (maker = :maker OR model = :model) 
                    AND car_id != :car_id 
                    LIMIT 3
                ");
                $similar_stmt->bindValue(':maker', $car['maker'], PDO::PARAM_STR);
                $similar_stmt->bindValue(':model', $car['model'], PDO::PARAM_STR);
                $similar_stmt->bindValue(':car_id', $car_id, PDO::PARAM_INT);
                $similar_stmt->execute();
                $similar_cars = $similar_stmt->fetchAll(PDO::FETCH_ASSOC);
                
                if (!empty($similar_cars)):
                    foreach ($similar_cars as $similar_car):
                ?>
                    <div class="car-card">
                        <div class="car-image">
                            <?php if (!empty($similar_car['image_path'])): ?>
                                <img src="<?php echo htmlspecialchars($similar_car['image_path']); ?>" alt="<?php echo htmlspecialchars($similar_car['maker'] . ' ' . $similar_car['model']); ?>">
                            <?php else: ?>
                                <div class="car-placeholder"></div>
                            <?php endif; ?>
                        </div>
                        <div class="car-details">
                            <h3><?php echo htmlspecialchars($similar_car['maker'] . ' ' . $similar_car['model']); ?></h3>
                            <p class="car-price">$<?php echo number_format($similar_car['price'], 2); ?></p>
                            <div class="car-specs">
                                <span><?php echo htmlspecialchars($similar_car['year']); ?></span>
                                <?php 
                                // Get features for this similar car
                                $sim_features_stmt = $pdo->prepare("
                                    SELECT f.feature_name 
                                    FROM Features f 
                                    JOIN Car_Features cf ON f.feature_id = cf.feature_id 
                                    WHERE cf.car_id = :car_id
                                    LIMIT 1
                                ");
                                $sim_features_stmt->bindValue(':car_id', $similar_car['car_id'], PDO::PARAM_INT);
                                $sim_features_stmt->execute();
                                $sim_feature = $sim_features_stmt->fetchColumn();
                                
                                if ($sim_feature): 
                                ?>
                                    <span><?php echo htmlspecialchars($sim_feature); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="car-action-buttons">
                                <a href="car-details.php?id=<?php echo $similar_car['car_id']; ?>" class="view-details-btn">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php 
                    endforeach;
                else:
                ?>
                    <p>No similar vehicles found.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <?php
    // Include footer
    include '../PHP/footer.php';
    ?>
    
    <!-- Contact Seller Modal -->
    <div id="contactSellerModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Contact Seller</h2>
        <form id="contactForm">
            <input type="hidden" name="car_id" value="<?php echo $car_id; ?>">
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone">
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="4" required>Hi, Im interested in the <?php echo htmlspecialchars($car['year'] . ' ' . $car['maker'] . ' ' . $car['model']); ?>. Please contact me with more information.</textarea>
            </div>
            <div class="form-status-message"></div>
            <button type="submit" class="primary-button">Send Message</button>
        </form>
    </div>
</div>
</body>
</html>
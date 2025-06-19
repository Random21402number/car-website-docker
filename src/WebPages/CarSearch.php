<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Find Your Perfect Car | CarMarket</title>
    <link rel="stylesheet" href="../CSS/CarSearch.css">
    <script src="../JS/CarSearch.js" defer></script>
</head>
<body>
    <?php
    // Include header
    include '../PHP/header.php';
    ?> 

    <main class="car-search-page">
    <div class="page-header-actions">
    <a href="../WebPages/AddCar.php" class="add-car-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Add a Car
    </a>
    <a href="../WebPages/BuyCar.php" class="add-car-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 12v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-6"></path><path d="M12 12v8"></path><path d="m15 15-3-3-3 3"></path><path d="M2 7h20"></path><path d="M12 3v4"></path></svg>
        Buying
    </a>
</div>
            <div class="search-box">
                <form id="searchForm" action="../WebPages/CarSearchResult.php" method="GET" class="search-form">
                    <div class="search-input-container">
                        <input type="text" name="query" id="searchQuery" placeholder="Search by make, model, or keywords...">
                        <button type="submit" class="primary-button search-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            Search
                        </button>
                    </div>
                    
                    <div class="filter-toggle">
                        <button type="button" id="toggleFilters" class="toggle-filters-btn">
                            <span id="filterButtonText">Show Filters</span>
                            <svg id="filterArrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="arrow-down"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                    </div>
                    
                    <div id="searchFilters" class="search-filters">
                        <!-- Existing filter sections remain the same -->
                        
                        <div class="filter-section">
                            <h3>Additional Features</h3>
                            <div class="filter-checkboxes">
                                <!-- Existing features -->
                                <div class="checkbox-item">
                                    <input type="checkbox" id="feature-sunroof" name="features[]" value="sunroof">
                                    <label for="feature-sunroof">Sunroof</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="feature-navigation" name="features[]" value="navigation">
                                    <label for="feature-navigation">Navigation System</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="feature-bluetooth" name="features[]" value="bluetooth">
                                    <label for="feature-bluetooth">Bluetooth</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="feature-leatherseats" name="features[]" value="leather-seats">
                                    <label for="feature-leatherseats">Leather Seats</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="feature-backup-camera" name="features[]" value="backup-camera">
                                    <label for="feature-backup-camera">Backup Camera</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="feature-alloy-wheels" name="features[]" value="alloy-wheels">
                                    <label for="feature-alloy-wheels">Alloy Wheels</label>
                                </div>
                                
                                <!-- New Features -->
                                <div class="checkbox-item">
                                    <input type="checkbox" id="feature-climate-control" name="features[]" value="climate-control">
                                    <label for="feature-climate-control">Climate Control</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="feature-heated-seats" name="features[]" value="heated-seats">
                                    <label for="feature-heated-seats">Heated Seats</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="feature-cruise-control" name="features[]" value="cruise-control">
                                    <label for="feature-cruise-control">Cruise Control</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="filter-section">
                            <h3>Mileage</h3>
                            <div class="filter-row">
                                <div class="filter-item">
                                    <label for="min-mileage">Min Mileage</label>
                                    <input type="number" id="min-mileage" name="min-mileage" placeholder="0 miles">
                                </div>
                                <div class="filter-item">
                                    <label for="max-mileage">Max Mileage</label>
                                    <input type="number" id="max-mileage" name="max-mileage" placeholder="Any Mileage">
                                </div>
                            </div>
                            
                            <div class="mileage-slider-container">
                                <div class="mileage-slider">
                                    <div id="mileageRange" class="slider-track"></div>
                                </div>
                                <div class="mileage-values">
                                    <span id="mileageMin">0 miles</span>
                                    <span id="mileageMax">100,000+ miles</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="filter-actions">
                            <button type="reset" class="secondary-button">Reset Filters</button>
                            <button type="submit" class="primary-button">Apply Filters</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        
        <section class="featured-cars">
            <h2>Popular Cars</h2>
            <div class="cars-grid">
                <?php
                include '../PHP/CarQuery.php';
                
                // Check if there are any cars
                if (!empty($cars)) {
                    // Output data of each car
                    foreach ($cars as $row) {
                        ?>
                        <div class="car-card">
                            <div class="car-image">
                                <?php if (!empty($row['image_path'])): ?>
                                    <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="<?php echo htmlspecialchars($row['maker'] . ' ' . $row['model']); ?>">
                                <?php else: ?>
                                    <div class="car-placeholder"></div>
                                <?php endif; ?>
                            </div>
                            <div class="car-details">
                                <h3><?php echo htmlspecialchars($row['maker'] . ' ' . $row['model']); ?></h3>
                                <p class="car-price">$<?php echo number_format($row['price'], 2); ?></p>
                                <div class="car-specs">
                                    <span><?php echo htmlspecialchars($row['year']); ?></span>
                                    <?php if (!empty($row['features'])): ?>
                                        <span><?php echo htmlspecialchars($row['features']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="car-action-buttons">
                                        <a href="CarDetails.php?id=<?php echo $row['car_id']; ?>" class="view-details-btn">View Details</a>
                                    </div>
                                </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No featured cars available.</p>";
                }
                ?>
            </div>
        </section>
    </main>

    <?php
    // Include footer
    include '../PHP/footer.php';
    ?>
</body>
</html>
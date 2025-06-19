<?php
require_once '../PHP/Connection.php';
require_once '../PHP/CarSearch.php';
include '../PHP/header.php';
    
 // Get search results
 $search_results = getSearchResults($pdo);
 
 // Generate pagination links
 $pagination = generatePaginationLinks($search_results, $_GET);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search Results | CarMarket</title>
    <link rel="stylesheet" href="../CSS/CarSearch.css">
    <link rel="stylesheet" href="../CSS/CarSearchResults.css">
</head>
<body>
    <main class="car-search-page">
        <div class="search-container">
            <!-- Back button to return to search page -->
            <div class="back-to-search">
                <a href="CarSearch.php" class="secondary-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6"/>
                    </svg>
                    Back to Search
                </a>
            </div>
            
            <h1>Search Results</h1>
                <!-- Sorting controls -->
                <div class="sort-controls">
                    <label for="sort-by">Sort by:</label>
                    <select id="sort-by" onchange="updateSort(this.value)">
                        <!-- Sort options with current selection maintained -->
                        <option value="price_asc" <?php echo ($_GET['sort'] ?? 'price_asc') == 'price_asc' ? 'selected' : ''; ?>>Price: Low to High</option>
                        <option value="price_desc" <?php echo ($_GET['sort'] ?? '') == 'price_desc' ? 'selected' : ''; ?>>Price: High to Low</option>
                        <option value="year_desc" <?php echo ($_GET['sort'] ?? '') == 'year_desc' ? 'selected' : ''; ?>>Year: Newest First</option>
                        <option value="year_asc" <?php echo ($_GET['sort'] ?? '') == 'year_asc' ? 'selected' : ''; ?>>Year: Oldest First</option>
                    </select>
                </div>
            </div>
            
            <?php if (empty($search_results['cars'])): ?>
                <!-- No results message -->
                <div class="no-results">
                    <h3>No cars found matching your criteria</h3>
                    <p>Try adjusting your search filters or broaden your search terms.</p>
                    <a href="CarSearch.php" class="primary-button">Start a New Search</a>
                </div>
            <?php else: ?>
                <!-- Display car search results grid -->
                <div class="cars-grid">
                    <?php foreach ($search_results['cars'] as $car): ?>
                        <div class="car-card">
                            <!-- Car image/placeholder -->
                            <div class="car-image">
                                <div class="car-placeholder"></div>
                            </div>
                            <!-- Car details section -->
                            <div class="car-details">
                                <!-- Car title (make + model) -->
                                <h3><?php echo htmlspecialchars($car['maker'] . ' ' . $car['model']); ?></h3>
                                
                                <!-- Car price with formatting -->
                                <p class="car-price">$<?php echo number_format($car['price'], 2); ?></p>
                                
                                <!-- Key car specifications -->
                                <div class="car-specs">
                                    <span><?php echo $car['year']; ?></span>
                                    <?php 
                                    // Display up to 2 additional specs from features
                                    $specs_count = 0;
                                    foreach ($car['features'] as $feature) {
                                        if ($specs_count < 2) {
                                            echo '<span>' . htmlspecialchars($feature) . '</span>';
                                            $specs_count++;
                                        } else {
                                            break;
                                        }
                                    }
                                    ?>
                                </div>
                                
                                <?php if (!empty($car['features'])): ?>
                                    <!-- All car features list -->
                                    <div class="car-features">
                                        <?php foreach ($car['features'] as $feature): ?>
                                            <span class="car-feature"><?php echo htmlspecialchars($feature); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- View details button with car ID for clicking through -->
                                <button class="view-details-btn" onclick="viewCarDetails(<?php echo $car['car_id']; ?>)">View Details</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Pagination links -->
                <?php echo $pagination; ?>
                
            <?php endif; ?>
        </div>
    </main>
    
    <!-- Include footer -->
    <?php include '../PHP/footer.php'; ?>
    
    <!-- Include JS for search results functionality -->
    <script src="../JS/SearchResults.js"></script>
</body>
</html>
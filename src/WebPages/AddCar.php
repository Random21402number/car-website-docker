<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a Car | CarMarket</title>
    <link rel="stylesheet" href="../CSS/AddCar.css">
    <script src="../JS/AddCar.js" defer></script>
</head>
<body>
    <?php
    // Include header
    include '../PHP/header.php';
    
    // Start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    ?> 

    <main class="add-car-page">
        <div class="add-car-container">
            <h1>List a New Car for Sale</h1>
            
            <?php
            // Check if user is logged in
            if (!isset($_SESSION['user_id']) || !$_SESSION['isLoggedIn']): 
            ?>
                <div class="error-message">
                    <p>You must be logged in to list a car for sale.</p>
                    <a href="../WebPages/LoginPage.php" class="action-button">Go to Login</a>
                </div>
            <?php else: ?>
                
                <?php if (isset($_GET['error']) && $_GET['error'] == 'login_required'): ?>
                <div class="error-message">
                    <p>You must be logged in to list a car for sale.</p>
                </div>
                <?php endif; ?>
                
                <?php if (isset($_GET['error']) && $_GET['error'] != 'login_required'): ?>
                <div class="error-message">
                    <p>Error: <?php echo htmlspecialchars($_GET['error']); ?></p>
                </div>
                <?php endif; ?>
                
                <form id="addCarForm" class="add-car-form" action="../PHP/process_car_listing.php" method="POST" enctype="multipart/form-data">
                    <!-- Your existing form code here -->
                    <div class="form-section">
                        <h3>Vehicle Information</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="brand">Make</label>
                                <select id="brand" name="brand" required>
                                    <option value="">Select Maker</option>
                                    <option value="toyota">Toyota</option>
                                    <option value="honda">Honda</option>
                                    <option value="ford">Ford</option>
                                    <option value="nissan">Nissan</option>
                                    <option value="bmw">BMW</option>
                                    <option value="audi">Audi</option>
                                    <option value="mercedes">Mercedes-Benz</option>
                                    <option value="hyundai">Hyundai</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="model">Model</label>
                                <input type="text" id="model" name="model" placeholder="Select Model" required>
                                <div id="modelSuggestions" class="suggestions-list"></div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="year">Year</label>
                                <select id="year" name="year" required>
                                    <option value="">Select Year</option>
                                    <?php
                                    $currentYear = date("Y");
                                    for ($year = $currentYear; $year >= 1990; $year--) {
                                        echo "<option value=\"$year\">$year</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="mileage">Mileage</label>
                                <input type="number" id="mileage" name="mileage" placeholder="Enter Mileage" required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Rest of your form sections -->
                    <div class="form-section">
                        <h3>Pricing & Condition</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="price">Price ($)</label>
                                <input type="number" id="price" name="price" placeholder="Enter Price" required min="0">
                            </div>
                            <div class="form-group">
                                <label for="condition">Condition</label>
                                <select id="condition" name="condition" required>
                                    <option value="">Select Condition</option>
                                    <option value="new">New</option>
                                    <option value="like-new">Like New</option>
                                    <option value="excellent">Excellent</option>
                                    <option value="good">Good</option>
                                    <option value="fair">Fair</option>
                                    <option value="needs-work">Needs Work</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h3>Vehicle Features</h3>
                        <div class="feature-grid">
                            <div class="feature-group">
                                <h4>Comfort & Convenience</h4>
                                <div class="feature-checkboxes">
                                    <div class="checkbox-item">
                                        <input type="checkbox" id="feature-leather" name="features[]" value="leather-seats">
                                        <label for="feature-leather">Leather Seats</label>
                                    </div>
                                    <div class="checkbox-item">
                                        <input type="checkbox" id="feature-heated-seats" name="features[]" value="heated-seats">
                                        <label for="feature-heated-seats">Heated Seats</label>
                                    </div>
                                    <div class="checkbox-item">
                                        <input type="checkbox" id="feature-climate-control" name="features[]" value="climate-control">
                                        <label for="feature-climate-control">Climate Control</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="feature-group">
                                <h4>Technology</h4>
                                <div class="feature-checkboxes">
                                    <div class="checkbox-item">
                                        <input type="checkbox" id="feature-navigation" name="features[]" value="navigation">
                                        <label for="feature-navigation">Navigation System</label>
                                    </div>
                                    <div class="checkbox-item">
                                        <input type="checkbox" id="feature-bluetooth" name="features[]" value="bluetooth">
                                        <label for="feature-bluetooth">Bluetooth</label>
                                    </div>
                                    <div class="checkbox-item">
                                        <input type="checkbox" id="feature-backup-camera" name="features[]" value="backup-camera">
                                        <label for="feature-backup-camera">Backup Camera</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="feature-group">
                                <h4>Performance</h4>
                                <div class="feature-checkboxes">
                                    <div class="checkbox-item">
                                        <input type="checkbox" id="feature-alloy-wheels" name="features[]" value="alloy-wheels">
                                        <label for="feature-alloy-wheels">Alloy Wheels</label>
                                    </div>
                                    <div class="checkbox-item">
                                        <input type="checkbox" id="feature-sunroof" name="features[]" value="sunroof">
                                        <label for="feature-sunroof">Sunroof</label>
                                    </div>
                                    <div class="checkbox-item">
                                        <input type="checkbox" id="feature-cruise-control" name="features[]" value="cruise-control">
                                        <label for="feature-cruise-control">Cruise Control</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h3>Car Images</h3>
                        <div class="file-upload">
                            <input type="file" id="car-images" name="car-images[]" accept="image/*" multiple>
                            <label for="car-images" class="file-upload-label">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                                Upload Car Images (Up to 5)
                            </label>
                            <div id="file-list" class="file-list"></div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h3>Additional Details</h3>
                        <div class="form-group full-width">
                            <label for="description">Car Description</label>
                            <textarea id="description" name="description" placeholder="Provide additional details about the car..." rows="4"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="reset" class="secondary-button">Reset Form</button>
                        <button type="submit" class="primary-button">List Car</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </main>

    <?php
    // Include footer
    include '../PHP/footer.php';
    ?>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Vehicle | CarMarket</title>
    <link rel="stylesheet" href="../CSS/CarDetails.css">
    <link rel="stylesheet" href="../CSS/EditCar.css">
</head>
<body>
    <?php
    // Include header
    include '../PHP/header.php';
    ?>

    <?php
    // Include car data processing for edit
    require_once '../PHP/EditCar_data.php';
    ?>

    <main class="car-details-page edit-car-page">
        <div class="back-button-container">
            <a href="../WebPages/seller-inquiries.php" class="back-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5"></path>
                    <path d="M12 19l-7-7 7-7"></path>
                </svg>
                Back to My Inquiries
            </a>
        </div>

        <?php if (isset($error_message)): ?>
            <div class="flash-message flash-error">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($success_message)): ?>
            <div class="flash-message flash-success">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <h1>Edit Vehicle Details</h1>

        <?php if (isset($car)): ?>
            <form class="edit-car-form" method="post" action="../PHP/EditCar_data.php" enctype="multipart/form-data">
                <input type="hidden" name="car_id" value="<?php echo $car['car_id']; ?>">
                
                <div class="form-section">
                    <h2>Basic Information</h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="maker">Make</label>
                            <input type="text" id="maker" name="maker" value="<?php echo htmlspecialchars($car['maker']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="model">Model</label>
                            <input type="text" id="model" name="model" value="<?php echo htmlspecialchars($car['model']); ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="year">Year</label>
                            <input type="number" id="year" name="year" value="<?php echo $car['year']; ?>" min="1900" max="<?php echo date('Y') + 1; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price ($)</label>
                            <input type="number" id="price" name="price" value="<?php echo $car['price']; ?>" min="0" step="0.01" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="mileage">Mileage</label>
                            <input type="number" id="mileage" name="mileage" value="<?php echo $car['mileage']; ?>" min="0" required>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2>Vehicle Image</h2>
                    <div class="car-image-preview">
                        <?php if (!empty($car['image_path'])): ?>
                            <img src="<?php echo htmlspecialchars($car['image_path']); ?>" alt="<?php echo htmlspecialchars($car['year'] . ' ' . $car['maker'] . ' ' . $car['model']); ?>">
                        <?php else: ?>
                            <div class="no-image">
                                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                                <p>No image available</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-row">
                        <div class="form-group full-width">
                            <label for="image_path">Image URL</label>
                            <input type="text" id="image_path" name="image_path" value="<?php echo htmlspecialchars($car['image_path'] ?? ''); ?>" placeholder="Enter a URL to an image of your vehicle">
                            <small>Enter a direct link to an image (e.g., https://example.com/car-image.jpg)</small>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2>Features</h2>
                    <div class="features-grid">
                        <?php foreach ($all_features as $feature): ?>
                            <div class="feature-checkbox">
                                <input type="checkbox" id="feature-<?php echo $feature['feature_id']; ?>" name="features[]" value="<?php echo $feature['feature_id']; ?>" <?php echo in_array($feature['feature_id'], $car_features) ? 'checked' : ''; ?>>
                                <label for="feature-<?php echo $feature['feature_id']; ?>"><?php echo htmlspecialchars($feature['feature_name']); ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="../WebPages/seller-inquiries.php" class="cancel-btn">Cancel</a>
                    <button type="submit" name="update_car" class="save-btn">Save Changes</button>
                </div>
            </form>
        <?php else: ?>
            <div class="no-car-found">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <h2>Vehicle Not Found</h2>
                <p>The vehicle you're trying to edit does not exist or you don't have permission to edit it.</p>
                <a href="../WebPages/seller-inquiries.php" class="back-link">Back to My Inquiries</a>
            </div>
        <?php endif; ?>
    </main>

    <script src="../JS/EditCar.js"></script>
</body>
</html>
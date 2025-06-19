<?php 
require_once "../PHP/Connection.php";
$cars = [];

try {
    // Prepare SQL query to fetch cars with their features
    $sql = "SELECT 
                c.car_id, 
                c.maker, 
                c.model, 
                c.year, 
                c.price, 
                c.image_path,
                GROUP_CONCAT(DISTINCT f.feature_name SEPARATOR ', ') AS features
            FROM 
                cars c
            LEFT JOIN 
                car_features cf ON c.car_id = cf.car_id
            LEFT JOIN 
                features f ON cf.feature_id = f.feature_id
            GROUP BY 
                c.car_id, c.maker, c.model, c.year, c.price, c.image_path";

    // Prepare and execute the statement
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Fetch all results
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    // Log the error or display a user-friendly message
    error_log("Database Error: " . $e->getMessage());
    echo "Sorry, there was a problem retrieving car information.";
    exit;
}
?>

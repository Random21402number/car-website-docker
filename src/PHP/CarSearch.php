<?php
/**
 * Gets search results based on user-provided filters
 * 
 * @param PDO $pdo - Database connection object
 * @return array - Contains cars data, total count, pagination info
 */
function getSearchResults($pdo) {
    // Initialize the WHERE clause components
    $where = [];
    $params = [];
    
    // Get all the search parameters from GET request
    $query = isset($_GET['query']) ? trim($_GET['query']) : '';
    $brand = isset($_GET['brand']) ? trim($_GET['brand']) : '';
    $model = isset($_GET['model']) ? trim($_GET['model']) : '';
    $yearFrom = isset($_GET['year-from']) ? (int)$_GET['year-from'] : 0;
    $yearTo = isset($_GET['year-to']) ? (int)$_GET['year-to'] : 0;
    $minPrice = isset($_GET['min-price']) ? (float)$_GET['min-price'] : 0;
    $maxPrice = isset($_GET['max-price']) ? (float)$_GET['max-price'] : 0;
    $features = isset($_GET['features']) ? $_GET['features'] : [];
    
    // Build search query - main text search for maker or model
    if (!empty($query)) {
        $where[] = "(c.maker LIKE :query1 OR c.model LIKE :query2)";
        $params[':query1'] = "%$query%";
        $params[':query2'] = "%$query%";
    }
    
    // Filter by brand/maker
    if (!empty($brand)) {
        $where[] = "c.maker LIKE :brand";
        $params[':brand'] = "%$brand%";
    }
    
    // Filter by model
    if (!empty($model)) {
        $where[] = "c.model LIKE :model";
        $params[':model'] = "%$model%";
    }
    
    // Filter by year range - minimum year
    if ($yearFrom > 0) {
        $where[] = "c.year >= :yearFrom";
        $params[':yearFrom'] = $yearFrom;
    }
    
    // Filter by year range - maximum year
    if ($yearTo > 0) {
        $where[] = "c.year <= :yearTo";
        $params[':yearTo'] = $yearTo;
    }
    
    // Filter by price range - minimum price
    if ($minPrice > 0) {
        $where[] = "c.price >= :minPrice";
        $params[':minPrice'] = $minPrice;
    }
    
    // Filter by price range - maximum price
    if ($maxPrice > 0) {
        $where[] = "c.price <= :maxPrice";
        $params[':maxPrice'] = $maxPrice;
    }
    
    // Base SQL query - start with selecting all cars
    $sql = "SELECT DISTINCT c.* FROM Cars c";
    
    // If features filter is applied, join with the features tables
    if (!empty($features)) {
        $sql .= " LEFT JOIN Car_Features cf ON c.car_id = cf.car_id 
                  LEFT JOIN Features f ON cf.feature_id = f.feature_id";
        
        // Build feature conditions for each selected feature
        $featureConditions = [];
        foreach ($features as $index => $feature) {
            $featureConditions[] = "f.feature_name = :feature{$index}";
            $params[":feature{$index}"] = $feature;
        }
        
        // Add feature conditions to the WHERE clause with OR (car has any of the selected features)
        if (!empty($featureConditions)) {
            $where[] = "(" . implode(" OR ", $featureConditions) . ")";
        }
    }
    
    // Add WHERE clause if there are any conditions
    if (!empty($where)) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }
    
    // Add sorting based on user selection (default: price ascending)
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'price_asc';
    
    switch ($sort) {
        case 'price_desc':
            $sql .= " ORDER BY c.price DESC";
            break;
        case 'year_desc':
            $sql .= " ORDER BY c.year DESC";
            break;
        case 'year_asc':
            $sql .= " ORDER BY c.year ASC";
            break;
        case 'price_asc':
        default:
            $sql .= " ORDER BY c.price ASC";
            break;
    }
    
    // Pagination settings
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $results_per_page = 9; // Show 9 cars per page
    $offset = ($page - 1) * $results_per_page;
    
    // Add LIMIT clause for pagination
    $sql .= " LIMIT :offset, :limit";
    $params[':offset'] = $offset;
    $params[':limit'] = $results_per_page;
    
    // Prepare and execute the statement
    $stmt = $pdo->prepare($sql);
    
    // Bind parameters with proper types
    foreach ($params as $key => $value) {
        if (is_int($value)) {
            $stmt->bindValue($key, $value, PDO::PARAM_INT);
        } elseif (is_float($value)) {
            $stmt->bindValue($key, $value, PDO::PARAM_STR);
        } else {
            $stmt->bindValue($key, $value, PDO::PARAM_STR);
        }
    }
    
    $stmt->execute();
    
    // Process results into cars array
    $cars = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Get features for each car with a separate query
        $car_id = $row['car_id'];
        $features_sql = "SELECT f.feature_name FROM Features f 
                         JOIN Car_Features cf ON f.feature_id = cf.feature_id 
                         WHERE cf.car_id = :car_id";
        
        $features_stmt = $pdo->prepare($features_sql);
        $features_stmt->bindValue(':car_id', $car_id, PDO::PARAM_INT);
        $features_stmt->execute();
        
        // Build features array for this car
        $car_features = $features_stmt->fetchAll(PDO::FETCH_COLUMN);
        
        // Add features to car data
        $row['features'] = $car_features;
        $cars[] = $row;
    }
    
    // Get total count for pagination
    $count_sql = "SELECT COUNT(DISTINCT c.car_id) as total FROM Cars c";
    
    // Add same joins as main query if using feature filters
    if (!empty($features)) {
        $count_sql .= " LEFT JOIN Car_Features cf ON c.car_id = cf.car_id 
                       LEFT JOIN Features f ON cf.feature_id = f.feature_id";
    }
    
    // Use same WHERE conditions as main query
    if (!empty($where)) {
        $count_sql .= " WHERE " . implode(" AND ", $where);
    }
    
    // Remove LIMIT parameters for count query
    unset($params[':offset'], $params[':limit']);
    
    $count_stmt = $pdo->prepare($count_sql);
    
    // Bind parameters for count query
    foreach ($params as $key => $value) {
        if (is_int($value)) {
            $count_stmt->bindValue($key, $value, PDO::PARAM_INT);
        } elseif (is_float($value)) {
            $count_stmt->bindValue($key, $value, PDO::PARAM_STR);
        } else {
            $count_stmt->bindValue($key, $value, PDO::PARAM_STR);
        }
    }
    
    $count_stmt->execute();
    $total_cars = $count_stmt->fetchColumn();
    
    // Return all necessary information for display and pagination
    return [
        'cars' => $cars,                                    // Car data
        'total' => $total_cars,                            // Total number of matches
        'pages' => ceil($total_cars / $results_per_page),  // Total number of pages
        'current_page' => $page                            // Current page number
    ];
}

/**
 * Generates HTML pagination links based on search results
 * 
 * @param array $results - The results array returned by getSearchResults()
 * @param array $get_params - The current GET parameters
 * @return string - HTML for pagination controls
 */
function generatePaginationLinks($results, $get_params) {
    $current_page = $results['current_page'];
    $total_pages = $results['pages'];
    
    // Don't show pagination if there's only one page
    if ($total_pages <= 1) {
        return '';
    }
    
    // Create a copy of GET parameters without the page parameter
    $params = $get_params;
    unset($params['page']);
    $query_string = http_build_query($params);
    
    $output = '<div class="pagination">';
    
    // Previous button - only show if not on first page
    if ($current_page > 1) {
        $output .= '<a href="?page=' . ($current_page - 1) . '&' . $query_string . '">&laquo; Prev</a>';
    }
    
    // Calculate which page numbers to show
    $start_page = max(1, $current_page - 2);  // Show 2 pages before current
    $end_page = min($total_pages, $current_page + 2);  // Show 2 pages after current
    
    // Always show first page and ellipsis if needed
    if ($start_page > 1) {
        $output .= '<a href="?page=1&' . $query_string . '">1</a>';
        if ($start_page > 2) {
            $output .= '<span>...</span>';
        }
    }
    
    // Generate numbered page links
    for ($i = $start_page; $i <= $end_page; $i++) {
        if ($i == $current_page) {
            $output .= '<span class="current">' . $i . '</span>';
        } else {
            $output .= '<a href="?page=' . $i . '&' . $query_string . '">' . $i . '</a>';
        }
    }
    
    // Always show last page and ellipsis if needed
    if ($end_page < $total_pages) {
        if ($end_page < $total_pages - 1) {
            $output .= '<span>...</span>';
        }
        $output .= '<a href="?page=' . $total_pages . '&' . $query_string . '">' . $total_pages . '</a>';
    }
    
    // Next button - only show if not on last page
    if ($current_page < $total_pages) {
        $output .= '<a href="?page=' . ($current_page + 1) . '&' . $query_string . '">Next &raquo;</a>';
    }
    
    $output .= '</div>';
    
    return $output;
}
?>
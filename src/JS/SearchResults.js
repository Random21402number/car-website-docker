/**
 * Updates the sort order of the search results
 * @param {string} sortValue - The sort value to apply (price_asc, price_desc, etc.)
 */
function updateSort(sortValue) {
    // Get current URL with all existing parameters
    const url = new URL(window.location.href);
    
    // Set or update the sort parameter
    url.searchParams.set('sort', sortValue);
    
    // Reset to first page when sorting changes to avoid pagination issues
    url.searchParams.set('page', 1);
    
    // Redirect to the new URL with updated parameters
    window.location.href = url.toString();
}

/**
 * Redirects to the car details page for a specific car
 * @param {number} carId - The unique ID of the car to view
 */
function viewCarDetails(carId) {
    // Redirect to car details page with car ID as parameter
    window.location.href = `CarDetails.php?id=${carId}`;
}
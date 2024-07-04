<?php
// Include the database configuration file
include('includes/config.php');

// Check if the form data is received via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if donorUserId, neededTime, and cost are set in the POST data
    if (isset($_POST['donorUserId']) && isset($_POST['neededTime']) && isset($_POST['cost'])) {
        // Retrieve donorUserId, neededTime, and cost from the POST data
        $donorUserId = $_POST['donorUserId'];
        $neededTime = $_POST['neededTime'];
        $cost = $_POST['cost'];

        try {
            // Prepare and execute the SQL query to update the ThirdLookingFor table
            $sql = "UPDATE ThirdLookingFor SET Cost = :cost WHERE Donor_ID = :donorUserId";
            $query = $dbh->prepare($sql);
            $query->bindParam(':cost', $cost, PDO::PARAM_INT);
            $query->bindParam(':donorUserId', $donorUserId, PDO::PARAM_INT);
            $query->execute();

            // Dummy response for demonstration
            echo "Request processed successfully. Donor User ID: $donorUserId, Needed Time: $neededTime, Cost: $cost";
        } catch (PDOException $e) {
            // If an error occurs during database operation, return an error response
            http_response_code(500);
            echo "Error updating ThirdLookingFor table: " . $e->getMessage();
        }
    } else {
        // If donorUserId, neededTime, or cost is not set, return an error response
        http_response_code(400);
        echo "Error: Donor User ID, Needed Time, or Cost is not set.";
    }
} else {
    // If the request method is not POST, return an error response
    http_response_code(405);
    echo "Error: Method Not Allowed. Only POST method is allowed.";
}
?>

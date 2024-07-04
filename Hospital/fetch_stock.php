<?php

// Include the database configuration file
include('../includes/config.php');

// Establish database connection (replace these credentials with your actual database credentials)
$db_host = 'localhost';
$db_name = 'bbdms';
$db_user = 'root';
$db_pass = '';

try {
    $dbh = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection error
    echo json_encode(array('error' => 'Database connection failed: ' . $e->getMessage()));
    exit;
}

// Check if the bank ID is provided in the request
if(isset($_GET['bank_id'])) {
    $bankID = $_GET['bank_id'];

    // Query to fetch stock data for the specified bank ID
    $sql = "SELECT Blood_Group, Quantity FROM BloodBankStock WHERE bank_id = :bank_id";

    try {
        $query = $dbh->prepare($sql);
        $query->bindParam(':bank_id', $bankID, PDO::PARAM_INT);
        $query->execute();

        // Check if there are any results
        if ($query->rowCount() > 0) {
            // Fetch all results as objects
            $stockData = $query->fetchAll(PDO::FETCH_ASSOC);
            // Return stock data in JSON format
            echo json_encode($stockData);
        } else {
            // No results found
            echo json_encode(array('error' => 'No stock data found for the specified blood bank.'));
        }
    } catch (PDOException $e) {
        // Handle database error
        echo json_encode(array('error' => 'Error fetching stock data: ' . $e->getMessage()));
    }
} else {
    // Bank ID not provided in the request
    echo json_encode(array('error' => 'Blood bank ID not provided.'));
}

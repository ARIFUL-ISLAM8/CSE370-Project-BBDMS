<?php
// Include the database configuration file
include('../includes/config.php');
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
// Get form data
$transactionID = isset($_POST['transactionID']) ? $_POST['transactionID'] : '';
$amount = isset($_POST['amount']) ? $_POST['amount'] : '';

// Update the amount in the database
$sql = "UPDATE Payment SET Amount = :amount, Status = 'Paid' WHERE Transaction_ID = :transactionID";

try {
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':transactionID', $transactionID);
    $stmt->execute();

    // Redirect to a success page or display a success message
    echo "<script>alert('Payment completed');</script>";
    header("Location: ../Patient/PatientPanel.php?user_id=" . htmlentities($user_id));
    exit();
} catch (PDOException $e) {
    // Handle database errors
    echo "Error: " . $e->getMessage();
}
?>

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
    // Debugging statement
    echo "Database connected successfully.<br>";
} catch (PDOException $e) {
    // Handle connection error
    echo json_encode(array('error' => 'Database connection failed: ' . $e->getMessage()));
    exit;
}

// Check if the form data is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debugging statement
    echo "Form data submitted via POST method.<br>";
    // Print raw POST data for debugging
    echo "Raw POST Data: " . file_get_contents('php://input');

    // Retrieve and sanitize form data
    $hospitalID = isset($_POST['hospital_id']) ? intval($_POST['hospital_id']) : 0;
    $bankID = isset($_POST['bank_id']) ? intval($_POST['bank_id']) : 0;
    $bloodGroup = isset($_POST['blood_group']) ? $_POST['blood_group'] : '';
    $rhFactor = isset($_POST['rh_factor']) ? ($_POST['rh_factor'] === 'pos' ? '+' : ($_POST['rh_factor'] === 'neg' ? '-' : '')) : '';
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

    // Validate form data
    if ($hospitalID <= 0 || $bankID <= 0 || empty($bloodGroup) || empty($rhFactor) || $quantity <= 0) {
        // Invalid form data
        echo json_encode(array('error' => 'Invalid form data.'));
        exit;
    }

    // Validate blood group and Rh factor
    $validBloodGroups = array('A', 'B', 'AB', 'O');
    $validRhFactors = array('+', '-');
    if (!in_array($bloodGroup, $validBloodGroups) || !in_array($rhFactor, $validRhFactors)) {
        // Invalid blood group or Rh factor
        echo json_encode(array('error' => 'Invalid blood group or Rh factor.'));
        exit;
    }
    // Check if the record already exists
    $query = "SELECT * FROM orderfrom WHERE Hospital_Id = $hospitalID AND Bank_ID = $bankID";
    $result = mysqli_query($your_db_connection, $query);

    if(mysqli_num_rows($result) == 0) {
        // Record doesn't exist, so insert it
        $insertQuery = "INSERT INTO orderfrom (Hospital_Id, Bank_ID) VALUES ($hospitalID, $bankID)";
    // Construct the blood type
    $bloodType = $bloodGroup . $rhFactor;

    // Begin the transaction
    $dbh->beginTransaction();
    // Debugging statement
    echo "Transaction started.<br>";

    try {
        // Deduct the quantity from the blood bank stock
        $deductStockSQL = "UPDATE BloodBankStock SET Quantity = Quantity - :quantity WHERE Bank_ID = :bank_id AND Blood_Group = :blood_group";
        $deductStockStmt = $dbh->prepare($deductStockSQL);
        $deductStockStmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $deductStockStmt->bindParam(':bank_id', $bankID, PDO::PARAM_INT);
        $deductStockStmt->bindParam(':blood_group', $bloodType, PDO::PARAM_STR);
        $deductStockStmt->execute();
        // Debugging statement
        echo "Quantity deducted from blood bank stock.<br>";

        // Check if the deduction was successful
        if ($deductStockStmt->rowCount() <= 0) {
            throw new Exception('Failed to deduct stock from the blood bank.');
        }

        // Add the quantity to the hospital's stock
        $addStockSQL = "UPDATE stock SET Quantity = Quantity + :quantity WHERE Hospital_Id = :hospital_id AND Blood_Type = :blood_group";
        $addStockStmt = $dbh->prepare($addStockSQL);
        $addStockStmt->bindParam(':hospital_id', $hospitalID, PDO::PARAM_INT);
        $addStockStmt->bindParam(':blood_group', $bloodType, PDO::PARAM_STR);
        $addStockStmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $addStockStmt->execute();
        // Debugging statement
        echo "Quantity added to hospital's stock.<br>";

        // Commit the transaction
        $dbh->commit();
        // Debugging statement
        echo "Transaction committed successfully.<br>";

        // Order placed successfully
        echo json_encode(array('success' => 'Order placed successfully.'));
    } catch (PDOException $e) {
        // Rollback the transaction on database error
        $dbh->rollBack();
        // Debugging statement
        echo "Transaction rolled back due to database error.<br>";
        // Handle database error
        echo json_encode(array('error' => 'Database error: ' . $e->getMessage()));
    } catch (Exception $e) {
        // Rollback the transaction on other errors
        $dbh->rollBack();
        // Debugging statement
        echo "Transaction rolled back due to other error.<br>";
        // Handle other errors
        echo json_encode(array('error' => $e->getMessage()));
    }
  } else {
    // Record already exists
    echo "Record already exists.";
  }
} else {
    // If the request method is not POST
    echo json_encode(array('error' => 'Invalid request method. Only POST requests are allowed.'));
}
?>

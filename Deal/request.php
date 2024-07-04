<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include jQuery UI CSS for calendar -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Payment Form
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="form-group">
                            <label for="donorUserId">Donor User ID:</label>
                            <input type="number" class="form-control" id="donorUserId" name="donorUserId" required>
                        </div>
                        <div class="form-group">
                            <label for="neededTime">Time of Need:</label>
                            <input type="text" class="form-control" id="neededTime" name="neededTime" required>
                        </div>
                        <!-- Hidden input field to pass patient user ID -->
                        <input type="hidden" name="patientUserId" value="<?php echo isset($_GET['user_id']) ? htmlspecialchars($_GET['user_id']) : ''; ?>">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Include jQuery UI for calendar -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(document).ready(function () {
        // Initialize jQuery UI Datepicker
        $('#neededTime').datepicker({
            dateFormat: 'yy-mm-dd' // Set date format
        });
    });
</script>

</body>
</html>

<?php
error_reporting(E_ALL);
session_start();

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
    echo "Connection failed: " . $e->getMessage();
    exit(); // Exit script if database connection fails
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get donor user ID from input
    $donorUserId = isset($_POST['donorUserId']) ? intval($_POST['donorUserId']) : 0;

    // Get time of need from calendar input
    $neededTime = isset($_POST['neededTime']) ? $_POST['neededTime'] : '';

    // Get patient user ID from the hidden input field
    $patientUserId = isset($_POST['patientUserId']) ? intval($_POST['patientUserId']) : 0;

    try {
        // Prepare INSERT statement for Payment table
        $sqlPayment = "INSERT INTO Payment (Status, Amount, DuserID,PuserID) VALUES (:status, :amount, :duserID,:puserID )";
        $stmtPayment = $dbh->prepare($sqlPayment);
        $stmtPayment->bindValue(':status', 'Running');
        $stmtPayment->bindValue(':amount', 0);
		$stmtPayment->bindValue(':duserID', $donorUserId);
        $stmtPayment->bindValue(':puserID', $patientUserId);

        // Execute the Payment statement
        if ($stmtPayment->execute()) {
            // Get the last inserted ID (Transaction_ID) for Payment
            $transactionID = $dbh->lastInsertId();

            // Prepare INSERT statement for SecondLookingFor table
            $sqlSecondLookingFor = "INSERT INTO SecondLookingFor (User_ID, Time_Of_Need) VALUES (:userID, :timeOfNeed)";
            $stmtSecondLookingFor = $dbh->prepare($sqlSecondLookingFor);
            $stmtSecondLookingFor->bindValue(':userID', $patientUserId);
            $stmtSecondLookingFor->bindValue(':timeOfNeed', $neededTime);

            // Execute the SecondLookingFor statement
            if ($stmtSecondLookingFor->execute()) {
				// Insert successful
				echo "Payment and time of need records inserted successfully.";
				// Redirect to PatientPanel.php with the user ID of the patient
				header("Location: ../Patient/PatientPanel.php?user_id=" . $patientUserId);
				exit(); // Make sure to exit after redirecting
			} else {
				// Insert failed for SecondLookingFor
				echo "Error: Unable to insert time of need record for SecondLookingFor.";
			}			
        } else {
            // Insert failed for Payment
            echo "Error: Unable to insert payment record.";
        }
    } catch (PDOException $e) {
        // Display error message
        echo "Error: " . $e->getMessage();
    }
}
?>

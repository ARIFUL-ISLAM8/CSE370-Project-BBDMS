<?php 
error_reporting(0);
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
}
// Get the PuserID from the URL
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

// SQL query with the join and condition
$sql = "SELECT 
            p.Transaction_ID,
            p.Amount,
            p.Status,
            p.PuserID,
            p.DuserID,
            s.Time_Of_Need,
            P.Cost
        FROM 
            Payment p
        LEFT JOIN 
            SecondLookingFor s ON p.PuserID = s.User_ID
        WHERE 
            p.PuserID = :user_id";

try {
    $query = $dbh->prepare($sql);
    $query->bindParam(':user_id', $user_id);
    $query->execute();

    // Check if there are any results
    if ($query->rowCount() > 0) {
        // Fetch all results as objects
        $results = $query->fetchAll(PDO::FETCH_OBJ);
    } else {
        // No results found, display a message or handle it as needed
        echo "<p>No data found for the provided user ID.</p>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Payment Details</h2>
    <?php if (!empty($results)) : ?>
        <form method="post" action="pay.php?user_id=<?php echo htmlentities($user_id); ?>"> 
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="transactionID">Transaction ID</label>
                        <input type="text" class="form-control" id="transactionID" name="transactionID" value="<?php echo $results[0]->Transaction_ID; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <input type="text" class="form-control" id="status" name="status" value="<?php echo $results[0]->Status; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="pUserID">PUserID</label>
                        <input type="text" class="form-control" id="pUserID" name="pUserID" value="<?php echo $results[0]->PuserID; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="dUserID">DUserID</label>
                        <input type="text" class="form-control" id="dUserID" name="dUserID" value="<?php echo $results[0]->DuserID; ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="timeOfNeed">Time Of Need</label>
                        <input type="text" class="form-control" id="timeOfNeed" name="timeOfNeed" value="<?php echo $results[0]->Time_Of_Need; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="cost">Cost</label>
                        <input type="text" class="form-control" id="cost" name="cost" value="<?php echo $results[0]->Cost; ?>" readonly>
                    </div>
					<div class="form-group">
						<label for="payment-method">Payment Method</label>
						<select class="form-control" id="payment-method" name="payment-method" required>
							<option value="" disabled selected>Select Payment Method</option>
							<option value="bkash">Bkash</option>
							<option value="card">Card</option>
							<option value="rocket">Rocket</option>
							<option value="nagad">Nagad</option>
							<option value="bank-account">Bank Account</option>
						</select>
					</div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter Amount" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Pay</button>
        </form>
    <?php else : ?>
        <p>No data found.</p>
    <?php endif; ?>
</div>

<!-- Include Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

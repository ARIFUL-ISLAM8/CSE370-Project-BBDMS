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


// Ensure correct retrieval and assignment of user ID
$donorUserId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;


// Fetch patient details if necessary
$result = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cost = $_POST['cost'];
    $pUserID = isset($_POST['pUserID']) ? $_POST['pUserID'] : ''; // Retrieve patient ID from form submission
    $transactionID = isset($_POST['transactionID']) ? $_POST['transactionID'] : ''; // Retrieve transaction ID from form submission

    try {
        // Prepare UPDATE statement to set the Cost in the payment table
        $sql = "UPDATE payment SET Cost = :cost WHERE Transaction_ID = :transactionID";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':transactionID', $transactionID, PDO::PARAM_INT);
        $stmt->bindParam(':cost', $cost, PDO::PARAM_STR);
    
        // Execute the statement
        $stmt->execute();
        
        // Redirect to a success page or display a success message
        header("Location: ../Donor/DonorPanel.php?user_id=$donorUserId");
        exit();
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
}

try {
    // Prepare SELECT statement to retrieve requests received by the donor for the provided user ID from the Payment table
    $sql = "SELECT * FROM Payment WHERE DuserID = :donorUserId";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':donorUserId', $donorUserId, PDO::PARAM_INT);

    // Execute the statement
    $stmt->execute();
    
    // Check if there are any requests
    if ($stmt->rowCount() > 0) {
        echo "</div>";
    } else {
        echo "No requests received by this donor for the provided user ID.";
    }
} catch (PDOException $e) {
    // Display error message
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
	<title>Blood Bank Donor Management System - Request Received</title>
	
	<script>
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>

	<!-- Custom-Files -->
	<link rel="stylesheet" href="../css/bootstrap.css">
	<!-- Bootstrap-Core-CSS -->
	<link rel="stylesheet" href="../css/style.css" type="text/css" media="all" />
	<!-- Style-CSS -->
	<link rel="stylesheet" href="../css/fontawesome-all.css">
	<!-- Font-Awesome-Icons-CSS -->
	<!-- //Custom-Files -->

	<!-- Web-Fonts -->
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
	    rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
	    rel="stylesheet">
	<!-- //Web-Fonts -->

</head>

<body>
<!-- header -->
<div id="home">
    <!-- navigation -->
    <div class="main-top py-1">
        <nav class="navbar navbar-expand-lg navbar-light fixed-navi">
            <div class="container">
                <!-- logo -->
                <h1>
                    <a class="navbar-brand font-weight-bold font-italic" href="../Donor/DonorPanel.php?user_id=<?php echo $donorUserId; ?>">
                        <span>BB</span>DMS
                        <i class="fas fa-syringe"></i>
                    </a>
                </h1>
                <!-- //logo -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="breadcrumb-agile">
                    <div aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="../Donor/DonorPanel.php?user_id=<?php echo $donorUserId; ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Donor Profile</li>
                        </ol>
                    </div>
                </div>
                <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
                    <a href="../request-received.php?user_id=<?php echo $donorUserId; ?>" class="login-button ml-lg-3 mt-lg-0 mt-4 mb-lg-0 mb-3">
                        <i class="fas fa-user-plus mr-2"></i>Request Received
                    </a>
                    <a href="contact.php?user_id=<?php echo $donorUserId; ?>" class="ml-lg-3 mt-lg-0 mt-4 mb-lg-0 mb-3">
                        <i class="fas fa-user-plus mr-2"></i>Contact Us
                    </a>
                    <a href="../logout.php" class="login-button ml-lg-3 mt-lg-0 mt-4 mb-lg-0 mb-3 logout-button">
                        <i class="fas fa-sign-in-alt mr-2"></i>Log Out
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <!-- banner 2 -->
    <div class="inner-banner-w3ls">
        <div class="container">
        </div>
    </div>

	<!-- //page details -->
	<div class="appointment py-5">
		<div class="py-xl-5 py-lg-3">
			<div class="w3ls-titles text-center mb-5">
				<h3 class="title">Request Received</h3>
				<span>
					<i class="fas fa-user-md"></i>
				</span>
			</div>
			<div class="d-flex">		
				<div class="contact-right-w3l appoint-form" style="width:100% !important;">
					<h5 class="title-w3 text-center mb-5">Below is the detail of Blood Recipient.</h5>
					<table border="1" class="table table-bordered">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Age</th>
								<th>Health Issues</th>
								<th>Emergency Contact Name</th>
								<th>Emergency Contact</th>
								<th>Relationship</th>
								<th>Hospital Name</th>
								<th>Hospital Address</th>
                                <th>Time Of Need</th>
								<th>Cost</th>
                                <th>Status</th>
							</tr>
						</thead>                               
						<tbody>                                      
							<?php
							$uid=$_SESSION['bbdmsdid'];
							if ($stmt->rowCount() > 0) {
								while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
									// Fetch additional patient details
									$sqlPatientDetails = "SELECT 
                                    u.User_ID, 
                                    u.Name, 
                                    p.Age, 
                                    p.Hospital_Id, 
                                    GROUP_CONCAT(Issues SEPARATOR ', ') AS HealthIssues, 
                                    ec.Contact_ID, 
                                    ec.Relationship, 
                                    pc.Contact AS EmergencyContact, 
                                    cn.Name AS EmergencyContactName,
                                    h.Name AS HospitalName,
                                    h.Street AS HospitalStreet,
                                    hl.City AS HospitalCity,
                                    hl.Zip_Code AS HospitalZipCode,
                                    s.Time_Of_Need AS Time_Of_Need 
                                FROM 
                                    User u 
                                INNER JOIN 
                                    Patient p ON u.User_ID = p.User_ID 
                                LEFT JOIN 
                                    Issue i ON p.User_ID = i.User_ID
                                LEFT JOIN 
                                    EmergencyContact ec ON p.User_ID = ec.User_ID
                                LEFT JOIN 
                                    PatientContact pc ON p.User_ID = pc.User_ID
                                LEFT JOIN 
                                    ContactName cn ON ec.Contact_ID = cn.Contact_ID
                                LEFT JOIN 
                                    Hospital h ON p.Hospital_Id = h.Hospital_Id
                                LEFT JOIN 
                                    HospitalLocation hl ON h.City = hl.City
                                LEFT JOIN
                                    secondlookingfor s ON p.User_ID = s.User_ID
                                WHERE 
                                    u.User_ID = :puserId
                                GROUP BY 
                                    u.User_ID;";

									$stmtPatientDetails = $dbh->prepare($sqlPatientDetails);
									$stmtPatientDetails->bindParam(':puserId', $row['PuserID'], PDO::PARAM_INT);
									$stmtPatientDetails->execute();
									$result = $stmtPatientDetails->fetch(PDO::FETCH_ASSOC);
									?>
									<tr>
										<td><?php echo htmlentities($row['PuserID']);?></td>
										<td><?php echo htmlentities($result['Name']);?></td>
										<td><?php echo htmlentities($result['Age']);?></td>
										<td><?php echo htmlentities($result['HealthIssues']);?></td>
										<td><?php echo htmlentities($result['EmergencyContactName']);?></td>
										<td><?php echo htmlentities($result['EmergencyContact']);?></td>
										<td><?php echo htmlentities($result['Relationship']);?></td>
										<td><?php echo htmlentities($result['HospitalName']);?></td>
										<td><?php echo htmlentities($result['HospitalStreet'] . ', ' . $result['HospitalCity'] . ', ' . $result['HospitalZipCode']); ?></td>
										<td><?php echo htmlentities($result['Time_Of_Need']);?></td>
                                        <td>
                                            <?php
                                            // Show the form only when DuserID matches and Cost is null for the transaction
                                            if ($row['DuserID'] == $donorUserId && is_null($row['Cost'])) {
                                                // Display the form to update the cost
                                            ?>
                                                <form method="post">
                                                    <div class="form-group">
                                                        <label for="cost">Enter Cost (BDT):</label>
                                                        <input type="number" step="10" class="form-control" id="cost" name="cost" required>
                                                        <!-- Hidden input to pass the Patient ID -->
                                                        <input type="hidden" name="pUserID" value="<?php echo isset($result['User_ID']) ? htmlentities($result['User_ID']) : ''; ?>">
                                                        <!-- Hidden input to pass the Transaction ID -->
                                                        <input type="hidden" name="transactionID" value="<?php echo isset($row['Transaction_ID']) ? htmlentities($row['Transaction_ID']) : ''; ?>">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Submit Cost</button>
                                                </form>
                                            <?php
                                            } else {
                                                // Display the cost if already set
                                                echo htmlentities($row['Cost']);
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo htmlentities($row['Status']);?></td>
									</tr>
									<?php 
								} // end while
							} else { ?>
								<tr>
									<th colspan="9" style="color:red;"> No Record found</th>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="clerafix"></div>
			</div>
		</div>
	</div>
	<!-- //contact -->

	<?php include('includes/footer.php');?>
	<!-- Js files -->
	<!-- JavaScript -->
	<script src="js/jquery-2.2.3.min.js"></script>
	<!-- Default-JavaScript-File -->

	<!--start-date-piker-->
	<link rel="stylesheet" href="css/jquery-ui.css" />
	<script src="js/jquery-ui.js"></script>
	<script>
		$(function () {
			$("#datepicker,#datepicker1").datepicker();
		});
	</script>
	<!-- //End-date-piker -->

	<!-- fixed navigation -->
	<script src="../js/fixed-nav.js"></script>
	<!-- //fixed navigation -->

	<!-- smooth scrolling -->
	<script src="../js/SmoothScroll.min.js"></script>
	<!-- move-top -->
	<script src="../js/move-top.js"></script>
	<!-- easing -->
	<script src="../js/easing.js"></script>
	<!--  necessary snippets for few javascript files -->
	<script src="../js/medic.js"></script>

	<script src="../js/bootstrap.js"></script>
	<!-- Necessary-JavaScript-File-For-Bootstrap -->

	<!-- //Js files -->

</body>

</html>

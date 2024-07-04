<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(!isset($_SESSION['alogin']) || empty($_SESSION['alogin'])) 
	{	
header('location:../index.php');
}
else{

    // Assuming the User ID of the logged-in user is stored in $_SESSION['user_id']
    // Get the user_id from the URL parameter
    $loggedInUserID = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

    // Query to select patient details for the logged-in user
    $sql = "SELECT 
                u.User_ID, 
                u.Name,
                p.Blood_Group, 
                p.Age, 
                p.Hospital_Id, 
                GROUP_CONCAT(Issues SEPARATOR ', ') AS HealthIssues, 
                ec.Contact_ID, 
                ec.Relationship, 
                pc.Contact AS EmergencyContact, 
                cn.Name AS EmergencyContactName
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
            WHERE 
                u.User_ID = :loggedInUserID
            GROUP BY 
                u.User_ID";

    try {
        $query = $dbh->prepare($sql);
        $query->bindParam(':loggedInUserID', $loggedInUserID);
        $query->execute();

        // Check if there are any results
        if ($query->rowCount() > 0) {
            // Fetch all results as objects
            $results = $query->fetchAll(PDO::FETCH_OBJ);
        } else {
            // No results found, display a message or handle it as needed
            echo "<p>No data found.</p>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Blood Bank Donor Management System | Patient Profile</title>
    <!-- Meta tag Keywords -->

    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!--// Meta tag Keywords -->

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
                    <a class="navbar-brand font-weight-bold font-italic" href="PatientPanel.php?user_id=<?php echo htmlentities($loggedInUserID); ?>">
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
                            <a href="PatientPanel.php?user_id=<?php echo htmlentities($loggedInUserID); ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Patient Profile</li>
                        </ol>
                    </div>
                </div>
                <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
                    <a href="donor-list.php?user_id=<?php echo htmlentities($loggedInUserID); ?>" class="login-button ml-lg-3 mt-lg-0 mt-4 mb-lg-0 mb-3">
                        <i class="fas fa-sign-in-alt mr-2"></i>Donor List
                    </a>
                    <a href="../Deal/request.php?user_id=<?php echo htmlentities($loggedInUserID); ?>" class="login-button ml-lg-3 mt-lg-0 mt-4 mb-lg-0 mb-3">
                        <i class="fas fa-sign-in-alt mr-2"></i>Request
                    </a>
                    <?php
                    // Check if the amount is 0 in Payment
                    $sqlCheckAmount = "SELECT * FROM Payment WHERE PuserID = :user_id AND Amount = 0";
                    $stmtCheckAmount = $dbh->prepare($sqlCheckAmount);
                    $stmtCheckAmount->bindParam(':user_id', $loggedInUserID, PDO::PARAM_INT);
                    $stmtCheckAmount->execute();
                    $paymentCount = $stmtCheckAmount->rowCount();
                    ?>

                    <!-- Display the "Payment" button only when the amount is 0 -->
                    <?php if ($paymentCount > 0) : ?>
                        <a href="../Deal/payment.php?user_id=<?php echo htmlentities($loggedInUserID); ?>" class="btn ml-lg-3 mt-lg-0 mt-4 mb-lg-0 mb-3">
                            <i class="fas fa-sign-in-alt mr-2"></i>Payment
                        </a>
                    <?php endif; ?>
                    <a href="contact.php?user_id=<?php echo $loggedInUserID; ?>" class="ml-lg-3 mt-lg-0 mt-4 mb-lg-0 mb-3">
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

    <!-- patient profile -->
    <div class="agileits-contact py-5">
        <div class="py-xl-5 py-lg-3">
            <div class="w3ls-titles text-center mb-5">
                <h3 class="title">Patient Profile</h3>
                <span>
                    <i class="fas fa-user"></i>
                </span>
                <p class="mt-2">Welcome to your patient profile. View your information here.</p>
            </div>
            <div class="container">
                <div class="row">
                    <?php foreach ($results as $result) : ?>
                        <!-- Left column for profile pic and name -->
                        <div class="col-md-4">
                            <div class="text-center">
                                <!-- Name with User ID -->
                                <img src="../images/profile3.jpg" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 150px;">
                                <h3><?php echo htmlentities($result->Name); ?> (User ID: <?php echo htmlentities($result->User_ID); ?>)</h3>
                            </div>
                        </div>

                        <!-- Right column for other details -->
                        <div class="price-bottom p-4 border rounded mb-3">
                            <div class="profile-info">
                                <p><strong>BLood Group:</strong> <?php echo htmlentities($result->Blood_Group); ?></p>
                                <p><strong>Age:</strong> <?php echo htmlentities($result->Age); ?></p>
                                <p><strong>Hospital ID:</strong> <?php echo htmlentities($result->Hospital_Id); ?></p>
                                <p><strong>Health Issues:</strong> <?php echo htmlentities($result->HealthIssues); ?></p>
                                <p><strong>Emergency Contact ID:</strong> <?php echo htmlentities($result->Contact_ID); ?></p>
                                <p><strong>Relationship:</strong> <?php echo htmlentities($result->Relationship); ?></p>
                                <p><strong>Emergency Contact:</strong> <?php echo htmlentities($result->EmergencyContact); ?></p>
                                <p><strong>Emergency Contact Name:</strong> <?php echo htmlentities($result->EmergencyContactName); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- //patient profile -->
</div> <!-- Close the #home div -->

<!-- Js files -->
<!-- JavaScript -->
<script src="../s/jquery-2.2.3.min.js"></script>
<!-- Default-JavaScript-File -->

<!-- fixed navigation -->
<script src="../js/fixed-nav.js"></script>
<!-- //fixed navigation -->

<script src="../js/bootstrap.js"></script>
<!-- Necessary-JavaScript-File-For-Bootstrap -->

</body>

</html>

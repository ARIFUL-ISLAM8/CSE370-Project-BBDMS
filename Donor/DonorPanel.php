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

    // Query to select preferred donation centers for the logged-in user
    $sql = "SELECT 
                u.Name AS DonorName, 
                d.Gender, 
                d.Age, 
                d.Occupation, 
                d.Street, 
                dc.City, 
                d.Blood_Group,
                dc.Zip_Code AS CityZipCode, 
                GROUP_CONCAT(DISTINCT p.Preferred_Donation_Center SEPARATOR ', ') AS PreferredDonationCenters,  
                r.Remarks, 
                dl1.Last_Date_Of_Donation, 
                dl1.Amount_Of_Blood_Donated, 
                dl2.Donation_Frequency
            FROM 
                User u 
            INNER JOIN 
                Donor d ON u.User_ID = d.User_ID 
            INNER JOIN 
                DonorCity dc ON d.City = dc.City 
            LEFT JOIN 
                DonorContact dc2 ON d.User_ID = dc2.User_ID
            LEFT JOIN 
                Preference p ON d.User_ID = p.User_ID
            LEFT JOIN 
                Remark r ON d.User_ID = r.User_ID
            LEFT JOIN 
                Donation_Log_1 dl1 ON d.User_ID = dl1.User_ID
            LEFT JOIN 
                Donation_Log_2 dl2 ON d.User_ID = dl2.User_ID
            LEFT JOIN 
                DonorCity dc1 ON p.Preferred_Donation_Center = dc1.City
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
    <title>Blood Bank Donor Management System | Donor Profile</title>
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
                    <a class="navbar-brand font-weight-bold font-italic" href="DonorPanel.php?user_id=<?php echo $loggedInUserID; ?>">
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
                                <a href="DonorPanel.php?user_id=<?php echo $loggedInUserID; ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Donor Profile</li>
                        </ol>
                    </div>
                </div>
                <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
                    <a href="../Deal/request-received.php?user_id=<?php echo $loggedInUserID; ?>" class="login-button ml-lg-3 mt-lg-0 mt-4 mb-lg-0 mb-3">
                        <i class="fas fa-user-plus mr-2"></i>Request Received
                    </a>
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

    <!-- donor profile -->
    <div class="agileits-contact py-5">
        <div class="py-xl-5 py-lg-3">
            <div class="w3ls-titles text-center mb-5">
                <h3 class="title">Donor Profile</h3>
                <span>
                    <i class="fas fa-user"></i>
                </span>
                <p class="mt-2">Welcome to your donor profile. Update your information here.</p>
            </div>
            <div class="container">
                <div class="row">
                    <?php foreach ($results as $result) : ?>
                        <!-- Left column for profile pic and name -->
                        <div class="col-md-4">
                            <div class="text-center">
                                <!-- Profile picture (you can replace the source with your actual image path) -->
                                <img src="../images/profile.jpg" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 150px;">
                                <!-- Name with User ID -->
                                <h3><?php echo htmlentities($result->DonorName); ?> (User ID: <?php echo htmlentities($loggedInUserID); ?>)</h3>
                            </div>
                        </div>

                        <!-- Right column for other details -->
                        <div class="price-bottom p-4 border rounded mb-3">
                            <div class="profile-info">
                                <!-- Other details -->
                                <p><strong>Gender:</strong> <?php echo htmlentities($result->Gender); ?></p>
                                <p><strong>Age:</strong> <?php echo htmlentities($result->Age); ?></p>
                                <p><strong>Occupation:</strong> <?php echo htmlentities($result->Occupation); ?></p>
                                <p><strong>Street:</strong> <?php echo htmlentities($result->Street); ?></p>
                                <p><strong>City:</strong> <?php echo htmlentities($result->City); ?></p>
                                <p><strong>Preferred Donation Centers:</strong> <?php echo htmlentities($result->PreferredDonationCenters); ?></p>
                                <p><strong>Remarks:</strong> <?php echo htmlentities($result->Remarks); ?></p>
                                <p><strong>Last Date of Donation:</strong> <?php echo htmlentities($result->Last_Date_Of_Donation); ?></p>
                                <p><strong>Blood Group:</strong> <?php echo htmlentities($result->Blood_Group); ?></p>
                                <p><strong>Amount of Blood Donated (in last 3 months):</strong> <?php echo htmlentities($result->Amount_Of_Blood_Donated); ?></p>
                                <p><strong>Donation Frequency:</strong> <?php echo htmlentities($result->Donation_Frequency); ?></p>
                            </div>
                            <a class="btn btn-primary mt-3" href="update-donor.php?id=<?php echo $loggedInUserID; ?>">Update Profile</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- //donor profile -->
</div> <!-- Close the #home div -->

<!-- Js files -->
<!-- JavaScript -->
<script src="../js/jquery-2.2.3.min.js"></script>
<!-- Default-JavaScript-File -->

<!-- fixed navigation -->
<script src="../js/fixed-nav.js"></script>
<!-- //fixed navigation -->

<script src="../js/bootstrap.js"></script>
<!-- Necessary-JavaScript-File-For-Bootstrap -->

</body>

</html>

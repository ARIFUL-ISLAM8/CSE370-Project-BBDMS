<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(!isset($_SESSION['alogin']) || empty($_SESSION['alogin'])) {	
    header('location:../index.php');
} else {
    $loggedInUserID = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
    // Check if the logged-in user ID is valid
    if ($loggedInUserID != 0) {
        // Prepare SQL query to fetch hospital ID based on the logged-in user ID
        $sql = "SELECT Hospital_Id FROM HospitalStaff WHERE User_ID = :user_id";

        // Prepare and execute the query
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':user_id', $loggedInUserID, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch hospital ID from the result
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $hospitalID = ($row !== false) ? intval($row['Hospital_Id']) : 0;
    } else {
        // Set hospital ID to 0 if user ID is not provided or invalid
        $hospitalID = 0;
    }

    // Query to select hospital staff and related hospital information for the logged-in user
    $sql = "SELECT u.User_ID, 
                u.Name AS StaffName, 
                hs.Position, 
                hs.Hospital_Id, 
                h.Name AS HospitalName, 
                h.Street, 
                h.City, 
                hl.Zip_Code, 
                GROUP_CONCAT(DISTINCT hc.Contact_No SEPARATOR ', ') AS Contact_Nos
            FROM 
                User u 
            INNER JOIN 
                HospitalStaff hs ON u.User_ID = hs.User_ID
            INNER JOIN 
                Hospital h ON hs.Hospital_Id = h.Hospital_Id
            INNER JOIN 
                HospitalLocation hl ON h.City = hl.City
            LEFT JOIN 
                HospitalContact hc ON h.Hospital_Id = hc.Hospital_Id
            WHERE 
                u.Role = 'Hospital Staff' AND
                u.User_ID = :user_id
            GROUP BY
                hs.Hospital_Id"; 
    try {
        $query = $dbh->prepare($sql);
        $query->bindParam(':user_id', $loggedInUserID, PDO::PARAM_INT);
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
    <title>Hospital Staff Management System | Hospital Staff Profile</title>
    <!-- Include meta tags, stylesheets, and scripts here -->
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
                    <a class="navbar-brand font-weight-bold font-italic" href="HospitalPanel.php?user_id=<?php echo $loggedInUserID;?>">
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
                                <a href="HospitalPanel.php?user_id=<?php echo $loggedInUserID;?>">Home</a>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
                    <a href="patient-list.php?hospital_id=<?php echo $loggedInUserID; ?>&hospital_id=<?php echo $hospitalID; ?>" class="login-button ml-lg-3 mt-lg-0 mt-4 mb-lg-0 mb-3">
                        <i class="fas fa-user-plus mr-2"></i>patient List
                    </a>
                    <a href="bloodbank.php?user_id=<?php echo $loggedInUserID; ?>&hospital_id=<?php echo $hospitalID; ?>" class="login-button ml-lg-3 mt-lg-0 mt-4 mb-lg-0 mb-3">
                        <i class="fas fa-user-plus mr-2"></i>Blood Bank
                    </a>
                    <a href="../Patient/patientaccount.php" class="login-button ml-lg-3 mt-lg-0 mt-4 mb-lg-0 mb-3">
                        <i class="fas fa-user-plus mr-2"></i>Create patient account
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


    <!-- hospital staff profile -->
    <div class="agileits-contact py-5">
        <div class="py-xl-5 py-lg-3">
            <div class="w3ls-titles text-center mb-5">
                <h3 class="title">Hospital Staff</h3>
                <span>
                    <i class="fas fa-user"></i>
                </span>
                <p class="mt-2">Welcome to the Hospital Staff profile. Update your information here.</p>
            </div>
            <div class="container">
                <div class="row">
                    <?php foreach ($results as $result) : ?>
                        <!-- Left column for profile pic and name -->
                        <div class="col-md-4">
                            <div class="text-center">
                                <!-- Profile picture (you can replace the source with your actual image path) -->
                                <img src="../images/profile2.jpg" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 150px;">
                                <!-- Name with User ID -->
                                <h3><?php echo htmlentities($result->StaffName); ?> (User ID: <?php echo htmlentities($loggedInUserID); ?>)</h3>
                            </div>
                        </div>
                        <div class="price-bottom p-4 border rounded mb-3">
                            <div class="profile-info">
                                <!-- Other details -->
                                <p><strong>Position:</strong> <?php echo htmlentities($result->Position); ?></p>
                                <p><strong>Hospital ID:</strong> <?php echo htmlentities($result->Hospital_Id); ?></p>
                                <p><strong>Hospital Name:</strong> <?php echo htmlentities($result->HospitalName); ?></p>
                                <p><strong>Street:</strong> <?php echo htmlentities($result->Street); ?></p>
                                <p><strong>City:</strong> <?php echo htmlentities($result->City); ?></p>
                                <p><strong>Zip Code:</strong> <?php echo htmlentities($result->Zip_Code); ?></p>
                                <p><strong>Contact No:</strong> <?php echo htmlentities($result->Contact_Nos); ?></p>
                                <p><strong style="color: black;">Stock:</strong></p>
                                <!-- Blood stock table -->
                                <div class="stock-table-container" style="border-radius: 10px; overflow: hidden; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                                    <table class="stock-table" style="width: 100%; border-collapse: collapse;">
                                        <thead>
                                            <tr>
                                                <th style="padding: 10px; border-bottom: 1px solid #ddd; background-color: #f2f2f2;">Blood Type</th>
                                                <th style="padding: 10px; border-bottom: 1px solid #ddd; background-color: #f2f2f2;">Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            // Query to fetch stock data for the current hospital
                                            $stock_sql = "SELECT blood_type, quantity FROM stock WHERE Hospital_Id = :hospital_id";
                                            $stock_query = $dbh->prepare($stock_sql);
                                            $stock_query->bindParam(':hospital_id', $result->Hospital_Id, PDO::PARAM_INT);
                                            $stock_query->execute();

                                            // Check if there are any results
                                            if ($stock_query->rowCount() > 0) {
                                                // Fetch all results as objects
                                                $stock_results = $stock_query->fetchAll(PDO::FETCH_OBJ);

                                                // Iterate over the results and display blood type and quantity
                                                foreach ($stock_results as $stock_result) {
                                                    echo "<tr>";
                                                    echo "<td style='padding: 10px; border-bottom: 1px solid #ddd;'>" . htmlentities($stock_result->blood_type) . "</td>";
                                                    echo "<td style='padding: 10px; border-bottom: 1px solid #ddd;'>" . htmlentities($stock_result->quantity) . "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                // No stock data found for the current hospital
                                                echo "<tr><td colspan='2' style='padding: 10px; border-bottom: 1px solid #ddd;'>No stock data available</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Update button -->
                                <a href="update-blood.php?hospital_id=<?php echo htmlentities($result->Hospital_Id); ?>&user_id=<?php echo htmlentities($loggedInUserID); ?>" class="btn btn-primary mt-3">Update</a>
                            </div>
                        </div>
                    <?php endforeach; ?> <!-- End of PHP loop -->
                </div>
            </div>
        </div>
    </div>
    <!-- //hospital staff profile -->
</div>

    <!-- Js files -->
    <!-- Include scripts here -->
</body>
</html>

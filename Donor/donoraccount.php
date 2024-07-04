<?php
session_start();
error_reporting(0);
include('../includes/config.php');

if(isset($_POST['submit'])) {
    try {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Hash password
    $role = 'Donor';
    $perId = 3;
    
    // Insert user into User table
    $sql = "INSERT INTO LogIn (Username, Password) VALUES (:username, :password)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $logId = $dbh->lastInsertId(); // Get last inserted LogID
    
    // Insert user into User table
    $sql = "INSERT INTO User (Name, Role, LogID, Per_ID) VALUES (:name, :role, :logId, :perId)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':role', $role, PDO::PARAM_STR);
    $query->bindParam(':logId', $logId, PDO::PARAM_INT);
    $query->bindParam(':perId', $perId, PDO::PARAM_INT);
    $query->execute();
    $userId = $dbh->lastInsertId(); // Get last inserted UserID
    
    // Insert the city and ZIP code into the DonorCity table
    $city = $_POST['city'];
    $zip_code = $_POST['zip_code'];
    
    // Check if the city and zip code combination already exists
    $sql = "SELECT COUNT(*) AS count FROM DonorCity WHERE City = :city AND Zip_Code = :zip_code";
    $query = $dbh->prepare($sql);
    $query->bindParam(':city', $city, PDO::PARAM_STR);
    $query->bindParam(':zip_code', $zip_code, PDO::PARAM_STR);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    
    if ($row['count'] == 0) {
        // If the combination doesn't exist, insert it into the DonorCity table
        $sql = "INSERT INTO DonorCity (City, Zip_Code) VALUES (:city, :zip_code)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':city', $city, PDO::PARAM_STR);
        $query->bindParam(':zip_code', $zip_code, PDO::PARAM_STR);
        $query->execute();
    }    

    // Now, you can insert the donor details into the Donor table
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $occupation = $_POST['occupation'];
    $street = $_POST['street'];
    $bloodGroup = $_POST['blood_group'];

    $sql = "INSERT INTO Donor (User_ID, Gender, Age, Occupation, Street, City, Blood_Group) 
            VALUES (:userId, :gender, :age, :occupation, :street, :city, :bloodGroup)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':userId', $userId, PDO::PARAM_INT);
    $query->bindParam(':gender', $gender, PDO::PARAM_STR);
    $query->bindParam(':age', $age, PDO::PARAM_INT);
    $query->bindParam(':occupation', $occupation, PDO::PARAM_STR);
    $query->bindParam(':street', $street, PDO::PARAM_STR);
    $query->bindParam(':city', $city, PDO::PARAM_STR); 
    $query->bindParam(':bloodGroup', $bloodGroup, PDO::PARAM_STR);
    $query->execute();
    
    $donationFrequency = $_POST['donation_frequency'];

    $sql = "INSERT INTO Donation_Log_2 (User_ID, Donation_Frequency) 
            VALUES (:userId, :donationFrequency)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':userId', $userId, PDO::PARAM_INT);
    $query->bindParam(':donationFrequency', $donationFrequency, PDO::PARAM_STR);
    $query->execute();

    // Insert into Donation_Log_1 table
    $lastDonationDate = $_POST['last_donation_date'];
    $bloodDonated = $_POST['blood_donated'];

    $sql = "INSERT INTO Donation_Log_1 (User_ID, Last_Date_Of_Donation, Amount_Of_Blood_Donated) 
            VALUES (:userId, :lastDonationDate, :bloodDonated)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':userId', $userId, PDO::PARAM_INT);
    $query->bindParam(':lastDonationDate', $lastDonationDate, PDO::PARAM_STR);
    $query->bindParam(':bloodDonated', $bloodDonated, PDO::PARAM_STR);
    $query->execute();

    // Insert into Remark table
    $remarks = $_POST['remarks'];

    $sql = "INSERT INTO Remark (User_ID, Remarks) VALUES ";
    $params = array();
    foreach ($remarks as $remark) {
        $sql .= "(:userId, :remark),";
        $params[] = array(':userId' => $userId, ':remark' => $remark);
    }
    $sql = rtrim($sql, ',');
    $query = $dbh->prepare($sql);
    foreach ($params as $param) {
        $query->execute($param);
    }

    // Insert into Preference table
    $preferredDonationCenters = $_POST['donation_center'];

    $sql = "INSERT INTO Preference (User_ID, Preferred_Donation_Center) VALUES ";
    $params = array();
    foreach ($preferredDonationCenters as $center) {
        $sql .= "(:userId, :center),";
        $params[] = array(':userId' => $userId, ':center' => $center);
    }
    $sql = rtrim($sql, ',');
    $query = $dbh->prepare($sql);
    foreach ($params as $param) {
        $query->execute($param);
    }

    // Insert into DonorContact table
    $contacts = $_POST['contact'];

    $sql = "INSERT INTO DonorContact (User_ID, Contact) VALUES ";
    $params = array();
    foreach ($contacts as $contact) {
        $sql .= "(:userId, :contact),";
        $params[] = array(':userId' => $userId, ':contact' => $contact);
    }
    $sql = rtrim($sql, ',');
    $query = $dbh->prepare($sql);
    foreach ($params as $param) {
        $query->execute($param);
    }

    $lastInsertId = $dbh->lastInsertId();
    if($lastInsertId)
    {
    echo "<script>alert('You have signup  Scuccessfully');</script>";
    }
    else
    {
    echo "<script>alert('Something went wrong.Please try again');</script>";
    }
    // Redirect to login page after successful registration
    header("Location: ../index.php");
    exit();
    }
 catch (PDOException $e) {
        // Handle database errors
        echo "Database Error: " . $e->getMessage();
    }    
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
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

<body style="background-color: #eee;">
<?php error_reporting(0);
session_start(); ?>
<!-- header -->
    <div id="home">
        <!-- navigation -->
        <div class="main-top py-1">
            <nav class="navbar navbar-expand-lg navbar-light fixed-navi">
                <div class="container">
                    <!-- logo -->
                    <h1>
                        <a class="navbar-brand font-weight-bold font-italic" href="../index.php">
                            BBDMS
                            <i class="fas fa-syringe"></i>
                        </a>
                    </h1>
                    <!-- //logo -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </nav>
        </div>
    </div> 

    <!-- Sign-up Section -->
    <section class="vh-100">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <!-- Sign-up Card -->
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-2">
                            <div class="row justify-content-center">
                                <p class="text-center h1 fw-bold mb-4 mx-1 mx-md-3 mt-3">Sign up</p>
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                    <!-- Sign-up Form -->
                                    <form action="#" method="post"  name="signup" onsubmit="return checkpass();">
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example1c"><i class="bi bi-person-circle"></i> Your Name</label>
                                                <input type="text" id="form3Example1c" class="form-control form-control-lg py-3" name="name" autocomplete="off" placeholder="Enter your name" style="border-radius:25px ;" />

                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example3c"><i class="bi bi-envelope-at-fill"></i> Username</label>
                                                <input type="username" id="form3Example3c" class="form-control form-control-lg py-3" name="username" autocomplete="off" placeholder="Enter your username" style="border-radius:25px ;" />

                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example4c"><i class="fas fa-lock fa-lg fa-fw"></i> Password</label>
                                                <input type="password" id="form3Example4c" class="form-control form-control-lg py-3" name="password" autocomplete="off" placeholder="Enter your password" style="border-radius:25px ;" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example5c"><i class="fas fa-venus-mars fa-lg fa-fw"></i> Gender</label>
                                                <select class="form-select form-select-lg" id="form3Example5c" name="gender" style="border-radius:25px ;">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example6c"><i class="bi bi-calendar3"></i> Age</label>
                                                <input type="number" id="form3Example6c" class="form-control form-control-lg py-3" name="age" autocomplete="off" placeholder="Enter your age" style="border-radius:25px ;" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example7c"><i class="bi bi-briefcase-fill"></i> Occupation</label>
                                                <input type="text" id="form3Example7c" class="form-control form-control-lg py-3" name="occupation" autocomplete="off" placeholder="Enter your occupation" style="border-radius:25px ;" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example8c"><i class="bi bi-house-door-fill"></i> Street Address</label>
                                                <input type="text" id="form3Example8c" class="form-control form-control-lg py-3" name="street" autocomplete="off" placeholder="Enter your street address" style="border-radius:25px ;" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example9c"><i class="bi bi-building"></i> City</label>
                                                <input type="text" id="form3Example9c" class="form-control form-control-lg py-3" name="city" autocomplete="off" placeholder="Enter your city" style="border-radius:25px ;" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                              <label class="form-label" for="form3Example11c"><i class="bi bi-geo-alt-fill"></i> ZIP Code</label>
                                              <input type="text" id="form3Example11c" class="form-control form-control-lg py-3" name="zip_code" autocomplete="off" placeholder="Enter ZIP code" style="border-radius:25px ;" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example10c"><i class="fas fa-tint fa-lg fa-fw"></i> Blood Group</label>
                                                <select class="form-select form-select-lg" id="form3Example10c" name="blood_group" style="border-radius:25px ;">
                                                    <option value="A+">A+</option>
                                                    <option value="A-">A-</option>
                                                    <option value="B+">B+</option>
                                                    <option value="B-">B-</option>
                                                    <option value="AB+">AB+</option>
                                                    <option value="AB-">AB-</option>
                                                    <option value="O+">O+</option>
                                                    <option value="O-">O-</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Contact (Multiple is accepted) -->
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="contact"><i class="bi bi-telephone-fill"></i> Contact</label>
                                                <input type="text" id="contact" class="form-control form-control-lg py-3" name="contact[]" autocomplete="off" placeholder="Enter contact number" style="border-radius:25px ;" />
                                            </div>
                                        </div>

                                       <!-- Preferred Donation Center -->
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="donation_center"><i class="fas fa-hospital fa-lg fa-fw"></i> Preferred Donation Center</label>
                                                <input type="text" id="donation_center" class="form-control form-control-lg py-3" name="donation_center[]" autocomplete="off" placeholder="Enter preferred donation center" style="border-radius: 25px;">
                                            </div>
                                        </div>

                                        <!-- Remarks -->
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="remarks"><i class="bi bi-chat-left-dots-fill"></i> Remarks</label>
                                                <input type="text" id="remarks" class="form-control form-control-lg py-3" name="remarks[]" autocomplete="off" placeholder="Enter remarks" style="border-radius: 25px;">
                                            </div>
                                        </div>

                                        <!-- Last Date of Donation -->
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="last_donation_date"><i class="fas fa-calendar-alt fa-fw"></i> Last Date of Donation</label>
                                                <input type="date" id="last_donation_date" class="form-control form-control-lg py-3" name="last_donation_date" style="border-radius:25px ;" />
                                            </div>
                                        </div>


                                        <!-- Amount of Blood Donated in Last 3 Months -->
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="blood_donated"><i class="fas fa-tint fa-lg fa-fw"></i> Amount of Blood Donated (Last 3 Months)</label>
                                                <input type="number" id="blood_donated" class="form-control form-control-lg py-3" name="blood_donated" autocomplete="off" placeholder="Enter amount of blood donated" style="border-radius:25px ;" />
                                            </div>
                                        </div>

                                        <!-- Donation Frequency -->
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="donation_frequency"><i class="bi bi-clock"></i> Donation Frequency</label>
                                                <input type="text" id="donation_frequency" class="form-control form-control-lg py-3" name="donation_frequency" autocomplete="off" placeholder="Enter donation frequency" style="border-radius:25px ;" />
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary submit mb-4" name="submit">Register</button>
                                    </form>
                                    <p align="center">I already have an account <a href="index.php" class="text-warning" style="font-weight:600; text-decoration:none;">Login</a></p>
                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <img src="../images/signup.png" class="img-fluid" alt="Sample image" height="300px" width="500px">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>

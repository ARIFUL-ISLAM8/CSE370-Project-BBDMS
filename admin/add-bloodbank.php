<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{   
    header('location:../index.php');
}
else{
    // Code for adding blood bank   
    if(isset($_POST['submit'])) {
        $name=$_POST['name'];
        $street=$_POST['street'];
        $city=$_POST['city'];
		$zip=$_POST['zip'];
        
		// Check if the city and zip already exist in BloodBankLocation table
		$sql_check = "SELECT * FROM BloodBankLocation WHERE City = :city AND Zip = :zip";
		$query_check = $dbh->prepare($sql_check);
		$query_check->bindParam(':city', $city, PDO::PARAM_STR);
		$query_check->bindParam(':zip', $zip, PDO::PARAM_STR);
		$query_check->execute();
		$count = $query_check->rowCount();
		
		if($count > 0) {
			$msg = "City and zip already exist.";
			// Insert data into BloodBank table
			$sql_bloodbank = "INSERT INTO BloodBank(Name, Street, City) VALUES(:name, :street, :city)";
			$query_bloodbank = $dbh->prepare($sql_bloodbank);
			$query_bloodbank->bindParam(':name', $name, PDO::PARAM_STR);
			$query_bloodbank->bindParam(':street', $street, PDO::PARAM_STR);
			$query_bloodbank->bindParam(':city', $city, PDO::PARAM_STR);
			$query_bloodbank->execute();
			$lastInsertId = $dbh->lastInsertId();   
			$msg = "Blood Bank added successfully";

		} else {
			// Insert data into BloodBankLocation table if city and zip do not exist
			$sql_location = "INSERT INTO BloodBankLocation(City, Zip) VALUES(:city, :zip)";
			$query_location = $dbh->prepare($sql_location);
			$query_location->bindParam(':city', $city, PDO::PARAM_STR);
			$query_location->bindParam(':zip', $zip, PDO::PARAM_STR);
			$query_location->execute();
			$lastInsertId = $dbh->lastInsertId();   
		}
    }
    else {
        $error="Something went wrong. Please try again";
    }
}

?>

<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    
    <title>BBDMS | Add Blood Bank</title>

    <!-- Font awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Bootstrap Datatables -->
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <!-- Bootstrap social button library -->
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <!-- Bootstrap select -->
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <!-- Bootstrap file input -->
    <link rel="stylesheet" href="css/fileinput.min.css">
    <!-- Awesome Bootstrap checkbox -->
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <!-- Admin Stye -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap{
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
    </style>
</head>
<body>
    <?php include('includes/header.php');?>

    <div class="ts-main-content">
        <?php include('includes/leftbar.php');?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Add Blood Bank</h2>

                        <!-- Zero Configuration Table -->
                        <div class="panel panel-default">
                            <div class="panel-heading">Add Blood Bank</div>
                            <div class="panel-body">
                                <form method="post" name="addbloodbank" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="name" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Street</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="street" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">City</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="city" required>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label class="col-sm-4 control-label">Zip Code</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="zip" required>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>
</body>
</html>

<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{   
    header('location:../index.php');
}
else{
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
    <title>BBDMS | Donor List</title>
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
                <div class="col-md-12">
                    <!-- Zero Configuration Table -->
                    <div class="panel panel-default">
                        <div class="panel-heading">Blood Info</div>
                        <div class="panel-body">
                            <table border="1" class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th>Transaction ID</th>
                                        <th>Donor ID</th>
                                        <th>Name of Donor</th>
                                        <th>Contact Number of Donor</th>
                                        <th>Cost</th>
                                        <th>Blood Group</th>
                                        <th>Patient ID</th>
                                        <th>Name of Requirer</th>
                                        <th>Mobile Number of Requirer</th>
                                        <th>Amount</th>
                                        <th>Time Of Need</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT 
									user1.name AS user_name,
									payment1.Transaction_ID,
									payment1.DuserID,
									GROUP_CONCAT(DISTINCT donorcontact.Contact) AS donor_contacts,
									payment1.Cost,
									Donor.Blood_Group,
									payment1.PuserID,
									GROUP_CONCAT(DISTINCT patientcontact.Contact) AS patient_contacts,
									payment1.Amount,
									secondlookingfor.time_of_need,
									payment1.Status
								FROM 
									payment AS payment1
								LEFT JOIN 
									user AS user1 ON payment1.PuserID = user1.User_ID
								LEFT JOIN 
									user AS user2 ON payment1.DuserID = user2.User_ID
								LEFT JOIN 
									secondlookingfor ON payment1.PuserID = secondlookingfor.User_ID
								LEFT JOIN 
									Donor ON Donor.User_ID = payment1.DuserID
								LEFT JOIN 
									Patient ON Patient.User_ID = payment1.PuserID
								LEFT JOIN 
									donorcontact ON donorcontact.User_ID = payment1.DuserID
								LEFT JOIN 
									patientcontact ON patientcontact.User_ID = payment1.PuserID";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($row->Transaction_ID); ?></td>
                                        <td><?php echo htmlentities($row->DuserID); ?></td>
                                        <td><?php echo htmlentities($row->user_name); ?></td>
                                        <td><?php echo htmlentities($row->donor_contacts); ?></td>
                                        <td><?php echo htmlentities($row->Cost); ?></td>
                                        <td><?php echo htmlentities($row->Blood_Group); ?></td>
                                        <td><?php echo htmlentities($row->PuserID); ?></td>
                                        <td><?php echo htmlentities($row->user_name); ?></td>
										<td><?php echo htmlentities($row->patient_contacts); ?></td>
                                        <td><?php echo htmlentities($row->Amount); ?></td>
                                        <td><?php echo htmlentities($row->time_of_need); ?></td>
                                        <td><?php echo htmlentities($row->Status); ?></td>
                                    </tr>
                                    <?php
                                            $cnt = $cnt + 1;
                                        }
                                    } else {
                                    ?>
                                    <tr>
                                        <td colspan="12" style="color:red;">No Record found</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
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
<?php } ?>

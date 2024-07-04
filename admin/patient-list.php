<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../index.php');
}
else{
//Code for Deletion
if(isset($_REQUEST['del'])) {
    $user_id = intval($_GET['del']);

    try {
        // Begin transaction
        $dbh->beginTransaction();

        // Delete records from Patient table
        $sql1 = "DELETE FROM Patient WHERE User_ID=:user_id";
        $query1 = $dbh->prepare($sql1);
        $query1->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query1->execute();

        // Delete records from PatientContact table
        $sql2 = "DELETE FROM PatientContact WHERE User_ID=:user_id";
        $query2 = $dbh->prepare($sql2);
        $query2->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query2->execute();

        // Delete records from EmergencyContact table and related ContactName records
        $sql3 = "SELECT Contact_ID FROM EmergencyContact WHERE User_ID=:user_id";
        $query3 = $dbh->prepare($sql3);
        $query3->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query3->execute();
        $contact_ids = $query3->fetchAll(PDO::FETCH_COLUMN);

        // Delete records from ContactName table based on Contact_ID from EmergencyContact
        $sql4 = "DELETE FROM ContactName WHERE Contact_ID IN (" . implode(",", $contact_ids) . ")";
        $query4 = $dbh->prepare($sql4);
        $query4->execute();

        // Delete records from EmergencyContact table
        $sql5 = "DELETE FROM EmergencyContact WHERE User_ID=:user_id";
        $query5 = $dbh->prepare($sql5);
        $query5->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query5->execute();

        // Delete records from Issue table
        $sql6 = "DELETE FROM Issue WHERE User_ID=:user_id";
        $query6 = $dbh->prepare($sql6);
        $query6->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query6->execute();

        // Commit transaction
        $dbh->commit();

        $msg = "Records related to User ID $user_id deleted successfully";
    } catch (PDOException $e) {
        // Rollback transaction on error
        $dbh->rollBack();
        $error = "Error deleting records: " . $e->getMessage();
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
	
	<title>BBDMS | Patient List  </title>

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

						<h2 class="page-title">Patients List</h2>

						<!-- Zero Configuration Table -->
						<div class="panel panel-default">
							<div class="panel-heading">Patients Info</div>
							<div class="panel-body">
							<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
								else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>User ID</th>
											<th>Patient Name</th>
											<th>Age</th>
											<th>Contact_List</th>									
											<th>Emergency Contact</th>
											<th>Relationship</th>
											<th>Hospital Name</th>
											<th>Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>User ID</th>
											<th>Patient Name</th>
											<th>Age</th>
											<th>Contact_List</th>									
											<th>Emergency Contact</th>
											<th>Relationship</th>
											<th>Hospital Name</th>
											<th>Action</th>
										</tr>
									</tfoot>
									<tbody>
										<?php 
										$sql = "SELECT 
											Patient.User_ID,
											Patient.Age,
											Hospital.Name AS Hospital_Name,
											Issue.Issues,
											EmergencyContact.Relationship,
											GROUP_CONCAT(DISTINCT PatientContact.Contact) AS Contact_List,
											ContactName.Name AS Contact_Name,
											User.Name AS Patient_Name
										FROM 
											Patient
										LEFT JOIN 
											Hospital ON Patient.Hospital_Id = Hospital.Hospital_Id
										LEFT JOIN 
											Issue ON Patient.User_ID = Issue.User_ID
										LEFT JOIN 
											EmergencyContact ON Patient.User_ID = EmergencyContact.User_ID
										LEFT JOIN 
											PatientContact ON Patient.User_ID = PatientContact.User_ID
										LEFT JOIN 
											ContactName ON EmergencyContact.Contact_ID = ContactName.Contact_ID
										LEFT JOIN
											User ON Patient.User_ID = User.User_ID
										GROUP BY 
											Patient.User_ID;";									
										$query = $dbh->prepare($sql);
										$query->execute();
										$results = $query->fetchAll(PDO::FETCH_ASSOC);
										$count = 1;
										if($query->rowCount() > 0) {
											foreach($results as $result) {
										?>
											<tr>
												<td><?php echo htmlentities($result['User_ID']);?></td>
												<td><?php echo htmlentities($result['Patient_Name']);?></td>
												<td><?php echo htmlentities($result['Age']);?></td>
												<td><?php echo htmlentities($result['Contact_List']);?></td>
												<td><?php echo htmlentities($result['Contact_Name']);?></td>
												<td><?php echo htmlentities($result['Relationship']);?></td>
												<td><?php echo htmlentities($result['Hospital_Name']);?></td>
												<td>
													<?php?>
													<a href="donor-list.php?del=<?php echo htmlentities($result['User_ID']);?>" onclick="return confirm('Do you really want to delete this record')" class="btn btn-danger" style="margin-top:1%;"> Delete</a>
												</td>
											</tr>
										<?php 
												$count++;
											}
										} 
										?>
									</tbody>									
								</table>						
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
<?php } ?>

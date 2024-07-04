<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../index.php');
}
else{
if(isset($_REQUEST['hidden']))
	{
		$user_id = intval($_GET['hidden']);
		$donation_frequency = "deactivate"; // Set the desired value for Donation_Frequency
		$sql = "UPDATE Donation_Log_2 SET Donation_Frequency=:donation_frequency WHERE User_ID=:user_id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':donation_frequency', $donation_frequency, PDO::PARAM_STR);
		$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$query->execute();		
$msg="Donor details hidden Successfully";
}


if(isset($_REQUEST['public']))
	{
$aeid=intval($_GET['public']);
$user_id = intval($_GET['aeid']); // Assuming 'aeid' is the user id obtained from the URL parameter
$donation_frequency = "regular"; // Set the desired value for Donation_Frequency
$sql = "UPDATE Donation_Log_2 SET Donation_Frequency=:donation_frequency WHERE User_ID=:user_id";
$query = $dbh->prepare($sql);
$query->bindParam(':donation_frequency', $donation_frequency, PDO::PARAM_STR);
$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$query->execute();


$msg="Donor details public";
}
//Code for Deletion
if(isset($_REQUEST['del'])) {
    $user_id = intval($_GET['del']);

    // Delete records from Donor table
    $sql1 = "DELETE FROM Donor WHERE User_ID=:user_id";
    $query1 = $dbh->prepare($sql1);
    $query1->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query1->execute();

    // Delete records from DonorContact table
    $sql2 = "DELETE FROM DonorContact WHERE User_ID=:user_id";
    $query2 = $dbh->prepare($sql2);
    $query2->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query2->execute();

    // Delete records from Preference table
    $sql3 = "DELETE FROM Preference WHERE User_ID=:user_id";
    $query3 = $dbh->prepare($sql3);
    $query3->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query3->execute();

    // Delete records from Remark table
    $sql4 = "DELETE FROM Remark WHERE User_ID=:user_id";
    $query4 = $dbh->prepare($sql4);
    $query4->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query4->execute();

    // Delete records from Donation_Log_1 table
    $sql5 = "DELETE FROM Donation_Log_1 WHERE User_ID=:user_id";
    $query5 = $dbh->prepare($sql5);
    $query5->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query5->execute();

    // Delete records from Donation_Log_2 table
    $sql6 = "DELETE FROM Donation_Log_2 WHERE User_ID=:user_id";
    $query6 = $dbh->prepare($sql6);
    $query6->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query6->execute();

	// Delete records from User table
	$sql6 = "DELETE FROM User WHERE User_ID=:user_id";
	$query6 = $dbh->prepare($sql6);
	$query6->bindParam(':user_id', $user_id, PDO::PARAM_INT);
	$query6->execute();

    $msg = "Records related to User ID $user_id deleted successfully";
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
	
	<title>BBDMS | Donor List  </title>

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

						<h2 class="page-title">Donors List</h2>

						<!-- Zero Configuration Table -->
						<div class="panel panel-default">
							<div class="panel-heading">Donors Info</div>
								<a href="download-records.php" style="font-size:16px;" class="btn btn-info">Download Donor List</a>
							<div class="panel-body">
							<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
								else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Name</th>
											<th>Mobile No</th>
											<th>Age</th>
											<th>Gender</th>
											<th>Blood Group</th>
											<th>Address</th>
											<th>Donation Frequency</th>
											<th>Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>#</th>
											<th>Name</th>
											<th>Mobile No</th>
											<th>Age</th>
											<th>Gender</th>
											<th>Blood Group</th>
											<th>Address</th>
											<th>Donation Frequency</th>
											<th>Action</th>
										</tr>
									</tfoot>
									<tbody>
										<?php 
										$sql = "SELECT d.*, 
											MAX(dc.Contact) AS Contact, u.Name, 
											MAX(p.Preferred_Donation_Center) AS Preferred_Donation_Center, 
											MAX(r.Remarks) AS Remarks, 
											dl1.Last_Date_Of_Donation AS Last_Date_Of_Donation, 
											dl2.Donation_Frequency AS Donation_Frequency 
											FROM Donor d 
											LEFT JOIN DonorContact dc ON d.User_ID = dc.User_ID 
											LEFT JOIN Preference p ON d.User_ID = p.User_ID 
											LEFT JOIN Remark r ON d.User_ID = r.User_ID 
											LEFT JOIN Donation_Log_1 dl1 ON d.User_ID = dl1.User_ID 
											LEFT JOIN Donation_Log_2 dl2 ON d.User_ID = dl2.User_ID 
											LEFT JOIN User u ON d.User_ID = u.User_ID 
											GROUP BY d.User_ID;";									
										$query = $dbh->prepare($sql);
										$query->execute();
										$results = $query->fetchAll(PDO::FETCH_ASSOC);
										$count = 1;
										if($query->rowCount() > 0) {
											foreach($results as $result) {
										?>
											<tr>
												<td><?php echo $count;?></td>
												<td><?php echo htmlentities($result['Name']);?></td>
												<td><?php echo htmlentities($result['Contact']);?></td>
												<td><?php echo htmlentities($result['Age']);?></td>
												<td><?php echo htmlentities($result['Gender']);?></td>
												<td><?php echo htmlentities($result['Blood_Group']);?></td>
												<td><?php echo htmlentities($result['Street'].", ".$result['City']);?></td>
												<td><?php echo htmlentities($result['Donation_Frequency']);?></td>
												<td>
													<?php if($result['Donation_Frequency'] == 'Regular'): ?>
														<a href="donor-list.php?hidden=<?php echo htmlentities($result['User_ID']);?>" onclick="return confirm('Do you really want to hide this detail')" class="btn btn-primary"> Make it Hidden</a> 
													<?php else: ?>
														<a href="donor-list.php?public=<?php echo htmlentities($result['User_ID']);?>" onclick="return confirm('Do you really want to make this detail public')" class="btn btn-primary"> Make it Public</a>
													<?php endif; ?>
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

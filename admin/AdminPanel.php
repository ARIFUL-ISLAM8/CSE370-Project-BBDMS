<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(!isset($_SESSION['alogin']) || empty($_SESSION['alogin'])) 
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
	
	<title>BBDMS | Admin Dashboard</title>

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
</head>

<body>
<?php include('includes/header.php');?>
	<div class="ts-main-content">
<?php include('includes/leftbar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<h2 class="page-title">Dashboard</h2>						
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-4">
										<div class="panel panel-default">
											<div class="panel-body bk-success text-light">
												<div class="stat-panel text-center">
													<?php 
													$sql = "SELECT COUNT(DISTINCT Blood_Group) AS blood_groups_count FROM Donor";
													$query = $dbh->prepare($sql);
													$query->execute();
													$result = $query->fetch(PDO::FETCH_ASSOC);
													$blood_groups_count = $result['blood_groups_count'];
													?>
													<div class="stat-panel-number h1 "><?php echo htmlentities($blood_groups_count);?></div>
													<div class="stat-panel-title text-uppercase">Registered Donor List</div>
												</div>
											</div>
											<a href="donor-list.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
										</div>
									</div>

									<div class="col-md-4">
										<div class="panel panel-default">
											<div class="panel-body bk-info text-light">
												<div class="stat-panel text-center">
													<?php 
														$sql = "SELECT COUNT(q.Query_ID) AS query_count
																FROM User u
																LEFT JOIN tblcontactusquery q ON u.User_ID = q.User_ID
																WHERE q.Message IS NOT NULL";
														$query = $dbh->prepare($sql);
														$query->execute();
														$result = $query->fetch(PDO::FETCH_ASSOC);
														$message_count = ($result['query_count'] == 0) ? '0' : htmlentities($result['query_count']);
													?>
													<div class="stat-panel-number h1 "><?php echo $message_count;?></div>
													<div class="stat-panel-title text-uppercase">Total Queries</div>
												</div>
											</div>
											<a href="manage-conactusquery.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
										</div>
									</div>

									<div class="col-md-4">
										<div class="panel panel-danger">
											<div class="panel-body bk-info text-light">
												<div class="stat-panel text-center">
													<?php 
														$sql = "SELECT COUNT(User_ID) AS request_count FROM SecondLookingFor";
														$query = $dbh->prepare($sql);
														$query->execute();
														$result = $query->fetch(PDO::FETCH_ASSOC);
														$total_requests = ($result['request_count'] == 0) ? '0' : htmlentities($result['request_count']);
													?>
													<div class="stat-panel-number h1 "><?php echo $total_requests;?></div>
													<div class="stat-panel-title text-uppercase">Total Blood Request Received</div>
												</div>
											</div>
											<a href="blood-requests.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
										</div>
									</div>

									<div class="col-md-4">
										<div class="panel panel-danger">
											<div class="panel-body bk-info text-light">
												<div class="stat-panel text-center">
													<?php 
													$sql6 ="SELECT Bank_ID  from BloodBank ";
													$query6 = $dbh -> prepare($sql6);;
													$query6->execute();
													$results6=$query6->fetchAll(PDO::FETCH_OBJ);
													$totalreuqests=$query6->rowCount();
													?>
													<div class="stat-panel-number h1 "><?php echo htmlentities($totalreuqests);?></div>
													<div class="stat-panel-title text-uppercase">Total Blood Bank</div>
												</div>
											</div>
											<a href="bloodbank-list.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
										</div>
									</div>

									<div class="col-md-4">
										<div class="panel panel-default">
											<div class="panel-body bk-primary text-light">
												<div class="stat-panel text-center">
													<?php 
													$sql ="SELECT Hospital_ID from Hospital";
													$query = $dbh -> prepare($sql);
													$query->execute();
													$results=$query->fetchAll(PDO::FETCH_OBJ);
													$bg=$query->rowCount();
													?>
													<div class="stat-panel-number h1 "><?php echo htmlentities($bg);?></div>
													<div class="stat-panel-title text-uppercase">List of Hospitals</div>
												</div>
											</div>
											<a href="hospital-list.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
										</div>
									</div>

									<div class="col-md-4">
										<div class="panel panel-default">
											<div class="panel-body bk-success text-light">
												<div class="stat-panel text-center">
													<?php 
													$sql = "SELECT COUNT(User_ID) AS hospitalstaff_count FROM HospitalStaff";
													$query = $dbh->prepare($sql);
													$query->execute();
													$result = $query->fetch(PDO::FETCH_ASSOC);
													$hospitalstaff_count = $result['hospitalstaff_count'];
													?>
													<div class="stat-panel-number h1 "><?php echo htmlentities($hospitalstaff_count);?></div>
													<div class="stat-panel-title text-uppercase">Total Hospital Staff</div>
												</div>
											</div>
											<a href="hospitalstaff-list.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
										</div>
									</div>

									<div class="col-md-4">
										<div class="panel panel-default">
											<div class="panel-body bk-primary text-light">
												<div class="stat-panel text-center">
													<?php 
													$sql ="SELECT User_ID from Patient";
													$query = $dbh -> prepare($sql);
													$query->execute();
													$results=$query->fetchAll(PDO::FETCH_OBJ);
													$bg=$query->rowCount();
													?>
													<div class="stat-panel-number h1 "><?php echo htmlentities($bg);?></div>
													<div class="stat-panel-title text-uppercase">Total Patient</div>
												</div>
											</div>
											<a href="patient-list.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
										</div>
									</div>

								</div>
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
	
	<script>
		
	window.onload = function(){
    
		// Line chart from swirlData for dashReport
		var ctx = document.getElementById("dashReport").getContext("2d");
		window.myLine = new Chart(ctx).Line(swirlData, {
			responsive: true,
			scaleShowVerticalLines: false,
			scaleBeginAtZero : true,
			multiTooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>",
		}); 
		
		// Pie Chart from doughutData
		var doctx = document.getElementById("chart-area3").getContext("2d");
		window.myDoughnut = new Chart(doctx).Pie(doughnutData, {responsive : true});

		// Dougnut Chart from doughnutData
		var doctx = document.getElementById("chart-area4").getContext("2d");
		window.myDoughnut = new Chart(doctx).Doughnut(doughnutData, {responsive : true});

	}
	</script>
</body>
</html>
<?php }?>
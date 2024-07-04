<?php
session_start();
error_reporting(0);
$UserId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

include('../includes/config.php');

if(isset($_POST['send'])) {
    $message = $_POST['message'];
    $currentDateTime = date('Y-m-d H:i:s'); // Get current date and time

    $sql = "INSERT INTO  tblcontactusquery(User_ID, Message, PostingDate) VALUES(:userID, :message, :postingDate)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':message', $message, PDO::PARAM_STR);
    $query->bindParam(':userID', $UserId, PDO::PARAM_INT);
    $query->bindParam(':postingDate', $currentDateTime, PDO::PARAM_STR); // Bind current date and time
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    
    if($lastInsertId) {
        echo '<script>alert("Query Sent. We will contact you shortly."); window.location.href = "DonorPanel.php?user_id=' . urlencode($UserId) . '";</script>';
        exit(); // Ensure that script execution stops after redirection
    } else {
        echo "<script>alert('Something went wrong. Please try again.');</script>";  
    }
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
	<title>Blood Bank Donar Management System | Contact Us </title>
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
	<!-- page details -->
	<!-- //page details -->

	<!-- contact -->
	<div class="agileits-contact py-5">
		<div class="py-xl-5 py-lg-3">
			<div class="w3ls-titles text-center mb-5">
				<h3 class="title">Contact Us</h3>
				<span>
					<i class="fas fa-user-md"></i>
				</span>
			</div>
			<div class="d-flex">
				<div class="col-lg-5 w3_agileits-contact-left">
				</div>
				<div class="col-lg-7 contact-right-w3l">
					<h5 class="title-w3 text-center mb-5">Get In Touch</h5>
					<form action="#" method="post">
						<div class="d-flex space-d-flex">					
						<div class="form-group">
							<textarea rows="10" cols="100" class="form-control" id="message" name="message" placeholder="Please enter your message" maxlength="999" style="resize:none"></textarea>
						</div>
						<div class="form-group">
							<input type="submit" value="Send Message" name="send">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- //contact -->
	<?php include('includes/footer.php');?>

	<!-- Js files -->
	<!-- JavaScript -->
	<script src="js/jquery-2.2.3.min.js"></script>
	<!-- Default-JavaScript-File -->

	<!-- banner slider -->
	<script src="js/responsiveslides.min.js"></script>
	<script>
		$(function () {
			$("#slider4").responsiveSlides({
				auto: true,
				pager: true,
				nav: true,
				speed: 1000,
				namespace: "callbacks",
				before: function () {
					$('.events').append("<li>before event fired.</li>");
				},
				after: function () {
					$('.events').append("<li>after event fired.</li>");
				}
			});
		});
	</script>
	<!-- //banner slider -->

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
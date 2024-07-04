<?php
error_reporting(0);
include('includes/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Blood Bank Donar Management System</title>
	

	<!--// Meta tag Keywords -->

	<!-- Custom-Files -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<!-- Bootstrap-Core-CSS -->
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
	<!-- Style-CSS -->
	<link rel="stylesheet" href="css/fontawesome-all.css">
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
                        <a class="navbar-brand font-weight-bold font-italic" href="index.php">
                            <span>BB</span>DMS
                            <i class="fas fa-syringe"></i>
                        </a>
                    </h1>
                    <!-- //logo -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-lg-auto">
                            <li class="nav-item active mt-lg-0 mt-3">
                                <a class="nav-link" href="index.php">Home
                                    <span class="sr-only">(current)</span>
                                </a>
                            </li>
                            <li class="nav-item mx-lg-4 my-lg-0 my-3">
                                <a class="nav-link" href="about.php">About Us</a>
                            </li>
                            <?php if (strlen($_SESSION['bbdmsdid']) == 0) {?>
							</ul>
							<!-- login -->
							<a href="login.php" class="login-button ml-lg-3 mt-lg-0 mt-4 mb-lg-0 mb-3">
								<i class="fas fa-sign-in-alt mr-2"></i>Login
							</a>
							<a href="Donor/donoraccount.php" class="login-button ml-lg-3 mt-lg-0 mt-4 mb-lg-0 mb-3">
								<i class="fas fa-user-plus mr-2"></i>Create Donor Account
							</a>
							<a href="Hospital/hospitalstaffaccount.php" class="login-button ml-lg-3 mt-lg-0 mt-4 mb-lg-0 mb-3">
								<i class="fas fa-user-plus mr-2"></i>Create Hospital Staff Account
							</a>
						<?php } ?>
                        <!-- //login -->
                    </div>
                </div>
            </nav>
        </div>

	<!-- banner -->
	<div class="slider">
		<div class="callbacks_container">
			<ul class="rslides callbacks" id="slider4">
				<li>
					<div class="banner-top1">
						<div class="banner-info_agile_w3ls">
							<div class="container">
								<h3>Blood bank services that you
									<span>can trust</span>
								</h3>
								
							</div>
						</div>
					</div>
				</li>
				<li>
					<div class="banner-top2">
						<div class="banner-info_agile_w3ls">
							<div class="container">
								<h3>
									<span>One Blood Donation Save three Lives every day</span>
								</h3>						
							</div>
						</div>
					</div>
				</li>
				<li>
					<div class="banner-top3">
						<div class="banner-info_agile_w3ls">
							<div class="container">		
							</div>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="clearfix"></div>
            <div class="screen-w3ls py-5">
                <div class="container py-xl-5 py-lg-3">
                    <div class="w3ls-titles text-center mb-5">
                        <h3 class="title">BLOOD GROUPS</h3>
                        <span>
                            <i class="fas fa-user-md"></i>
                        </span>
                        <p class="mt-2">The blood type of any individual typically falls into one of the following categories...</p>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">    
                            <ul>              
                                <li>A+ or A-</li>
                                <li>B+ or B-</li>
                                <li>O+ or O-</li>
                                <li>AB+ or AB-</li>
                            </ul><br>
                            <p>Maintaining a healthy diet not only ensures a successful blood donation but also promotes overall well-being. 
                                Consider incorporating the following recommended foods into your diet before donating blood:</p><br>
                            <div class="row">
                                <div class="col-lg-6"> 
                                    <ul>
                                        <li>Iron-rich foods such as red meat, lentils (dal), and leafy green vegetables like spinach (pui shak).</li>
                                        <li>Vitamin C-rich fruits such as guava (peyara), oranges, and mangoes (aam).</li>
                                        <li>Traditional foods like rice (bhaat) and fish (mach) for sustained energy.</li>
                                        <li>Dairy products like milk and yogurt for calcium and protein.</li>
                                        <li>Local beverages like coconut water and green tea for hydration.</li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <img class="img-fluid rounded" src="images/blood-donor(1).jpg" alt="">
                                </div>
                            </div>				
                            <div class="row">
                                <div class="col-12">
                                    <h4 style="padding-top: 30px;">UNIVERSAL DONORS AND RECIPIEffNTS</h4>
                                    <p>
                                        The most prevalent blood type is O, with type A following closely behind. Type O individuals are often referred to as "universal donors" because their blood is compatible with all blood types for transfusions. Conversely, individuals with type AB blood are dubbed "universal recipients" as they can receive blood from any type without facing compatibility issues.
                                    </p> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
	<script src="js/fixed-nav.js"></script>
	<!-- //fixed navigation -->

	<!-- smooth scrolling -->
	<script src="js/SmoothScroll.min.js"></script>
	<!-- move-top -->
	<script src="js/move-top.js"></script>
	<!-- easing -->
	<script src="js/easing.js"></script>
	<!--  necessary snippets for few javascript files -->
	<script src="js/medic.js"></script>

	<script src="js/bootstrap.js"></script>
	<!-- Necessary-JavaScript-File-For-Bootstrap -->

	<!-- //Js files -->

</body>

</html>
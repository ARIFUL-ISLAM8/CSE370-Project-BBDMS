<?php
error_reporting(0);
include('includes/config.php');

// Fetch team members from the database
$sql = "SELECT * FROM TeamMembers";
$query = $dbh->prepare($sql);
$query->execute();
$teamMembers = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Blood Bank Donor Management System | About Us </title>
    <!-- Meta tag Keywords -->

    <script>
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
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

    <?php include('includes/header.php'); ?>
    <!-- banner 2 -->
    <div class="inner-banner-w3ls">
        <div class="container">
        </div>
    </div>

    <!-- about -->
    <section class="about">
        <div class="container py-xl-2 py-lg-2">
            <div class="w3ls-titles text-center mb-md-5 mb-4">
                <h3 class="title">Who We Are?</h3>
                <span>
                    <i class="fas fa-user-md"></i>
                </span>
                <p class="py-3">Our mission is to create a centralized platform that connects blood donors with those in need, making the process of blood donation more efficient and accessible. Through our website, we aim to promote awareness and educate the public on the importance of regular blood donation. By leveraging technology to streamline the process and connect donors with recipients in real-time, we hope to make a positive impact on the lives of those in need of life-saving blood transfusions.</p>
            </div>
        </div>
    </section>

    <!-- our teams -->
    <section class="p-5">
        <h3 class="title py-xl-2 py-lg-2">Behind This Project?</h3>
        <div class="card-deck">
            <?php foreach ($teamMembers as $member) : ?>
                <div class="card">
                    <img src="<?php echo $member['Image']; ?>" class="card-img-top team-img" alt="<?php echo $member['Name']; ?>" style="height:50%">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo $member['Name']; ?></h4>
                        <p class="card-text"><?php echo $member['ShortMessage']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <!-- //about -->
    <?php include('includes/footer.php'); ?>
    <!-- Js files -->
    <!-- JavaScript -->
    <script src="js/jquery-2.2.3.min.js"></script>
    <!-- Default-JavaScript-File -->

    <!-- banner slider -->
    <script src="js/responsiveslides.min.js"></script>
    <script>
        $(function() {
            $("#slider4").responsiveSlides({
                auto: true,
                pager: true,
                nav: true,
                speed: 1000,
                namespace: "callbacks",
                before: function() {
                    $('.events').append("<li>before event fired.</li>");
                },
                after: function() {
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

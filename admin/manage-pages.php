<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin'])==0) {   
    header('location:../index.php');
} else {
    if(isset($_POST['submit'])) {
        $name = $_POST['name'];
        $shortMessage = $_POST['short_message'];
        // Image upload handling
        $target_file = $_POST['image_directory'];

        // Insert data into TeamMembers table
        $sql = "INSERT INTO TeamMembers (Name, ShortMessage, Image) VALUES (:name, :shortMessage, :image)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':shortMessage', $shortMessage, PDO::PARAM_STR);
        $query->bindParam(':image', $target_file, PDO::PARAM_STR);
        $query->execute();

        $msg="Team member added successfully";
    }

    if(isset($_GET['del'])) {
        // Get the team member ID to delete
        $id = $_GET['del'];
        // Delete the team member from the database
        $sql = "DELETE FROM TeamMembers WHERE ID = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        $msg="Team member deleted successfully";
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
    
    <title>BBDMS | Admin Manage Team Members</title>

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
    <script type="text/JavaScript">
    <script type="text/javascript" src="nicEdit.js"></script>
    <script type="text/javascript">
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
    </script>
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
                        <h2 class="page-title">Manage Team Members</h2>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Add Team Member</div>
                                    <div class="panel-body">
                                        <form method="post" class="form-horizontal" enctype="multipart/form-data">
                                            <?php if(isset($msg)){ ?>
                                                <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div>
                                            <?php } ?>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="name" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Short Message</label>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" name="short_message" rows="5" required></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Image Directory</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="image_directory" placeholder="Enter the directory path to the image" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-8 col-sm-offset-4">
                                                <button type="submit" name="submit" class="btn-primary btn">Add</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Display existing team members here -->
                            <?php
                            $sql = "SELECT * FROM TeamMembers";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_ASSOC);
                            foreach($results as $result) {
                            ?>
                            <div class="col-md-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><?php echo $result['Name']; ?></div>
                                    <div class="panel-body">
                                        <img src="<?php echo $result['Image']; ?>" alt="<?php echo $result['Name']; ?>" style="width:100%">
                                        <p><?php echo $result['ShortMessage']; ?></p>
                                        <a href="?del=<?php echo $result['ID']; ?>" onclick="return confirm('Are you sure you want to delete?');" class="btn btn-danger btn-sm">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
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

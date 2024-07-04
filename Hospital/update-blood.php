<?php 
session_start(); 
// Establish database connection (replace these credentials with your actual database credentials)
$db_host = 'localhost';
$db_name = 'bbdms';
$db_user = 'root';
$db_pass = '';

try {
    $dbh = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = isset($_GET['hospital_id']) ? intval($_GET['hospital_id']) : 0;
    $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

    // Fetch the current data of the hospital from the database
    $sql = "SELECT * FROM stock s WHERE s.Hospital_Id = :id";

    $statement = $dbh->prepare($sql);
    $statement->execute([':id' => $id ]);
    
    // Fetch the hospital data
    $hospital_stock = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Check if the form is submitted
    if (isset($_POST['submit'])) {   
        // Initialize an array to hold the updated stock quantities
        $updated_stock = array();
        
        // Loop through each blood type and update the quantity if value is provided, otherwise keep the existing quantity
        foreach ($_POST['blood_quantity'] as $blood_type => $quantity) {
            if (!empty($quantity)) {
                // Set the quantity to the value submitted in the form
                $updated_stock[$blood_type] = $quantity;
            }
        }
        
        // Prepare the SQL query to update the stock quantities
        $sql = "UPDATE stock SET quantity = CASE ";
        foreach ($updated_stock as $blood_type => $quantity) {
            $sql .= "WHEN blood_type = :blood_type THEN :quantity ";
        }
        $sql .= "ELSE quantity END WHERE Hospital_Id = :id";

        // Prepare the statement
        $statement = $dbh->prepare($sql);

        // Bind parameters
        $statement->bindParam(":id", $id);
        foreach ($updated_stock as $blood_type => $quantity) {
            $statement->bindValue(":blood_type", $blood_type);
            $statement->bindValue(":quantity", $quantity);
            $statement->execute();
        }

        // Execute the statement
        if ($statement->execute()) {
          $message = "Stock updated successfully.";
        } 
        else {
            $message = "Error updating stock.";
        }

        
        echo $message . "<br>";      

        // Redirect to the stock update page after successful update
        header("Location: HospitalPanel.php?user_id=$user_id");
        exit(); // Ensure no further code is executed after redirection
    }
} catch (PDOException $e) {
    // Handle any exceptions
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Blood Bank Hospital Management System | Update Hospital Stock</title>
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
<div class="container">
  <div class="card mt-5">
    <div class="card-header">
      <h2>Update Hospital Stock</h2>
    </div>
    <div class="card-body">
      <form method="post">
        <div class="form-group">
          <label for="A+">A+</label>
          <input value="<?= isset($hospital_stock['A+']) ? $hospital_stock['A+'] : ''; ?>" type="number" name="blood_quantity[A+]" id="A+" class="form-control">
        </div>
        <div class="form-group">
          <label for="A-">A-</label>
          <input value="<?= isset($hospital_stock['A-']) ? $hospital_stock['A-'] : ''; ?>" type="number" name="blood_quantity[A-]" id="A-" class="form-control">
        </div>
        <div class="form-group">
          <label for="B+">B+</label>
          <input value="<?= isset($hospital_stock['B+']) ? $hospital_stock['B+'] : ''; ?>" type="number" name="blood_quantity[B+]" id="B+" class="form-control">
        </div>
        <div class="form-group">
          <label for="B-">B-</label>
          <input value="<?= isset($hospital_stock['B-']) ? $hospital_stock['B-'] : ''; ?>" type="number" name="blood_quantity[B-]" id="B-" class="form-control">
        </div>
        <div class="form-group">
          <label for="AB+">AB+</label>
          <input value="<?= isset($hospital_stock['AB+']) ? $hospital_stock['AB+'] : ''; ?>" type="number" name="blood_quantity[AB+]" id="AB+" class="form-control">
        </div>
        <div class="form-group">
          <label for="AB-">AB-</label>
          <input value="<?= isset($hospital_stock['AB-']) ? $hospital_stock['AB-'] : ''; ?>" type="number" name="blood_quantity[AB-]" id="AB-" class="form-control">
        </div>
        <div class="form-group">
          <label for="O+">O+</label>
          <input value="<?= isset($hospital_stock['O+']) ? $hospital_stock['O+'] : ''; ?>" type="number" name="blood_quantity[O+]" id="O+" class="form-control">
        </div>
        <div class="form-group">
          <label for="O-">O-</label>
          <input value="<?= isset($hospital_stock['O-']) ? $hospital_stock['O-'] : ''; ?>" type="number" name="blood_quantity[O-]" id="O-" class="form-control">
        </div>
        <div class="form-group">
          <button type="submit" name="submit" class="btn btn-info">Update Hospital Stock</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Js files -->
<!-- JavaScript -->
<script src="../js/jquery-2.2.3.min.js"></script>
<!-- Default-JavaScript-File -->

<!-- fixed navigation -->
<script src="../js/fixed-nav.js"></script>
<!-- //fixed navigation -->

<script src="../js/bootstrap.js"></script>
<!-- Necessary-JavaScript-File-For-Bootstrap -->

</body>

</html>

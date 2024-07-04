<?php 
error_reporting(0);
session_start(); 

// Include the database configuration file
include('../includes/config.php');

$loggedInUserID = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
$hospitalID = isset($_GET['hospital_id']) ? intval($_GET['hospital_id']) : 0;

// Query to select blood banks along with their location
$sql = "SELECT BloodBank.Bank_ID, BloodBank.Name, BloodBank.Street, BloodBankLocation.City, BloodBankLocation.Zip_Code
        FROM BloodBank
        INNER JOIN BloodBankLocation ON BloodBank.City = BloodBankLocation.City";

try {
    $query = $dbh->prepare($sql);
    $query->execute();

    // Check if there are any results
    if ($query->rowCount() > 0) {
        // Fetch all results as objects
        $bloodBanks = $query->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // No results found, display a message or handle it as needed
        echo "<p>No blood banks found.</p>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>Blood Bank Management System | Blood Bank List</title>
    <!-- Include meta tags, stylesheets, and scripts here -->
    <style>
        /* Add CSS styles for the modal */
        /* Modal background */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(255, 255, 255, 0.9); /* White background with opacity */
        }

        /* Modal content */
        .modal-content {
            background-color: #ffffff; /* White background */
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        /* Close button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
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
                    <a class="navbar-brand font-weight-bold font-italic" href="HospitalPanel.php?user_id=<?php echo $loggedInUserID;?>">
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
                                <a href="HospitalPanel.php?user_id=<?php echo $loggedInUserID;?>">Home</a>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
                    <a href="patient-list.php?hospital_id=<?php echo $loggedInUserID; ?>&hospital_id=<?php echo $hospitalID; ?>" class="login-button ml-lg-3 mt-lg-0 mt-4 mb-lg-0 mb-3">
                        <i class="fas fa-user-plus mr-2"></i>patient List
                    </a>
                    <a href="bloodbank.php?user_id=<?php echo $loggedInUserID; ?>&hospital_id=<?php echo $hospitalID; ?>" class="login-button ml-lg-3 mt-lg-0 mt-4 mb-lg-0 mb-3">
                        <i class="fas fa-user-plus mr-2"></i>Blood Bank
                    </a>
                    <a href="../Patient/patientaccount.php" class="login-button ml-lg-3 mt-lg-0 mt-4 mb-lg-0 mb-3">
                        <i class="fas fa-user-plus mr-2"></i>Create patient account
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

<!-- blood bank list -->
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <h3 class="mb-4">Blood Bank List</h3>
            <!-- Add search input fields -->
            
            <table class="table table-bordered" style="border: 1px solid #ddd;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #ddd;">Bank ID</th>
                        <th style="border: 1px solid #ddd;">Name</th>
                        <th style="border: 1px solid #ddd;">Street</th>
                        <th style="border: 1px solid #ddd;">City</th>
                        <th style="border: 1px solid #ddd;">Zip Code</th>
                        <th style="border: 1px solid #ddd;">View Stock</th>
                        <th style="border: 1px solid #ddd;">Place Order</th>
                    </tr>
                </thead>
                <tbody id="bloodBankTable">
                    <?php
                    // Populate the table with fetched data
                    if (isset($bloodBanks) && !empty($bloodBanks)) {
                        foreach ($bloodBanks as $bank) {
                            echo "<tr>";
                            echo "<td>{$bank['Bank_ID']}</td>";
                            echo "<td>{$bank['Name']}</td>";
                            echo "<td>{$bank['Street']}</td>";
                            echo "<td>{$bank['City']}</td>";
                            echo "<td>{$bank['Zip_Code']}</td>";
                            echo "<td><button onclick='viewStock({$bank['Bank_ID']})'>View Stock</button></td>";
                            echo "<td><button onclick='placeOrder({$bank['Bank_ID']})'>Place Order</button></td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- //blood bank list -->

<!-- Modal for View Stock -->
<div id="viewStockModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>View Stock</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Blood Type</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody id="stockDetails">
                <!-- Stock details will be populated here -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal for Place Order -->
<div id="placeOrderModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Place Order</h2>
        <!-- Display place order form here -->
        <form id="orderForm">
            <input type="text" id="hospitalID" name="hospital_id" value="<?php echo $hospitalID; ?>" readonly>
            <!-- Hospital ID is now readonly but visible -->
            <input type="text" id="bankID" name="bank_id" placeholder="Bank ID" readonly>
            <!-- Bank ID is now readonly and will be auto-filled when the "Place Order" button is clicked -->
            <!-- Blood Group Selection -->
            <div class="blood-group-selection">
                <label for="bloodGroup">Blood Group:</label>
                <!-- ABO Blood Group Dropdown -->
                <select id="bloodGroupDropdown">
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="AB">AB</option>
                    <option value="O">O</option>
                </select>
                <!-- Rh Factor Selection Dropdown -->
                <select id="rhFactor" name="rh_factor">
                    <option value="pos">+</option>
                    <option value="neg">-</option>
                </select>
            </div>
            <input type="number" id="quantity" name="quantity" placeholder="Quantity">
            <button type="button" onclick="submitOrder()">Submit Order</button>
        </form>
    </div>
</div>

<!-- Js files -->
<script>
    // Function to handle the click event for the "View Stock" button
    function viewStock(bankID) {
        console.log("View Stock button clicked for bank ID:", bankID); // Debugging
        // Make an AJAX request to fetch stock data for the specified blood bank ID
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    try {
                        // Parse the JSON response
                        console.log("Response from fetch_stock.php:", this.responseText); // Debugging
                        var stockData = JSON.parse(this.responseText);
                        console.log("Stock data received:", stockData); // Debugging
                        // Populate the modal with the stock data
                        populateStockModal(stockData);
                        // Show the view stock modal
                        viewStockModal.style.display = "block";
                    } catch (error) {
                        console.error("Error parsing JSON:", error);
                        // Optionally, you can display an error message to the user or handle the error in another way.
                    }
                } else {
                    console.error("Error fetching stock data: " + this.status);
                }
            }
        };
        xhttp.open("GET", "fetch_stock.php?bank_id=" + bankID, true);
        xhttp.send();
    }


    // Function to populate the "View Stock" modal with data
    function populateStockModal(stockData) {
        var stockDetailsTable = document.getElementById("stockDetails");
        // Clear existing data
        stockDetailsTable.innerHTML = '';

        // Check if stockData is an array
        if (Array.isArray(stockData)) {
            // Populate with fetched data
            stockData.forEach(function(item) {
                var row = "<tr><td>" + item.Blood_Group + "</td><td>" + item.Quantity + "</td></tr>";
                stockDetailsTable.innerHTML += row;
            });
        } else {
            // Handle case where stockData is not an array (e.g., error occurred)
            stockDetailsTable.innerHTML = '<tr><td colspan="2">Error fetching stock data</td></tr>';
        }
    }

    // Function to handle the click event for the "Place Order" button
    function placeOrder(bankID) {
        // Fill the bank ID input field with the clicked bank ID
        document.getElementById("bankID").value = bankID;
        // Show the place order modal
        placeOrderModal.style.display = "block";
    }

    // Function to handle the form submission for placing an order
    function submitOrder() {
        // Get form data
        var hospitalID = document.getElementById("hospitalID").value;
        var bankID = document.getElementById("bankID").value;
        var bloodGroup = document.getElementById("bloodGroupDropdown").value; // Update to get value from dropdown
        var rhFactor = document.getElementById("rhFactor").value;
        var quantity = document.getElementById("quantity").value;
        
        // Print form data for debugging
        console.log("Hospital ID:", hospitalID);
        console.log("Bank ID:", bankID);
        console.log("Blood Group:", bloodGroup);
        console.log("Rh Factor:", rhFactor);
        console.log("Quantity:", quantity);
        
        // Make AJAX request
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    // Handle successful response
                    console.log("Order placed successfully.");
                    // Close the place order modal
                    placeOrderModal.style.display = "none";
                } else {
                    // Handle error response
                    console.error("Error placing order: " + this.status);
                }
            }
        };
        xhttp.open("POST", "place_order.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("hospital_id=" + hospitalID + "&bank_id=" + bankID + "&blood_group=" + bloodGroup + "&rh_factor=" + rhFactor + "&quantity=" + quantity);
    }

    // Get the modals
    var viewStockModal = document.getElementById('viewStockModal');
    var placeOrderModal = document.getElementById('placeOrderModal');

    // Get the <span> element that closes the modal
    var closeButtons = document.getElementsByClassName("close");

    // When the user clicks on <span> (x), close the modal
    Array.from(closeButtons).forEach(function(button) {
        button.onclick = function() {
            viewStockModal.style.display = "none";
            placeOrderModal.style.display = "none";
        }
    });

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == viewStockModal) {
            viewStockModal.style.display = "none";
        }
        if (event.target == placeOrderModal) {
            placeOrderModal.style.display = "none";
        }
    }
</script>
<!-- Include the JavaScript function for filtering the table -->
</body>
</html>

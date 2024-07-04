<?php
// Include database configuration file
include('../includes/config.php');

try {
    // Retrieve search parameters
    $bloodGroup = !empty($_POST['bloodGroup']) ? $_POST['bloodGroup'] : null;
    $city = !empty($_POST['city']) ? $_POST['city'] : null;

    // Define the base SQL query
    $sql = "SELECT u.User_ID, u.Name, d.Gender, d.Blood_Group, 
            GROUP_CONCAT(DISTINCT dc.Contact SEPARATOR ', ') AS Contact, 
            d.Age, d.Street, d.City, dct.Zip_Code, 
            GROUP_CONCAT(DISTINCT p.Preferred_Donation_Center SEPARATOR ', ') AS Preferred_Donation_Center, 
            GROUP_CONCAT(DISTINCT r.Remarks SEPARATOR ', ') AS Remarks, 
            dl1.Last_Date_Of_Donation, dl1.Amount_Of_Blood_Donated, dl2.Donation_Frequency
            FROM Donor d
            LEFT JOIN User u ON d.User_ID = u.User_ID
            LEFT JOIN DonorContact dc ON d.User_ID = dc.User_ID
            LEFT JOIN Preference p ON d.User_ID = p.User_ID
            LEFT JOIN Remark r ON d.User_ID = r.User_ID
            LEFT JOIN Donation_Log_1 dl1 ON d.User_ID = dl1.User_ID
            LEFT JOIN Donation_Log_2 dl2 ON d.User_ID = dl2.User_ID
            LEFT JOIN DonorCity dct ON d.city = dct.city
            WHERE dl2.Donation_Frequency = 'Regular' AND u.Per_id = :per_id ";

    // Check if any search parameters are provided
    if (!empty($bloodGroup) || !empty($city)) {
        // Check if blood group is provided
        if (!empty($bloodGroup)) {
            $sql .= " AND d.Blood_Group = :bloodGroup ";
        }
        
        // Check if city is provided
        if (!empty($city)) {
            // Convert city to uppercase
            $city = strtoupper($city);
            $sql .= " AND UPPER(p.Preferred_Donation_Center) = :city ";
        }  

        // Grouping by User_ID
        $sql .= " GROUP BY d.User_ID";

        // Prepare and execute the query
        $query = $dbh->prepare($sql);
        $per_id = 3; // Set Per_id
        $query->bindParam(':per_id', $per_id, PDO::PARAM_INT);

        // Bind parameters if provided
        if (!empty($bloodGroup)) {
            $query->bindParam(':bloodGroup', $bloodGroup, PDO::PARAM_STR);
        }

        if (!empty($city)) {
            $query->bindParam(':city', $city, PDO::PARAM_STR);
        }

        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        // Return the results as JSON
        header('Content-Type: application/json');
        echo json_encode($results);
    } else {
        // If no search parameters are provided, return all donors
        $sql .= " GROUP BY d.User_ID";
        $query = $dbh->prepare($sql);
        $per_id = 3; // Set Per_id
        $query->bindParam(':per_id', $per_id, PDO::PARAM_INT);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($results);
    }
} catch (PDOException $e) {
    // Handle database errors
    echo "Database Error: " . $e->getMessage();
} catch (Exception $e) {
    // Handle other errors
    echo "Error: " . $e->getMessage();
}
?>

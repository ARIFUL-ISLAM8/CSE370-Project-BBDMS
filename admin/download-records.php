<?php 
session_start();
include('includes/config.php');

if(strlen($_SESSION['alogin'])==0)
{	
	header("Location: ../index.php"); //
}
else {
    // Define the filename
    $filename = "Donor list";
    // Set the header information for Excel file download
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=".$filename."report.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
?>
<table border="1">
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
        $query = $dbh -> prepare($sql);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        $cnt=1;
        if($query->rowCount() > 0) {
            foreach($results as $result) {	
        ?>
        <tr>
            <td><?php echo $cnt;?></td>
            <td><?php echo htmlentities($result->Name);?></td>
            <td><?php echo htmlentities($result->Contact);?></td>
            <td><?php echo htmlentities($result->Age);?></td>
            <td><?php echo htmlentities($result->Gender);?></td>
            <td><?php echo htmlentities($result->Blood_Group);?></td>
            <td><?php echo htmlentities($result->Street.", ".$result->City);?></td>
            <td><?php echo htmlentities($result->Donation_Frequency);?></td>
            <td></td>
        </tr>
        <?php 
            $cnt++;
            }
        }
        ?>
    </tbody>
</table>
<?php } ?>

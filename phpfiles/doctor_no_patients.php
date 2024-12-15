<?php
include '../connecttodb.php';
// Programmer Name: 93
// Purpose: Display a list of doctors who currently have no patients assigned to them.
//          The script uses a subquery to identify doctors whose IDs are not present in the patient table.

// Query to fetch doctors who have no patients
$query = "SELECT docid, firstname, lastname 
          FROM doctor 
          WHERE docid NOT IN (SELECT DISTINCT treatsdocid FROM patient)";

$result = mysqli_query($connection, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>Doctors Without Patients</title>
</head>
<body>
    <h1>Doctors Without Patients</h1>
    <table>
        <thead>
            <tr>
                <th>Doctor ID</th>
                <th>First Name</th>
                <th>Last Name</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['docid'] ?></td>
                    <td><?= $row['firstname'] ?></td>
                    <td><?= $row['lastname'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php mysqli_close($connection); ?>
    
    <div style="margin-top: 20px;">
        <a href="mainmenu.php" class="button">Back to Main Menu</a>
    </div>
</body>
</html>

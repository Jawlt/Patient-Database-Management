<?php
include '../connecttodb.php';
// Programmer Name: 93
// Purpose: Display a sortable list of all patients, including:
//          - OHIP number, first name, last name, weight, and height (in both metric and imperial units).
//          - The first and last name of the doctor treating each patient (if assigned).

// Default sorting options
$sort_by = $_POST['sort_by'] ?? 'lastname';
$order = $_POST['order'] ?? 'ASC';

// Query to fetch patient data with doctor information
$query = "SELECT patient.*, doctor.firstname AS doctor_fname, doctor.lastname AS doctor_lname 
          FROM patient 
          LEFT JOIN doctor ON patient.treatsdocid = doctor.docid 
          ORDER BY $sort_by $order";

$result = mysqli_query($connection, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>List Patients</title>
</head>
<body>
    <h1>List of Patients</h1>
    <form method="POST">
        <label>Sort By:</label>
        <input type="radio" name="sort_by" value="firstname" <?= $sort_by == 'firstname' ? 'checked' : '' ?>> First Name
        <input type="radio" name="sort_by" value="lastname" <?= $sort_by == 'lastname' ? 'checked' : '' ?>> Last Name
        <label>Order:</label>
        <input type="radio" name="order" value="ASC" <?= $order == 'ASC' ? 'checked' : '' ?>> Ascending
        <input type="radio" name="order" value="DESC" <?= $order == 'DESC' ? 'checked' : '' ?>> Descending
        <button type="submit">Sort</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>OHIP</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Doctor</th>
                <th>Weight (kg)</th>
                <th>Height (m)</th>
                <th>Weight (lbs)</th>
                <th>Height (ft & in)</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['ohip'] ?></td>
                    <td><?= $row['firstname'] ?></td>
                    <td><?= $row['lastname'] ?></td>
                    <td><?= $row['doctor_fname'] . ' ' . $row['doctor_lname'] ?></td>
                    <td><?= $row['weight'] ?></td>
                    <td><?= $row['height'] ?></td>
                    <td><?= round($row['weight'] * 2.205, 2) ?></td>
                    <td><?= floor($row['height'] * 3.281) . " ft " . round(($row['height'] * 3.281 - floor($row['height'] * 3.281)) * 12) . " in" ?></td>
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

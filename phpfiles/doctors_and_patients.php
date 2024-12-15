<?php
include '../connecttodb.php';
// Programmer Name: 93
// Purpose: Display a list of all doctors and their respective patients from the database.
//          If a doctor has no patients, the output will indicate "No Patients".

// Query to list doctors and their patients
$query = "SELECT doctor.firstname AS doctor_fname, doctor.lastname AS doctor_lname, 
                 patient.firstname AS patient_fname, patient.lastname AS patient_lname 
          FROM doctor 
          LEFT JOIN patient ON doctor.docid = patient.treatsdocid
          ORDER BY doctor.docid";

$result = mysqli_query($connection, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>Doctors and Their Patients</title>
</head>
<body>
    <h1>Doctors and Their Patients</h1>
    <table>
        <thead>
            <tr>
                <th>Doctor</th>
                <th>Patient</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['doctor_fname'] . ' ' . $row['doctor_lname'] ?></td>
                    <td><?= $row['patient_fname'] ? $row['patient_fname'] . ' ' . $row['patient_lname'] : 'No Patients' ?></td>
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

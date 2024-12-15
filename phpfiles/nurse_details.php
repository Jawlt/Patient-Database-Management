<?php
include '../connecttodb.php';
// Programmer Name: 93
// Purpose: Display detailed information about a specific nurse, including:
//          - The nurse's full name.
//          - The name of the supervisor (if any).
//          - The list of doctors the nurse works for and the hours worked for each doctor.
//          - The total number of hours worked by the nurse.

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nurseid = $_POST['nurseid'];

    // Query for nurse details
    $nurse_query = "SELECT firstname, lastname, reporttonurseid FROM nurse WHERE nurseid = '$nurseid'";
    $nurse_result = mysqli_query($connection, $nurse_query);

    // Query for doctors the nurse works for
    $working_query = "SELECT doctor.firstname AS doctor_fname, doctor.lastname AS doctor_lname, workingfor.hours 
                      FROM workingfor 
                      JOIN doctor ON workingfor.docid = doctor.docid 
                      WHERE workingfor.nurseid = '$nurseid'";

    $working_result = mysqli_query($connection, $working_query);

    // Calculate total hours
    $total_hours_query = "SELECT SUM(hours) AS total_hours FROM workingfor WHERE nurseid = '$nurseid'";
    $total_hours_result = mysqli_query($connection, $total_hours_query);
    $total_hours = mysqli_fetch_assoc($total_hours_result)['total_hours'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>Nurse Details</title>
</head>
<body>
    <h1>Nurse Details</h1>
    <form method="POST">
        <label>Nurse ID:</label> <input type="text" name="nurseid" required><br>
        <button type="submit">Get Details</button>
    </form>

    <?php if (isset($nurse_result) && mysqli_num_rows($nurse_result) > 0): ?>
        <?php $nurse = mysqli_fetch_assoc($nurse_result); ?>
        <h2>Nurse: <?= $nurse['firstname'] . ' ' . $nurse['lastname'] ?></h2>
        <h3>Supervisor: 
            <?php
            if ($nurse['reporttonurseid']) {
                $supervisor_query = "SELECT firstname, lastname FROM nurse WHERE nurseid = '{$nurse['reporttonurseid']}'";
                $supervisor_result = mysqli_query($connection, $supervisor_query);
                $supervisor = mysqli_fetch_assoc($supervisor_result);
                echo $supervisor['firstname'] . ' ' . $supervisor['lastname'];
            } else {
                echo 'None';
            }
            ?>
        </h3>

        <h3>Doctors Worked For:</h3>
        <table>
            <thead>
                <tr>
                    <th>Doctor</th>
                    <th>Hours</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($working_result)): ?>
                    <tr>
                        <td><?= $row['doctor_fname'] . ' ' . $row['doctor_lname'] ?></td>
                        <td><?= $row['hours'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <h3>Total Hours Worked: <?= $total_hours ?: 0 ?></h3>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <p>No nurse found with the given ID.</p>
    <?php endif; ?>
    <?php mysqli_close($connection); ?>

    <div style="margin-top: 20px;">
        <a href="mainmenu.php" class="button">Back to Main Menu</a>
    </div>
</body>
</html>

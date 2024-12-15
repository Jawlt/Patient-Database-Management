<?php
include '../connecttodb.php';
// Programmer Name: 93
// Purpose: Allow users to add a new patient to the database.

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ohip = $_POST['ohip'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $birthdate = $_POST['birthdate'];
    $treatsdocid = $_POST['treatsdocid'];

    // Check if the OHIP number already exists
    $check_query = "SELECT * FROM patient WHERE ohip = '$ohip'";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "Error: OHIP number already exists.";
    } else {
        // Insert new patient record
        $insert_query = "INSERT INTO patient (ohip, firstname, lastname, weight, height, birthdate, treatsdocid) 
                         VALUES ('$ohip', '$firstname', '$lastname', $weight, $height, '$birthdate', '$treatsdocid')";
        if (mysqli_query($connection, $insert_query)) {
            echo "Patient added successfully.";
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>Add Patient</title>
</head>
<body>
    <h1>Add New Patient</h1>
    <form method="POST">
        <label>OHIP Number:</label> <input type="text" name="ohip" required><br>
        <label>First Name:</label> <input type="text" name="firstname" required><br>
        <label>Last Name:</label> <input type="text" name="lastname" required><br>
        <label>Weight (kg):</label> <input type="number" step="0.01" name="weight" required><br>
        <label>Height (m):</label> <input type="number" step="0.01" name="height" required><br>
        <label>Birthdate:</label> <input type="date" name="birthdate" required><br>
        <label>Doctor:</label>
        <select name="treatsdocid" required>
            <?php
            $doctor_query = "SELECT * FROM doctor";
            $doctor_result = mysqli_query($connection, $doctor_query);
            while ($doctor = mysqli_fetch_assoc($doctor_result)) {
                echo "<option value='{$doctor['docid']}'>{$doctor['firstname']} {$doctor['lastname']}</option>";
            }
            ?>
        </select><br>
        <button type="submit">Add Patient</button>
    </form>
    <?php mysqli_close($connection); ?>
    
    <div style="margin-top: 20px;">
        <a href="mainmenu.php" class="button">Back to Main Menu</a>
    </div>
</body>
</html>

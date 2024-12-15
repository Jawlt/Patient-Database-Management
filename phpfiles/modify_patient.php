<?php
include '../connecttodb.php';
// Programmer Name: 93
// Purpose: Allow users to modify the weight of an existing patient in the database.
//          - Accepts the OHIP number of the patient and the new weight (in kilograms or pounds).
//          - Converts weight from pounds to kilograms if necessary and updates the database.

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ohip = $_POST['ohip'];
    $new_weight = $_POST['new_weight'];
    $weight_unit = $_POST['weight_unit'];

    // Convert weight to kilograms if entered in pounds
    if ($weight_unit == 'lbs') {
        $new_weight = $new_weight / 2.205;
    }

    // Check if patient exists
    $check_query = "SELECT * FROM patient WHERE ohip = '$ohip'";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) == 0) {
        echo "Error: OHIP number does not exist.";
    } else {
        // Update weight
        $update_query = "UPDATE patient SET weight = $new_weight WHERE ohip = '$ohip'";
        if (mysqli_query($connection, $update_query)) {
            echo "Patient weight updated successfully.";
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
    <title>Modify Patient</title>
</head>
<body>
    <h1>Modify Patient Weight</h1>
    <form method="POST">
        <label>OHIP Number:</label> <input type="text" name="ohip" required><br>
        <label>New Weight:</label> <input type="number" step="0.01" name="new_weight" required><br>
        <label>Weight Unit:</label>
        <input type="radio" name="weight_unit" value="kg" required> Kilograms
        <input type="radio" name="weight_unit" value="lbs" required> Pounds<br>
        <button type="submit">Update Weight</button>
    </form>
    <?php mysqli_close($connection); ?>

    <div style="margin-top: 20px;">
        <a href="mainmenu.php" class="button">Back to Main Menu</a>
    </div>
</body>
</html>

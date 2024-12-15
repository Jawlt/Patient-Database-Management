<?php
include '../connecttodb.php';
// Programmer Name: 93
// Purpose: Allow users to delete a patient record from the database by providing the OHIP number.
//          The script checks if the OHIP number exists, deletes the record if found, 
//          and provides feedback to the user.

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ohip = $_POST['ohip'];

    // Check if OHIP exists
    $check_query = "SELECT * FROM patient WHERE ohip = '$ohip'";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) == 0) {
        echo "Error: OHIP number does not exist.";
    } else {
        // Confirm deletion
        $delete_query = "DELETE FROM patient WHERE ohip = '$ohip'";
        if (mysqli_query($connection, $delete_query)) {
            echo "Patient deleted successfully.";
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
    <title>Delete Patient</title>
</head>
<body>
    <h1>Delete Patient</h1>
    <form method="POST">
        <label>OHIP Number:</label> <input type="text" name="ohip" required><br>
        <button type="submit">Delete Patient</button>
    </form>
    <?php mysqli_close($connection); ?>
    
    <div style="margin-top: 20px;">
    	<a href="mainmenu.php" class="button">Back to Main Menu</a>
    </div>
</body>
</html>

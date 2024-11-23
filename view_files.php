<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employee_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM file_uploads";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Uploaded Files</title>
</head>
<body>
    <h2>Uploaded Files</h2>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>User ID</th>
                <th>File Name</th>
                <th>File Path</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['user_id'] ?></td>
                    <td><?= $row['file_name'] ?></td>
                    <td><a href="<?= $row['file_path'] ?>" target="_blank">View File</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No files uploaded yet.</p>
    <?php endif; ?>

    <?php
   
    $conn->close();
    ?>
</body>
</html>

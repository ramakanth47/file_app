<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employee_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $user_id = 1; 
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    
   
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true); 
    }

  
    $file_path = $upload_dir . $file_name;
    $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
    $file_type = mime_content_type($file_tmp);
    
    if (!in_array($file_type, $allowed_types)) {
        echo "Only images and PDFs are allowed!";
        exit;
    }

   
    if (move_uploaded_file($file_tmp, $file_path)) {
        $sql = "INSERT INTO file_uploads (user_id, file_name, file_path) VALUES ('$user_id', '$file_name', '$file_path')";
        
        if ($conn->query($sql) === TRUE) {
            echo "File uploaded successfully.";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error uploading file! Please ensure the 'uploads' directory is writable.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File Upload</title>
</head>
<body>
    <h2>Upload Identity File</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="file" required><br><br>
        <button type="submit">Upload</button>
    </form>
</body>
</html>

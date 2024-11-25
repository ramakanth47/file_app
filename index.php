<?php
// Database connection
$servername = "localhost";
$username = "root";  
$password = "";     
$dbname = "employee_db"; 
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$records_per_page = 10; 
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start_from = ($page - 1) * $records_per_page;

// Search functionality
$search = isset($_POST['search']) ? $_POST['search'] : ''; 
$search_query = $search ? "WHERE name LIKE '%$search%' OR designation LIKE '%$search%'" : "";


$sql = "SELECT * FROM employees $search_query LIMIT $start_from, $records_per_page";
$result = $conn->query($sql);


$count_sql = "SELECT COUNT(*) FROM employees $search_query";
$count_result = $conn->query($count_sql);
$row = $count_result->fetch_row();
$total_records = $row[0];
$total_pages = ceil($total_records / $records_per_page);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee List with Pagination</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Employee List</h1>

    <!-- Search Form -->
    <form method="POST" action="">
        <input type="text" name="search" placeholder="Search by Name or Designation" value="<?php echo $search; ?>">
        <button type="submit">Search</button>
    </form>

    <!-- Employee Table -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Designation</th>
            <th>Date of Birth</th>
            <th>Date of Joining</th>
            <th>Blood Group</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Address</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['designation']}</td>
                        <td>{$row['dob']}</td>
                        <td>{$row['date_of_joining']}</td>
                        <td>{$row['blood_group']}</td>
                        <td>{$row['mobile']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['address']}</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No records found</td></tr>";
        }
        ?>

    </table>

   
    <div class="pagination">
        <?php
        if ($page > 1) {
            echo "<a href='?page=1'>First</a> ";
            echo "<a href='?page=" . ($page - 1) . "'>Previous</a> ";
        }

        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<a href='?page=$i'>$i</a> ";
        }

        if ($page < $total_pages) {
            echo "<a href='?page=" . ($page + 1) . "'>Next</a> ";
            echo "<a href='?page=$total_pages'>Last</a>";
        }
        ?>
    </div>

</body>
</html>

<?php
$conn->close();
?>

<?php
include 'database/db.php';

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
</head>
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
    }

    .dashboard-container {
        display: flex;
    }

    .sidebar {
        width: 250px;
        height: 100vh;
        background-color: #2C3E50;
        color: white;
        padding: 20px;
    }

    .sidebar h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .sidebar ul {
        list-style: none;
    }

    .sidebar ul li {
        margin: 15px 0;
    }

    .sidebar ul li a {
        color: white;
        text-decoration: none;
        display: block;
        padding: 10px;
        border-radius: 5px;
    }

    .sidebar ul li a:hover {
        background-color: #1A252F;
    }

    .main-content {
        flex: 1;
        padding: 20px;
    }

    header h1 {
        margin-bottom: 20px;
    }

    .cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .card {
        background-color: #3498DB;
        color: white;
        padding: 20px;
        text-align: center;
        border-radius: 5px;
    }

</style>
<body>
<?php
include 'navbar.php';
?>
    <div class="dashboard-container">
        <aside class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="dashbord.php">Dashboard</a></li>
                <li><a href="viewaside.php">Slide</a></li>
                <li><a href="#">Reports</a></li>
                <li><a href="#">Analytics</a></li>
            </ul>
        </aside>
        
        <table class="table">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Picture</th>
                <th ><a href="create.php" class="btn btn-primary" >Add New Product</a></th>
                </tr>
                
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['price']; ?>$</td>
                        <td><img src="<?php echo $row['img']; ?>" width="100" /></td>
                        <td>
                            <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a> |
                            <a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
                        </td>
                       
                    </tr>
                <?php } ?>
            </tbody>
            </table>
            
    </div>
</body>
</html>
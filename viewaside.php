<?php
include 'navbar.php';

// Include database connection
require_once 'database/db.php'; // Ensure this file initializes $conn properly


$sql = "SELECT * FROM aside";
$result = $conn->query($sql);

$num = $result->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Aside</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .dashboard-container {
            display: flex;
        }
        .sidebar {
            width: 250px;
            background: #343a40;
            color: white;
            padding: 15px;
            min-height: 100vh;
        }
        .sidebar h2 {
            text-align: center;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            margin: 10px 0;
        }
        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            transition: 0.3s;
        }
        .sidebar ul li a:hover {
            background: #495057;
        }
        .body-area {
            flex: 1;
            padding: 20px;
        }
        .product-description {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>
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
    <div class='body-area'>
        <div class='container-fluid mt-5'>
            <div class='card'>
                <div class='card-header'>
                    <h4 class='text-center'>View Aside</h4>
                    <a href="addaside.php" class="btn btn-primary float-right">ADD Slide </a>
                </div>
                <div class='card-body'>
                    <table class='table table-responsive table-striped table-bordered'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Aside Image</th>
                                <th>Aside Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if ($num > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['id']) ?></td>
                                    <td><?= htmlspecialchars($row['title']) ?></td>
                                    <td><img src="../images/<?= htmlspecialchars($row['image']) ?>" class='img-thumbnail' height='50px' width='50px'></td>
                                    <td>
                                        <div class='product-description' id='desc-<?= $row['id'] ?>'><?= htmlspecialchars($row['des']) ?></div>
                                        <button class='btn btn-info btn-sm mt-2' onclick='toggleDescription(<?= $row['id'] ?>)'>Show Description</button>
                                    </td>
                                    <td>
                                        <a href='editaside.php?id=<?= $row['id'] ?>' class='badge bg-primary'>Edit</a>
                                        <a href='deleteaside.php?id=<?= $row['id'] ?>' class='badge bg-danger'>Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan='5' class='text-center'>No records found</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleDescription(productId) {
        var description = document.getElementById('desc-' + productId);
        var button = description.nextElementSibling;

        if (description.style.whiteSpace === 'nowrap') {
            description.style.whiteSpace = 'normal';
            button.innerText = 'Hide Description';
        } else {
            description.style.whiteSpace = 'nowrap';
            button.innerText = 'Show Description';
        }
    }
</script>

</body>
</html>
<?php
// Close the MySQLi connection
$conn->close();
?>

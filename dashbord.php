<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
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
    <div class="dashboard-container">
        <aside class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Users</a></li>
                <li><a href="#">Reports</a></li>
                <li><a href="#">Analytics</a></li>
            </ul>
        </aside>
        <main class="main-content">
            <header>
                <h1>Dashboard Overview</h1>
            </header>
            <section class="cards">
                <div class="card">Total Users: 1500</div>
                <div class="card">New Orders: 230</div>
                <div class="card">Revenue: $5,000</div>
                <div class="card">Feedback: 120</div>
                <div class="card">Active Sessions: 320</div>
                <div class="card">Pending Requests: 85</div>
                <div class="card">New Signups: 45</div>
                <div class="card">Support Tickets: 60</div>
            </section>
            <section class="charts">
                <h2>Performance Metrics</h2>
                <div class="chart">Chart Placeholder 1</div>
                <div class="chart">Chart Placeholder 2</div>
            </section>
        </main>
    </div>
</body>
</html>

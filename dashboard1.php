<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'fb');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$searchQuery = '';
if (!empty($search)) {
    $searchQuery = " WHERE firstName LIKE '%" . $conn->real_escape_string($search) . "%' OR lastName LIKE '%" . $conn->real_escape_string($search) . "%' OR address LIKE '%" . $conn->real_escape_string($search) . "%' OR rating LIKE '%" . $conn->real_escape_string($search) . "%'";
}

$sql = "SELECT firstName, lastName, address, rating FROM fb" . $searchQuery;
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: #333;
            overflow: hidden;
        }
        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a {
            color: #f2f2f2;
            padding: 14px 20px;
            text-decoration: none;
            display: block;
        }
        .navbar .navbar-brand {
            font-size: 24px;
        }
        .navbar .navbar-menu {
            display: flex;
            gap: 10px;
        }
        .search-form {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }
        .search-form input[type="text"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 10px;
        }
        .search-form button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .search-form button:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            background-color: #333;
            color: #f2f2f2;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="index.html" class="navbar-brand">CRM</a>
            <div class="navbar-menu">
            <a href="#" class="navbar-brand" style="color: white;">CRM</a>
            <div class="navbar-menu">
                <a href="index.html">Home</a>
                <a href="choice.html">Service Request</a>
                <a href="login.php">Login!</a>
                <a href="register.php">Register!!</a>
                <a href="view_response.php">Dashboards</a>
            </div>
        </div>
    </nav>

    <main class="main-content">
        <div class="container">
            <h2>Service Requests</h2>
            <div class="search-form">
                <form method="GET" action="dashboard1.php">
                    <input type="text" name="search" placeholder="Search feedback..." value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit">Search</button>
                </form>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Review</th>
                        <th>Service Used</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data)): ?>
                        <?php foreach ($data as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['firstName']); ?></td>
                                <td><?php echo htmlspecialchars($row['lastName']); ?></td>
                                <td><?php echo htmlspecialchars($row['address']); ?></td>
                                <td><?php echo htmlspecialchars($row['rating']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No data available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 CRM. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>

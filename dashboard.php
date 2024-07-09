<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'customers');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$sql = "SELECT firstName, lastName, address, email, requesttype FROM customers";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "0 results";
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
</head>
<body>
    <nav class="navbar">
        <div class="container">
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
            <br><br>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th style="border: 1px solid #ddd; padding: 8px;">First Name</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Last Name</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Address</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Email</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Request Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data)): ?>
                        <?php foreach ($data as $row): ?>
                            <tr>
                                <td style="border: 1px solid #ddd; padding: 8px;"><?php echo htmlspecialchars($row['firstName']); ?></td>
                                <td style="border: 1px solid #ddd; padding: 8px;"><?php echo htmlspecialchars($row['lastName']); ?></td>
                                <td style="border: 1px solid #ddd; padding: 8px;"><?php echo htmlspecialchars($row['address']); ?></td>
                                <td style="border: 1px solid #ddd; padding: 8px;"><?php echo htmlspecialchars($row['email']); ?></td>
                                <td style="border: 1px solid #ddd; padding: 8px;"><?php echo htmlspecialchars($row['requesttype']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td style="border: 1px solid #ddd; padding: 8px;" colspan="5">No data available</td>
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

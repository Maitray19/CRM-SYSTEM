
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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap");
      @import url("https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap");
      body {
        margin: 0;
        padding: 0;
        font-family: "nunito", sans-serif;
        font-size: 16px;
        color: black;
      }
      #sidebar {
        display: block;
        width: 150px;
        height: 100%;
        position: fixed;
        padding: 5px;
        background-color: rgb(245, 245, 245);
      }
      #sidenav {
        display: block;
        width: 90%;
        margin: auto;
        margin-top: 30px;
      }
      .sidenavbtn {
        display: block;
        width: 90%;
        margin: auto;
        padding: 10px;
        text-decoration: none;
        font-size: 18px;
        font-weight: 500;
        color: black;
        border-radius: 10px;
      }
      .sidenavbtn:hover {
        background-color: #0325bd;
        color: white;
      }
      #mainarea {
        display: block;
        margin-left: 170px;
        padding: 20px;
      }
      #header {
        text-align: center;
        margin-top: 150px;
      }
      #header h1 {
        font-size: 2rem;
        margin-bottom: 10px;
        margin-top: 50px;
      }
      #header button {
        background-color: #333;
        color: white;
        border: none;
        padding: 15px 30px;
        font-size: 1.2rem;
        font-weight: bold;
        border-radius: 50px;
        margin-top: 50px;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
      }
      footer {
        display: block;
        width: calc(100% - 170px);
        margin-left: 170px;
        padding: 10px 0;
        background-color: rgb(229, 228, 253);
        text-align: center;
        position: fixed;
        bottom: 0;
      }
      footer p {
        margin: 0;
        padding: 0;
        font-size: 16px;
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
    </style>
  </head>
  <body>
    <div id="sidebar">
      <div id="sidenav">
        <a href="index.html" class="sidenavbtn">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
            <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293z"/>
          </svg>
          Dashboard
        </a>
        <a href="index.html" class="sidenavbtn">Home</a>
        <a href="choice.html" class="sidenavbtn">Services!</a>
        <a href="login.php" class="sidenavbtn">Login!</a>
        <a href="register.php" class="sidenavbtn">Register!!</a>
        <a href="view_response.php" class="sidenavbtn">Dashboards</a>
      </div>
    </div>
    <div id="mainarea">
      <div id="header">
        
      </div>
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
    </div>
    <footer class="footer">
      <div class="container">
        <p>&copy; 2024 CRM. All rights reserved.</p>
      </div>
    </footer>
  </body>
</html>
```
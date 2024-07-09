<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            // Successful registration, redirect to login page
            header("Location: login.php?message=thanks for registering please login again");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home Page</title>
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
      #sidenavlogo {
        display: block;
        width: 100px;
        margin: auto;
        padding: 0px;
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
     #username{
      width: 20%;
      padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
     } 
     #password{
      width: 20%;
      padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
     }
     #submit{
      width: 20%;
    background-color: #000000   ;
    color: white;
    padding: 12px 30px;
    margin: 12px;
    margin-left: 80px;
    border: none;
     border-radius: 4px;
    cursor: pointer;

     }
     #submit:hover {
    background-color: #013220;
  }
  #tap{
    margin-left: 60px;
  }

    </style>
  </head>
  <body>
    
    <div id="sidebar">
      <div id="sidenavheader">
        <img
          src="data:image/png;base64,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"
          alt=""
          id="sidenavlogo"
        />
      </div>
      <div id="sidenav">
        <a href="index.html" class="sidenavbtn">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
            <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293z"/>
          </svg>
          Home
        </a>
        <a href="choice.html" class="sidenavbtn">Services!</a>
        <a href="login.php" class="sidenavbtn">Login!</a>
        <a href="register.php" class="sidenavbtn">Register!!</a>
        <a href="view_response.php" class="sidenavbtn">Dashboards</a>
      </div>
    </div>
    <div id="mainarea">
      <div id="header">
        <main class="main-content">
          <div class="form-container">
              <h2>Register</h2>
              <form method="POST" action="register.php">
                  <div class="input-group">
                      <label for="username">Username</label>
                      <input type="text" id="username" name="username" required>
                  </div>
                  <div class="input-group">
                      <label for="password">Password</label>
                      <input type="password" id="password" name="password" required>
                  </div>
                  <div class="input-group">
                      <input type="submit" value="Register" class="btn" id="submit">
                      <br>
                      <a href="login.php" class="btn-secondary" id="tap">Already a member? Login</a>
                  </div>
              </form>
          </div>
      </main>
  
      </div>
    </div>
    <footer class="footer">
      <div class="container">
        <p>&copy; 2024 CRM. All rights reserved.</p>
      </div>
    </footer>
  </body>
</html>


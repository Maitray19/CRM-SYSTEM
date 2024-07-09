<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $requesttype = isset($_POST['requesttype']) ? $_POST['requesttype'] : '';

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'customers');
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    } else {
        $stmt = $conn->prepare("INSERT INTO customers (firstName, lastName, address, email, requesttype) VALUES (?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sssss", $firstName, $lastName, $address, $email, $requesttype);

        $execval = $stmt->execute();
        if ($execval) {
            echo "
                <div style='text-align: center; margin-top: 50px; font-family: Arial, sans-serif;'>
                    <p>We would appreciate your feedback for this :)</p>
                    <a href='feedback.html' style='display: inline-block; margin: 10px; padding: 10px 20px; background-color: rosybrown; color: white; text-decoration: none; border-radius: 5px;'>Submit Feedback</a>
                    <a href='index.html' style='display: inline-block; margin: 10px; padding: 10px 20px; background-color: rosybrown; color: white; text-decoration: none; border-radius: 5px;'>Return to Home Page</a>
                    <p style='margin-top: 20px;'>Thank you!!</p>
                </div>
            ";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
} else {
    echo "No form data submitted.";
}
?>

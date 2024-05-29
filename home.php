<?php

include "conn.php"; // Include the database connection file

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve user from the database
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Set session variables
        $_SESSION['username'] = $username;
        $_SESSION['user_type'] = $row['user_type'];

        // Redirect based on user type
        if ($row['user_type'] == 'admin') {
            header("Location: /jemzxc_shop/home.php");
            exit();
        } else {
            header("Location: /jemzxc_shop/user.php");
            exit();
        }
    } else {
        // User not found, set error message
        $_SESSION['error'] = "Invalid username or password.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JemzxcShop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"> <!-- Bootstrap -->
    <!-- Add the Bootstrap JavaScript to close the error message -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" /> <!-- Includes Font Awesome for icons -->
</head>

<body>
    <div class="container-fluid mx-2 mt-5">
        <?php
        if (isset($_SESSION['username']) && isset($_SESSION['user_type'])) {
            $username = $_SESSION['username'];
            $user_type = $_SESSION['user_type'];

            // Create connection
            $connection = new mysqli("localhost", "root", "", "jemzxc_shop");

            // Check connection
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }

            // Fetch user details from the database
            $sql = "SELECT username FROM users WHERE username = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row) {
                $username_from_db = $row['username'];
            } else {
                $username_from_db = "Guest"; // Default username if no user found in the database
            }

            // Define welcome message based on user type
            $welcome_message = "Welcome, " . ucfirst($username); //ucfirst is a fuction to capitalize first letter
            echo "<h2>$welcome_message</h2>";
        
            // Close the database connection
            $stmt->close();
            $connection->close();
        } else {
            echo "<h2>Welcome, Guest</h2>";
        }
        ?>

        <h2>List of Clients</h2>
        <!-- Will lead to create.php file -->

        <?php
        // Only allow admin to add new client
        if ($user_type == 'admin') {
                echo "<a class='btn btn-success' href='/jemzxc_shop/create.php' role='button'><i class='fa-solid fa-plus'></i> Add New Client</a>";
            }

    
        ?>

        <br><br>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>EMAIL</th>
                    <th>PHONE</th>
                    <th>ADDRESS</th>
                    <th>CREATED AT</th>
                    <th>Rank</th>
                    <th>Fee</th>
                    <th>Qualification</th>
                    <th>ACTION</th>
                </tr>
            </thead>

            <tbody>
                <?php
                // Create connection
                $connection = new mysqli("localhost", "root", "", "jemzxc_shop");

                // Check connection
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                // Create SQL query to read all the data from the database table
                $sql = "SELECT * FROM clients INNER JOIN clientranks ON clients.client_rank = clientranks.client_rank";
                $result = $connection->query($sql);

                if (!$result) {
                    die("Invalid query: " . $connection->error);
                }

                // Read the data row by row from the table
                while ($row = $result->fetch_assoc()) {
                    echo "
                        <tr>
                            <td>$row[id]</td>
                            <td>$row[name]</td>
                            <td>$row[email]</td>
                            <td>$row[phone]</td>
                            <td>$row[address]</td>
                            <td>$row[created_at]</td>
                            <td>$row[client_rank]</td>
                            <td>$row[fee]</td>
                            <td>$row[qualification]</td>
                            <td>
                                <a class='btn btn-primary btn-sm' href='/jemzxc_shop/edit.php?id=$row[id]'><i class='fas fa-edit'></i> EDIT</a>
                                <a class='btn btn-danger btn-sm' href='/jemzxc_shop/delete.php?id=$row[id]'><i class='fas fa-trash'></i> DELETE</a>
                            </td>
                        </tr>       
                    ";
                }
                // Close the database connection
                $connection->close();
                ?>       
            </tbody>
        </table>

        <a class="btn btn-danger" href="/jemzxc_shop/logout.php" role="button"><i class="fa-solid fa-right-from-bracket"></i> Logout</a> 
    </div>
</body>
</html>

<style>
    body{
        background: url(imglogo2.png);
        background-size:cover;
    }
</style>

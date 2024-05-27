

<!-- just a complete copy of the home.php without the privilege of the user to update or delete-->

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
    <div class="container my-5">

    <?php
            // Assuming you have a variable $user_type that stores the user's type
            // Define welcome message based on user type
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "jemzxc_shop";

            // Create connections 
            $connection = new mysqli($servername, $username, $password, $database);

            // Check connections
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }   

            // Fetch username from the database
            $sql_username = "SELECT username FROM users WHERE id > 1"; // Adjust query according to your database structure
            $result_username = $connection->query($sql_username);

            if ($result_username->num_rows > 0) {
                // Output data of each row
                $row = $result_username->fetch_assoc();
                $username_from_db = $row["username"];
            } else {
                $username_from_db = "Guest"; // Default username if no user found in the database
            }

            // Define welcome message based on username from the database
            $user_type = "Welcome: " . $username_from_db; // Concatenate username with welcome message
            // Display the welcome message
            echo "<h2>$user_type</h2>";

            // Close the database connection
            $connection->close();
    ?>


        <h2>List of Clients</h2>
        <!-- Link to logout -->
        <a class ="btn btn-secondary" href="/jemzxc_shop/index.php" role = "button"><i class="fa-solid fa-right-from-bracket"></i> Logout</a> 
        <br>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>EMAIL</th>
                    <th>PHONE</th>
                    <th>ADDRESS</th>
                    <th>CREATED AT</th>
                </tr>
            </thead>

            <tbody>
                <!-- PHP to DATABASE -->
                <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $database = "jemzxc_shop";

                    // Create connection
                    $connection = new mysqli($servername, $username, $password, $database);

                    // Check connection
                    if ($connection->connect_error){
                        die ("Connection failed: " . $connection->connect_error);
                    }

                    // Create SQL query to read all the data from the database table
                    $sql = "SELECT * FROM clients";
                    $result = $connection->query($sql);

                    if(!$result){ // If there's an error in the query, display error message
                        die("Invalid query: " . $connection->error);
                    }

                    // Read the data from each row of the table
                    while ($row = $result->fetch_assoc()){
                        // Display each row of data
                        echo "
                            <tr>
                                <td>$row[id]</td>
                                <td>$row[name]</td>
                                <td>$row[email]</td>
                                <td>$row[phone]</td>
                                <td>$row[address]</td>
                                <td>$row[created_at]</td>
                            </tr>
                        ";
                    }

                    // Close the database connection
                    $connection->close();
                ?> 
                <!-- END OF PHP -->
            </tbody>
        </table>
    
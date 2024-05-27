
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JemzxcShop</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"> <!-- bootstrap -->
<!-- add the bootstrap javascript to close the error message -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" /> <!-- Includes Font Awesome for icons -->
</head>

<body>
    <div class =  "container-fluid mx-2 mt-5">

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
            $sql_username = "SELECT username FROM users LIMIT 1";
            
            //Fetch fee through clients

            
            
            // Adjust query according to your database structure
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
        <!-- will lead to create.php file -->
        <a class ="btn btn-primary" href="/jemzxc_shop/create.php" role = "button"><i class="fa-solid fa-plus"></i> Add New Client</a> 
        <a class ="btn btn-secondary" href="/jemzxc_shop/index.php" role = "button"><i class="fa-solid fa-right-from-bracket"></i> Logout</a> 
        <br>

        <table class= "table">
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


                <!-- PHP to DATABASE -->
                <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $database = "jemzxc_shop";

                //create connections 
                $connection = new mysqli($servername,$username,$password,$database);

                //check connections
                if ($connection->connect_error){
                    die ("connection failes: ".$connection->connect_error);
                }   
                // create sql query to read all the data from the database table 
                $sql = "SELECT * FROM clients INNER JOIN clientranks on clients.client_rank = clientranks.client_rank";
                $result = $connection->query($sql);

                    if(!$result){ //ug naay sayop sa pag query mao ni mo message
                        die("Invalid query: ".$connection->error);
                    }

                //read the data kada row from table
                while ($row = $result->fetch_assoc()){
                    // i echo para ma print tagsa tagsa ang mga data one at a time 
                    //gi balhin ang html code nga tr, isulod sa echo then tawgon ang column name
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
                            <a class='btn btn-primary btn-sm' href='/jemzxc_shop/delete.php?id=$row[id]'><i class='fas fa-trash'></i> DELETE</a>
                            </td>
                            
                        </tr>
                    ";
                }

                ?> 

                <!-- END OF PHP -->


                <!-- <tr>
                    <td>10</td>
                    <td>Bill Gates</td>
                    <td>billgates@microsoft.com</td>
                    <td>09123445677</td>
                    <td>New York</td>
                    <td>18/05/2022</td>
                    <td>
                            <a class= 'btn btn-primary btn-sm' href="/jemzxc_shop/edit.php">EDIT</a>
                            <a class='btn btn-primary btn-sm' href="/jemzxc_shop/delete.php">DELETE</a>
                    </td>
                </tr> --> 
        </tbody>





    </div>
</body>
</html>
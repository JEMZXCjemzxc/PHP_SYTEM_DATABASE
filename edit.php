<?php
// connect to the database
include "conn.php";

//initializing variables
$id ="";
$name = "";    
$email = ""; 
$phone = "";  
$address = "";
$client_rank = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // GET method: SHOW DATA OF THE CLIENTS
    
    if (!isset($_GET["id"])){ // if the id of client does not exist, re direct the user to home 
        header("location: /jemzxc_shop/home.php");
        exit; // and exit 
    }
        $id = $_GET["id"];
    //READ the row of the selected client from the database table 
    //It uses the INNER JOIN clause to combine rows from both tables where the client_rank column in the
    // clients table matches the client_rank column in the client_ranks table.
    $sql = "SELECT * FROM clients INNER JOIN clientranks on clients.client_rank = clientranks.client_rank WHERE id= $id ";
    $result = $conn->query($sql); // execute the query
    $row = $result->fetch_assoc(); // read the data of the client from the database

    if(!$row){ // if no data is read from the database it will redirect the user to the home.php
        header("location: /jemzxc_shop/home.php");
        exit;
    }
    // else if walay error ma read ang data and ma store sa mga variables 
    $name = $row["name"]; 
    $email = $row["email"]; 
    $phone = $row["phone"];  
    $address = $row["address"];
    $client_rank = $row["client_rank"];

}
else {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $client_rank = $_POST["client_rank"];


    do {
        if (empty($id) || empty($name) || empty($email) || empty($phone) || empty($address)) {
            $errorMessage = "All fields are required";
            break;
        } 

        $sql = "UPDATE clients SET name = '$name', email = '$email', phone = '$phone', address = '$address', client_rank = '$client_rank' WHERE id = $id ";
        $result = $conn->query($sql); // execute the above sql query


        if(!$result){ // if we have and error in executing the query this is the error message
            $errorMessage = "Invalid Query: " .$connection->error;
            break;
        }

        // check if the email contains an "@" symbol
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = "Invalid email address please put @";
            break;
        }

        // check for duplicate email, excluding the current record
        $checkEmailSql = "SELECT id FROM clients WHERE email = '$email' AND id != $id ";
        $checkEmailResult = $conn->query($checkEmailSql);

        
        //If num_rows is greater than 0, it means there is at least one record in the database with the same email address.
        if ($checkEmailResult->num_rows > 0) { 
            $errorMessage = "This email is already in use";
            break;
        }

        //else 
        $successMessage = "Client updated!";
        
        header("location: /jemzxc_shop/home.php"); // and if success, redirect the user to home.php
        exit(); // and exit the edit.php

    } while(false);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jemzxc_shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"> <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmF/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" /> <!-- Includes Font Awesome for icons -->
</head>
<body>
    <div class="container my-5">
        <h2>Edit Client</h2>

        <!-- DISPLAY THE ERROR MESSAGE IF THE ERROR MESSAGE IS NOT EMPTY-->
        <?php
        if (!empty($errorMessage)) {
            echo "
                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>$errorMessage</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
            ";
        }
        ?>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>"> <!-- hidden input that store id of client -->
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">NAME</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">EMAIL</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">PHONE NUMBER</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>">
                </div>
            </div>
            
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">ADDRESS</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo $address; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Client Rank</label>
                <div class="col-sm-6">
                    <select class="form-control" name="client_rank">
                        <option value="A" <?php if ($client_rank == 'A') echo 'selected'; ?>>A</option>
                        <option value="B" <?php if ($client_rank == 'B') echo 'selected'; ?>>B</option>
                        <option value="C" <?php if ($client_rank == 'C') echo 'selected'; ?>>C</option>
                    </select>
                </div>
            </div>

            <!-- DISPLAY THE SUCCESS MESSAGE IF THE $successMessage VARIABLE IS NOT EMPTY -->
            <?php
            if (!empty($successMessage)) {
                echo "
                    <div class='row mb-3'>
                        <div class='offset-sm col-sm-6'>
                            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                <strong>$successMessage</strong>
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>
                        </div>
                    </div>
                ";
            }
            ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary"><i class="fa-regular fa-pen-to-square"></i> SUBMIT</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-danger" href="/jemzxc_shop/home.php" role="button"><i class="fa-solid fa-ban"></i> CANCEL</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

<style>
    body{
        background: url(imglogo2.png);
        background-size:cover;
    }

    *{
        font-weight: bold;
    }
</style>


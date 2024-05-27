<?php

include "conn.php"; //gi sud ang connection sa isa ka folder para tawgon ra
$client_rank = ""; // Initialize the variable


// check if the data is transmitted using post method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $client_rank = $_POST["client_rank"];

    // check if there is an empty field 
    do {
        if (empty($name) || empty($email) || empty($phone) || empty($address)) {
            $errorMessage = "All fields are required"; //ma store sa errormessage nga variable if naay error
            break;
        }

        // check if the email contains an "@" symbol
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = "Invalid email";
            break;
        }

        // check for duplicate email
        $checkEmailSql = "SELECT id FROM clients WHERE email = '$email'";
        $checkEmailResult = $conn->query($checkEmailSql);


        //If num_rows is greater than 0, it means there is at least one record in the database with the same email address.
        if ($checkEmailResult->num_rows > 0) { 
            $errorMessage = "This email is already in use";
            break;
        }


        // add or insert the new client into the database 
        //initialize the variables
        $sql = "INSERT INTO clients (name, email, phone, address, client_rank) VALUES ('$name', '$email', '$phone', '$address','$client_rank')";
        $result = $conn->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $conn->error;
            break;
        }

        $name = "";    // after successfully adding the client it will 
        $email = "";   // reset the values of these variables to empty values
        $phone = "";
        $address = "";
        $client_rank = "";

        $successMessage = "Client added";

        header("Location: /jemzxc_shop/home.php");
        exit;

    } while (false);
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
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" /> <!-- Includes Font Awesome for icons -->
</head>
<body>
    <div class="container my-5">
        <h2>Add New Client</h2>

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
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">NAME</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">EMAIL</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">PHONE NUMBER</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="phone">
                </div>
            </div>
            
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">ADDRESS</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address">
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
                <a class="btn btn-outline-primary" href="/jemzxc_shop/home.php" role="button"><i class="fa-solid fa-ban"></i> CANCEL</a>                </div>
            </div>
        </form>
    </div>
</body>
</html>

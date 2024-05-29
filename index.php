<?php

include "conn.php"; // Include the database connection file

// Check if the user is already logged in
if (isset($_SESSION['username']) && isset($_SESSION['user_type'])) {
    // Redirect to the home page based on user type
    header("Location: /jemzxc_shop/home.php");
    exit();
}

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
            $_SESSION['user_type'] = $row['user_type'];
            exit();
        } else {
            header("Location: /jemzxc_shop/home.php");
            exit();
        }
    } else {
        // User not found, set error message
        $_SESSION['error'] = "Invalid username or password.";
    }
}
?>






<!-- HTML CODE BELOW -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" /> <!-- Includes Font Awesome for icons -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
   
    <style>
        
        body {
            background: url(bg1.jpg);
            background-size:cover;
            display: flex;
            height: 100vh;
            align-items: center; /* Center vertically */
            justify-content: center; /* Center horizontally */
        }
        
        .card {
            padding: 20px;
            border-radius: 10px;
            background-color: #ffffff; /* White background for the card */
        }
        .card-header, .card-body, .card-footer {
            padding: 10px;
        }
        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .card-footer {
            text-align: center;
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-primary {
            width: 100%;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0069d9; /* Change the background color on hover */
        }
        .form-control,
        .btn-primary {
            transition: box-shadow 0.3s ease;
        }
        .form-control:hover,
        .btn-primary:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add box shadow on hover */
        }
        .login-img {
            width: 300px /* Adjust the width as needed */
            height: 500px;
            max-width: 100%;
        }
        *{
            color: black;
        }
    </style>

</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header text-center">
                        LOGIN FORM
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="imglogo.png" alt="Image" class="login-img mb-3">
                            </div>
                            <div class="col-md-6">
                                <?php
                                if (isset($_SESSION['error'])) {
                                    echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
                                    unset($_SESSION['error']);
                                }
                                ?>
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="username"><i class="fa-regular fa-user"></i> Username</label>
                                        <input type="text" id="username" class="form-control" name="username" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="password"><i class="fa-solid fa-lock"></i> Password</label>
                                        <div class="input-group">
                                            <input type="password" id="password" class="form-control" name="password" required />
                                        </div>
                                        
                                        <div class="form-check mt-2">
                                            <input type="checkbox" id="showPassword" class="form-check-input" aria-label="Show password">
                                            <label for="showPassword" class="form-check-label">
                                                Show password
                                            </label>
                                        </div>
                                    </div>
                                    <br>
                                    <input type="submit" class="btn btn-primary" name="login" value="LOGIN">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <small>&copy; need help?</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const showPasswordCheckbox = document.getElementById('showPassword'); // showPassword is from the input type checkbox id
        const passwordInput = document.getElementById('password');

        showPasswordCheckbox.addEventListener('change', function() {
            passwordInput.type = this.checked ? 'text' : 'password';
        });
    </script>
</body>
</html>

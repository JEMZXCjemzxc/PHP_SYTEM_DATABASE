<?php   
include "conn.php"; // Include the database connection file


if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve user from the database
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql); //run the database and store it in the $result variable

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Check if the user is an admin
        if ($row['user_type'] == 'admin') {
            // User is an admin, set session and redirect
            $_SESSION['username'] = $username;
            $_SESSION['user_type'] = 'admin';
            header("Location: /jemzxc_shop/home.php");
            exit();
        } else {
            // User is not an admin, set session and redirect
            $_SESSION['username'] = $username;
            $_SESSION['user_type'] = 'user';
            header("Location: /jemzxc_shop/user.php");
            exit();
        }
    } 

    else {
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
    <title>LOGIN</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" /> <!-- Includes Font Awesome for icons -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
   
   <style>
        .card {
            padding: 20px;
        }
        .card-header, .card-body, .card-footer {
            padding: 5px;
        }
    </style>


</head>
<body>
    <div class="container vh-100">
        <div class="row justify-content-center h-100">
            <div class="card w-25 m-auto shadow">
                <div class="card-header text-center">
                    LOGIN FORM
                </div>
                <div class="card-body">
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
                            
                            <div class="input-group-append">    
                                <label for="showPassword">
                                    <input type="checkbox" id="showPassword" aria-label="Show password">    
                                    Show password
                                </label>
                            </div>
                        </div>
                        <br>
                        <input type="submit" class="btn btn-primary" name="login" value="LOGIN">
                    </form>
                </div>
                <div class="card-footer">
                    <small>&copy; need help?</small>
                </div>
            </div>
        </div>
    </div>

    <script>
        const showPasswordCheckbox = document.getElementById('showPassword');//showPassword is from the input type checkbox id
        const passwordInput = document.getElementById('password');

        showPasswordCheckbox.addEventListener('change', function() {
            passwordInput.type = this.checked ? 'text' : 'password';
        });
    </script>
</body>
</html>

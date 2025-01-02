<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Rotaract - Login Form Template</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="Login Form Template" name="keywords">
        <meta content="Login Form Template" name="description">

        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        <!-- Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <div class="wrapper login-1">
            <div class="container">
                <div class="col-left">
                    <div class="login-text">
                        <h2>Welcome </h2>
                        <p>Create your account.<br>Be a Rotaract.</p>
                        <a class="btn" href="signup.php">Sign Up</a>
                    </div>
                </div>
                <div class="col-right">
                    <div class="login-form">
                        <h2>Login</h2>
                        <form>
                            <p>
                                <label>Username or email address<span>*</span></label>
                                <input type="text" placeholder="Username or Email" required>
                            </p>
                            <p>
                                <label>Password<span>*</span></label>
                                <input type="password" placeholder="Password" required>
</div>
            <button type="submit" class="btn btn-primary w-100" name="submit">Login</button>
            <div class="text-center mt-3">
                <a href="#" class="text-decoration-none">Forgot password?</a>
            </div>
                                <input type="submit" value="Login" />
                            </p>
                            <p>
                                <a href="">Forget Password?</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
            <div class="credit">
                <!-- Template by <a href="https://htmlcodex.com">HTML Codex</a> -->
            </div>
        </div>
    </body>
</html>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])){
    include "mysql_connector.php";

    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashed_password = hash("sha256", $password);

    $sql = "SELECT user_id,username,email,user_role FROM users WHERE email='$email' AND password='$hashed_password'";
    if($conn->query($sql)->num_rows > 0){
        $userdata=$conn->query($sql)->fetch_assoc();
        switch($userdata['user_role']){
            case "admin":
                setcookie("userId",$userdata['user_id'],time()+60*60*24*1);
                setcookie("username",$userdata['username'],time()+60*60*24*1);
                setcookie("useremail",$userdata['email'],time()+60*60*24*1);   
                
                echo "<script>alert('Logged in successfully!');</script>";
                echo "<script>window.location.href = 'adminHomepage.php'</script>";
                break;
            default:
                
                setcookie("userId",$userdata['user_id'],time()+60*60*24*1);
                setcookie("username",$userdata['username'],time()+60*60*24*1);
                setcookie("useremail",$userdata['email'],time()+60*60*24*1);    

                echo "<script>alert('Logged in successfully!');</script>";
                echo "<script>window.location.href = 'homepage.php'</script>";
                break;

        }
        
        
    } else {
        echo "<script>alert('Login failed, please try again.');</script>";
    }
}
?>

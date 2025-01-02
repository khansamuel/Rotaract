<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap 5 Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">

    <div class="card shadow-sm p-4 rounded-3" style="max-width: 400px; width: 100%;">
        <h3 class="text-center mb-4">Login</h3>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100" name="submit">Login</button>
            <div class="text-center mt-3">
                <a href="#" class="text-decoration-none">Forgot password?</a>
            </div>
            <div class="text-center mt-3">
                <small>Don't have an account? <a href="signup.php" class="text-primary">Sign up</a></small>
            </div>
        </form>
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

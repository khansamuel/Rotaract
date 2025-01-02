<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap 5 Sign Up Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styling */
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .signup-card {
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 400px;
            width: 100%;
        }
        .signup-btn {
            background-color: #0d6efd;
            border: none;
        }
        .signup-btn:hover {
            background-color: #0b5ed7;
        }
        .error {
            color: red;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <div class="signup-card bg-white">
        <h3 class="text-center mb-4">Sign Up</h3>
        <form id="signupForm" onsubmit="return validateForm()" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                <small id="emailError" class="error"></small>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                <small id="passwordError" class="error"></small>
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm your password" required>
            </div>
            <input type="submit" class="btn signup-btn w-100" name="submit" value="Sign Up">
            <div class="text-center mt-3">
                <small>Already have an account? <a href="login.php">Log in</a></small>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validateForm() {
            let isValid = true;

            // Email validation
            const email = document.getElementById('email').value;
            const emailError = document.getElementById('emailError');
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Basic email format regex
            if (!emailPattern.test(email)) {
                emailError.textContent = "Please enter a valid email address.";
                isValid = false;
            } else {
                emailError.textContent = "";
            }

            // Password validation
            const password = document.getElementById('password').value;
            const passwordError = document.getElementById('passwordError');
            const strongPasswordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/; // At least 8 characters, one uppercase, one lowercase, one number, one special character
            if (!strongPasswordPattern.test(password)) {
                passwordError.textContent = "Password must be at least 8 characters long, include an uppercase letter, a lowercase letter, a number, and a special character.";
                isValid = false;
            } else {
                passwordError.textContent = "";
            }

            // Confirm password validation
            const confirmPassword = document.getElementById('confirmPassword').value;
            if (password !== confirmPassword) {
                alert("Passwords do not match!");
                isValid = false;
            }

            return isValid;
        }
    </script>
</body>
</html>
<?php
include "mysql_connector.php";
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hashing the password happens here
    $hashed_password = hash("sha256", $password);

    $sql = "SELECT * FROM users WHERE email ='$email'";

    if ($conn->query($sql)->num_rows > 0) {
        echo "<script>alert('Account exists')</script>";
    } else {
        $sql = "INSERT INTO users(username,email,password) VALUES('$username','$email','$hashed_password')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Account was created successfully')</script>";
        } else {
            echo "<script>alert('Error creating account: " . $conn->error . "')</script>";
        }
    }
}
?>

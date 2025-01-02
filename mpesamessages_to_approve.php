<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mpesa Codes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
        }
        .navbar {
            background-color: #007bff; /* Bootstrap primary color */
        }
        .navbar-brand, .nav-link {
            color: #ffffff !important; /* White text */
        }
        .nav-link:hover {
            color: #f90f67 !important; /* Gold on hover */
            background-color: rgba(255, 255, 255, 0.2); /* Slight background change */
        }
        .container {
            margin-top: 20px;
        }
        .card {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Hello 
    <?php 
  if (isset($_COOKIE['username'])) {
      echo htmlspecialchars($_COOKIE['username']);
  } else {
      echo "Guest";
  }
  ?> !!</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-item nav-link active" href="homepage.php">Home <span class="visually-hidden">(current)</span></a>
        <a class="nav-item nav-link" href="messages.php">Messages</a>
        <!-- <a class="nav-item nav-link" href="contributions.php">Contributions</a> -->
        <a class="nav-item nav-link" href="contribution_history.php">Contribution History</a>
      </div>
    </div>
  </div>
</nav>
<div class="container mt-4">
<?php
include "mysql_connector.php";
include "payment_updater.php";
// Check if the status update form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['code_id'])) {
    $code_id = $_POST['code_id'];
    $email = $_POST['user_email'];
    $contributionname = $_POST['contribution_name'];
    $amount_paid = $_POST['amount_paid'];

    $update_sql = "UPDATE mpesa_codes SET contribution_status = 'paid' WHERE code_id = $code_id";
    $conn->query($update_sql);
    echo "<div class='alert alert-success text-center'>Contribution status updated to paid.</div>";

    // Get contribution type Id
    function contribution_type_id_funcc($contributionname){
        global $conn;
        $sql="SELECT type_id,contribution_name FROM contribution_type WHERE contribution_name='$contributionname'";
        $row=$conn->query($sql)->fetch_assoc();

        $contributionname=$row['type_id'];
        return $contributionname;
    }

    $contributionnam=contribution_type_id_funcc($contributionname);

    payment_function($email, $contributionnam, $amount_paid);
}

$sql = "SELECT code_id, mpesa_code, member_paid, contribution_name, contributor_email, amount_paid, contribution_status FROM mpesa_codes";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "
        <div class='card'>
          <div class='card-body'>
            <h5 class='card-title'>Mpesa Code: ".$row['mpesa_code']."</h5>
            <p class='card-text'>
              Contribution Name: ".$row['contribution_name']."<br>
              Contributor Email: ".$row['contributor_email']."<br>
              Amount Paid: ".$row['amount_paid']."<br>
              Contribution Status: ".$row['contribution_status']." 
            </p>";
        if (empty($row['contribution_status'])) {
            echo "
            <form method='post'>
              <input type='hidden' name='contribution_name' value='".$row['contribution_name']."'>
              <input type='hidden' name='code_id' value='".$row['code_id']."'>
              <input type='hidden' name='amount_paid' value='".$row['amount_paid']."'>
              <input type='hidden' name='user_email' value='".$row['contributor_email']."'>
              <button type='submit' class='btn btn-primary'>Mark as Paid</button>
            </form>";
        }
        echo "
          </div>
        </div>";
    }
} else {
    echo "
    <div class='alert alert-info text-center'>No Mpesa codes to display</div>";
}

$conn->close();
?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

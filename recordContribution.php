<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contribution Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
            background-image: url("R.png");
            background-size: cover;
            background-repeat: no-repeat;
        }
        .navbar {
            background-color: #007bff; /* Bootstrap primary color */
        }
        .navbar-brand, .nav-link {
            color: #ffffff!important; /* White text */
        }
        .nav-link:hover {
            color: #f90f67 !important; /* Gold on hover */
            background-color: rgba(255, 255, 255, 0.2); /* Slight background change */
        }
        .container {
            margin-top: 20px;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Rotaract</a>
     
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-item nav-link active" href="adminHomepage.php">Home <span class="visually-hidden">(current)</span></a>
        <a class="nav-item nav-link" href="recordContribution.php">Record contributions</a>
        <a class="nav-item nav-link" href="viewMembers.php">View members</a>
        <a class="nav-item nav-link" href="contributionCategory.php">Add contribution category</a>


        <a class="nav-item nav-link" href="contribution_history.php">Contribution History</a>
      </div>
    </div>
  </div>
</nav>

  
<form class="row g-3 needs-validation" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
  <div class="col-md-4">
    <label for="email" class="form-label">User Email</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="Enter the contributor's email" required>
  </div>

  <div class="col-md-4">
    <label for="contribution_type" class="form-label">Contribution Type</label>
    <?php
    include "mysql_connector.php";

    $sql = "SELECT type_id, contribution_name FROM contribution_type";
    $results = $conn->query($sql);

    if ($results->num_rows > 0) {
        echo "<select class='form-select' id='contribution_type' name='contribution_type' required>";
        echo "<option selected disabled>Select Contribution Type</option>";
        while ($row = $results->fetch_assoc()) {
            echo "<option value='{$row['type_id']}'>{$row['contribution_name']}</option>";
        }
        echo "</select>";
    } else {
        echo "<p class='text-danger'>No active contribution!</p>";
    }
    ?>
  </div>

  <div class="col-md-6">
    <label for="amount_to_record" class="form-label">Amount to Record</label>
    <input type="number" class="form-control" id="amount_to_record" name="amount_to_record" required>
  </div>

  <div class="col-12">
    <button class="btn btn-primary" type="submit" name="submit">Record</button>
  </div>
</form>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
    include "mysql_connector.php";
    include "payment_updater.php";

    $email = $_POST['email'];
    $contribution_type = $_POST['contribution_type'];
    $amount_to_record = $_POST['amount_to_record'];

    // calling the payment updater function
    payment_function($email,$contribution_type,$amount_to_record);


   

    
}
?>

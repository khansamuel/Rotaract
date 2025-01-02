<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            color: #ffffff !important; /* White text */
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
</head>
<body>
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Rotaract</a>
    
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-item nav-link active" href="adminHomepage.php">Home <span class="visually-hidden">(current)</span></a>
        <a class="nav-item nav-link" href="recordContribution.php">Record contributions</a>
        <a class="nav-item nav-link" href="viewMembers.php">View members</a>
        <a class="nav-item nav-link" href="contributionCategory.php">Add contribution category</a>


        <a class="nav-item nav-link" href="mpesamessages_to_approve.php">Mpesa Payments</a>
      </div>
    </div>
  </div>
</nav>

<form class="row g-3 needs-validation" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
  <div class="col-md-4 ">
    <label for="validationCustom01" class="form-label " style="color:white;">Contribution Name</label>
    <input type="text" class="form-control" id="contributionname" name="contributionname" value="" required>
    <div class="valid-feedback">
 
    </div>
  </div>
  <div class="col-md-4">
    <label for="validationCustom02" class="form-label">Expirely date</label>
    <input type="date" class="form-control" id="Expirelydate" name="Expirelydate" value="" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
    <div class="valid-feedback">
      Looks good!
    </div>
  </div>
 
  <div class="col-md-6">
    <label for="Ammount to charge" class="form-label">Amount per Member</label>
    <input type="number" class="form-control" id="amount_to_charge" name="amount_to_charge" required>

  </div>
 
  </div>
  <div class="col-12">
    <button class="btn btn-primary" type="submit" name="submit">Submit </button>
  </div>
</form>
</body>
</html>

<?php

include "mysql_connector.php";
if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['submit'])){
    $contributionname=$_POST['contributionname'];
    $Expirelydate=$_POST['Expirelydate'];
    $amount_to_charge=$_POST['amount_to_charge'];

    $sql="INSERT INTO contribution_type(contribution_name,amount_per_member,deadline)
     VALUES('$contributionname','$amount_to_charge','$Expirelydate')";

    if($conn->query($sql)==true){
        echo "<script>alert('New contribution was added successfully')</script>";
    }
    else{
        echo "<script>alert('Failed to add the fields provided')</script>";
    }
}

?>
    
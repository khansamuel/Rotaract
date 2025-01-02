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
      <!-- <span class="navbar-toggler-icon"></span> -->
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

<pre style="color:blue; font-size:50px;">
  

</pre>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

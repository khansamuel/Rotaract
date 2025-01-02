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

<div class="container">
  <table class="table table-striped">
    <thead class="table-light">
      <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Amount To Pay</th>
        <th>Deadline</th>
        <th>Balance</th>
      </tr>
    </thead>
    <tbody>
      <?php
      include "mysql_connector.php";

      $sql = "SELECT users.username, users.email, contribution_type.amount_per_member AS amount_to_pay, 
                     contribution_type.deadline, contributions.balance
              FROM users
              INNER JOIN contributions ON users.user_id = contributions.contributor_id
              INNER JOIN contribution_type ON contributions.contribution_type_id = contribution_type.type_id";

      // Execute the query
      $result = $conn->query($sql);

      // Check if query was successful
      if ($result === false) {
          echo "<tr><td colspan='5'>Error: " . $conn->error . "</td></tr>";
      } else {
          // Check if there are results
          if ($result->num_rows > 0) {
              // Loop through the results and display them
              while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $row['username'] . "</td>";
                  echo "<td>" . $row['email'] . "</td>";
                  echo "<td>" . $row['amount_to_pay'] . "</td>";
                  echo "<td>" . $row['deadline'] . "</td>";
                  echo "<td>" . $row['balance'] . "</td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='5'>No results found</td></tr>";
          }
      }

      // Close the database connection
      $conn->close();
      ?>
    </tbody>
  </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

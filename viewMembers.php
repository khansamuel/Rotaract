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
            color: #ffcc00 !important; /* Gold on hover */
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
<nav class="navbar navbar-expand-lg bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Rotaract</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-item nav-link active" href="homepage.php">Home <span class="visually-hidden">(current)</span></a>
        <a class="nav-item nav-link" href="recordContribution.php">Record contributions</a>
        <a class="nav-item nav-link" href="viewMembers.php">View members</a>
        <a class="nav-item nav-link" href="contributionCategory.php">Add contribution category</a>


        <a class="nav-item nav-link" href="contribution_history.php">Contribution History</a>
      </div>
    </div>
  </div>
</nav>

<table class="table">
  <thead>
    <tr>
      <th scope="col">Username</th>
      <th scope="col">User Email</th>
      <th scope="col">Date Joined</th>
      <th scope="col">Action</th> <!-- Add a column for actions -->
    </tr>
  </thead>
  <tbody>
  <?php
  include "mysql_connector.php";

  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT user_id, username, email, date_joined FROM users";
  $results = $conn->query($sql);

  if ($results === false) {
      echo "<tr><td colspan='4'>Error: " . $conn->error . "</td></tr>";
  } else {
      if ($results->num_rows > 0) {
          while ($row = $results->fetch_assoc()) {
              echo "<tr>
                  <td>{$row['username']}</td>
                  <td>{$row['email']}</td>
                  <td>{$row['date_joined']}</td>
                  <td>
                      <form method='POST' action='delete_user.php' style='display: inline;'>
                          <input type='hidden' name='user_id' value='{$row['user_id']}'>
                          <button type='submit' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</button>
                      </form>
                  </td>
              </tr>";
          }
      } else {
          echo "<tr><td colspan='4'>No users found</td></tr>";
      }
  }

  $conn->close();
  ?>
  </tbody>
</table>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

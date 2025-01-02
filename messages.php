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
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Hello <?php echo $_COOKIE['username']; ?> !!</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-item nav-link active" href="homepage.php">Home <span class="visually-hidden">(current)</span></a>
        <a class="nav-item nav-link" href="messages.php">Messages</a>
        <a class="nav-item nav-link" href="messages.php">Contributions</a>
        <a class="nav-item nav-link" href="messages.php">Contribution History</a>
      </div>
    </div>
  </div>
</nav>

<?php
include "mysql_connector.php";

$receiver_id = $_COOKIE['userId'];

$sql = "SELECT message, date_sent, receiver_id FROM messages WHERE receiver_id = '$receiver_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "
        <div class='container mt-4'>
          <div class='row justify-content-center'>
            <div class='col-12 col-md-8 col-lg-6'>
              <div class='card mb-3'>
                <div class='card-body'>
                  <p class='card-text'>{$row['message']}</p>
                  <div class='text-end text-muted'>
                    <small>{$row['date_sent']}</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>";
    }
} else {
    echo "<div class='container mt-4'>
            <div class='row justify-content-center'>
                <div class='col-12 col-md-8 col-lg-6'>
                    <div class='alert alert-info text-center'>No messages to display</div>
                </div>
            </div>
          </div>";
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

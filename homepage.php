<?php
include "mysql_connector.php"; // Include your existing database connection

function get_pendingContributions($user_id) {
    global $conn; // Use the global connection variable

    // SQL query to get pending contributions
    $sql = "SELECT contributions.contributor_id, contributions.contribution_type_id, contributions.balance, 
            contribution_type.contribution_name, contribution_type.amount_per_member, 
            contribution_type.deadline 
            FROM contributions
            INNER JOIN contribution_type ON contributions.contribution_type_id = contribution_type.type_id
            WHERE contributions.contributor_id = '$user_id' AND contributions.balance > 0";

    // Check if any contributions are pending
    if ($result = $conn->query($sql)) {
        if ($result->num_rows > 0) {
            // Output for contributions
            echo "<h2>Pending Contributions</h2>";
            while ($row = $result->fetch_assoc()) {
                $contribution_name = htmlspecialchars($row['contribution_name']);
                $amount_to_pay = htmlspecialchars($row['amount_per_member']);
                $my_remainingBalance = htmlspecialchars($row['balance']);
                $deadline = htmlspecialchars($row['deadline']); // Get the deadline
                $deadline_js = date('Y-m-d H:i:s', strtotime($deadline)); // Format for JS

                // Display contribution details with countdown and button
                echo "<div class='contribution'>";
                echo "<h3>Contribution: $contribution_name</h3>";
                echo "<p class='amount-to-pay'>Amount to Pay: $$amount_to_pay</p>";
                echo "<p class='remaining-balance'>Remaining Balance: $$my_remainingBalance</p>";
                echo "<p class='deadline'>Deadline: $deadline</p>";
                echo "<div class='countdown' data-deadline='$deadline_js'></div>"; // Data attribute for deadline
                
                // Check if deadline has not been reached
                if (strtotime($deadline) > time()) {
                    echo '<form action="Mpesacode.php" method="post">
                    <input name="contribution_name" value="' . $contribution_name . '" hidden>
                    <input name="useremail" value="' . $_COOKIE["useremail"] . '" hidden>
                    <input name="username" value="' . $_COOKIE["username"] . '" hidden>
                    <input name="amount_toPay" value="'.$my_remainingBalance .'" hidden>
                    <input type="submit" class="btn btn-success" value="Contribute Now Via Mpesa">
                    </form>';
                }

                echo "</div>";
            }
        } else {
            echo "Hello " . htmlspecialchars($_COOKIE['username']) . ", You don't have any pending contributions.";
        }
    } else {
        echo "Error: " . $conn->error;
    }
}

// Check if the user_id cookie is set
if (isset($_COOKIE['userId'])) {
    $user_id = $_COOKIE['userId']; // Fetch user ID from cookie
} else {
    echo "Error: User ID not set. Please log in.";
    exit; // Stop further execution if user_id is not set
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Contributions</title>
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
        
        /* Custom styles */
        .amount-to-pay {
            color: brown; /* Amount to Pay - Brown */
        }
        
        .remaining-balance {
            color: blue; /* Remaining Balance - Blue */
        }

        .deadline {
            color: red; /* Deadline - Red */
        }

        .countdown {
            color: blue; /* Number of days remaining - Blue */
        }

        .btn-success {
            background-color: green; /* Contribute now via Mpesa - Green */
            border-color: green;
        }

        .btn-success:hover {
            background-color: darkgreen; /* Darker green on hover */
            border-color: darkgreen;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
            background-image: url("Rotaracts.png");
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
        <a class="navbar-brand" href="#"> Hello <?php echo htmlspecialchars($_COOKIE['username']); ?> !!</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link active" href="homepage.php">Home <span class="visually-hidden">(current)</span></a>
                <a class="nav-item nav-link" href="messages.php">Messages</a>
                <a class="nav-item nav-link" href="#">Contributions</a>
                <a class="nav-item nav-link" href="mpesaClient_dashboard.php">Contribution History</a>
            </div>
        </div>
    </div>
</nav>

<?php
// Fetch and display pending contributions
get_pendingContributions($user_id);
?>

<script>
    // Function to update all countdowns
    function updateCountdowns() {
        const countdownElements = document.querySelectorAll('.countdown');

        countdownElements.forEach(element => {
            const deadline = new Date(element.getAttribute('data-deadline')).getTime();
            const now = new Date().getTime();
            const distance = deadline - now;

            // Calculate remaining time
            const months = Math.floor(distance / (1000 * 60 * 60 * 24 * 30)); // Approximate months
            const days = Math.floor((distance % (1000 * 60 * 60 * 24 * 30)) / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Update countdown display
            element.innerHTML = `${months} months, ${days} days, ${hours} hours, ${minutes} minutes, ${seconds} seconds`;

            // If the countdown is finished, display a message
            if (distance < 0) {
                clearInterval(countdownInterval); // Stop the countdown for this element
                element.innerHTML = "Deadline reached!";
            }
        });
    }

    // Update countdown every second
    const countdownInterval = setInterval(updateCountdowns, 1000);
</script>

</body>

</html>
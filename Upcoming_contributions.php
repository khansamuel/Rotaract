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

                // Display contribution details with countdown
                echo "<div class='contribution'>";
                echo "<h3>Contribution: $contribution_name</h3>";
                echo "<p>Amount to Pay: $$amount_to_pay</p>";
                echo "<p>Remaining Balance: $$my_remainingBalance</p>";
                echo "<p>Deadline: $deadline</p>";
                echo "<div class='countdown' data-deadline='$deadline_js'></div>"; // Data attribute for deadline
                echo "</div>";
            }
        } else {
            echo "Hello {$_COOKIE['username']}, You don't have any pending contributions.";
        }
    } else {
        echo "Error: " . $conn->error;
    }
}

// Assuming user_id is set correctly
$user_id = $_COOKIE['userId']; // Replace with actual user ID fetching logic
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Contributions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .contribution {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        h2 {
            color: #333;
        }
        h3 {
            margin: 0;
        }
        .countdown {
            font-weight: bold;
            color: #d9534f; /* Bootstrap danger color */
        }
    </style>
</head>
<body>

<?php
$user_id=$_COOKIE['userId'];
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

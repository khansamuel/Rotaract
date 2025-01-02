<?php
include "mysql_connector.php";

function payment_function($user_email, $contribution_type, $amount_torecord) {
    global $conn; // Use global connection from mysql_connector.php

    // Get the user ID
    $sql = "SELECT user_id FROM users WHERE email='$user_email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];
        
        // Check if the user has an existing contribution of this type
        $sql = "SELECT contributor_id, contribution_type_id, balance 
                FROM contributions 
                WHERE contributor_id='$user_id' AND contribution_type_id='$contribution_type'";
        $contribution_result = $conn->query($sql);
        
        if ($contribution_result->num_rows > 0) {
            // Fetch the current balance if user has contributed previously
            $contribution_row = $contribution_result->fetch_assoc();
            $outstanding_balance = $contribution_row['balance'];
            
            // Check if the amount being recorded is greater than the balance
            if ($amount_torecord > $outstanding_balance) {
                $excess = $amount_torecord - $outstanding_balance;
                echo "<script>alert('Hello, you have paid {$excess} excess. Transaction Declined');</script>";
            } else {
                // Update the balance after deducting the payment
                $new_balance = $outstanding_balance - $amount_torecord;
                $sql = "UPDATE contributions 
                        SET balance='$new_balance' 
                        WHERE contributor_id='$user_id' AND contribution_type_id='$contribution_type'";
                
                if ($conn->query($sql) === true) {
                    // Send a message to the user
                    $sql = "SELECT amount_per_member, contribution_name, deadline FROM contribution_type WHERE type_id='$contribution_type'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $contribution_name = $row['contribution_name'];
                        $deadline = $row['deadline'];
                        $today = date("Y-m-d");

                        $message = "You have successfully contributed {$amount_torecord} to a contribution named ({$contribution_name}),
                                    Your outstanding balance is {$new_balance} which should be cleared by {$deadline}";
                        $sql = "INSERT INTO messages(message, date_sent, receiver_id) VALUES ('$message', '$today', '$user_id')";
                        $conn->query($sql);

                        echo "<script>alert('{$amount_torecord} was recorded successfully. Your outstanding balance is {$new_balance}');</script>";
                    }
                } else {
                    echo "<script>alert('Failed to update the contribution record');</script>";
                }
            }
        } else {
            // No previous contribution record found, fetch amount to pay for this type
            $sql = "SELECT amount_per_member, contribution_name, deadline FROM contribution_type WHERE type_id='$contribution_type'";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $amount_toPay = $row['amount_per_member'];
                $contribution_name = $row['contribution_name'];
                $deadline = $row['deadline'];
                $today = date("Y-m-d");
                
                // Check if the recorded amount is less than the required amount
                if ($amount_torecord < $amount_toPay) {
                    $outstanding_balance = $amount_toPay - $amount_torecord;
                    $sql = "INSERT INTO contributions (contributor_id, contribution_type_id, balance) 
                            VALUES ('$user_id', '$contribution_type', '$outstanding_balance')";
                    
                    if ($conn->query($sql) === true) {
                        // Send a message to the user
                        $message = "You have successfully contributed {$amount_torecord} to a contribution named ({$contribution_name}),
                                     Your outstanding balance is {$outstanding_balance} which should be cleared by {$deadline}";
                        $sql = "INSERT INTO messages(message, date_sent, receiver_id) VALUES ('$message', '$today', '$user_id')";
                        $conn->query($sql);
                        echo "<script>alert('Transaction recorded successfully with an outstanding balance of {$outstanding_balance}');</script>";
                    } else {
                        echo "<script>alert('Failed to record the transaction');</script>";
                    }
                } else {
                    // Handle excess payment scenario
                    $excess = $amount_torecord - $amount_toPay;
                    echo "<script>alert('You have paid {$excess} excess. Transaction Declined');</script>";
                }
            } else {
                echo "<script>alert('Contribution type not found');</script>";
            }
        }
    } else {
        echo "<script>alert('The email provided does not have an account in the system');</script>";
    }
}
?>

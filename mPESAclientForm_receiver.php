<?php

include "mysql_connector.php";




if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $useremail = $_POST['useremail'];
    $contribution = $_POST['contribution_name'];
    $mpesacodes = $_POST['mpesacodes'];
    $username = $_POST['username'];
    $amount = $_POST['amount'];
    $username_id = $_POST['username_id'];

    $date = date("Y/m/d");
    $message = "Hello " . $username . ", you have successfully recorded an Mpesa transaction of " . $amount . " on date " . $date . ".\nYour transaction will be validated by the admin prior to its confirmation.";

    $sql = "INSERT INTO messages(message, date_sent, receiver_id) VALUES('$message', '$date', '$username_id')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Payment recorded successfully')</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $sql = "INSERT INTO mpesa_codes(mpesa_code, member_paid, contribution_name, contributor_email, amount_paid)
     VALUES('$mpesacodes', '$username_id', '$contribution', '$useremail', '$amount')";
    if ($conn->query($sql) === TRUE) {
        header("Location:homepage.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
else{
    $contribution = "parties";


    $sql="SELECT contribution_name FROM contribution_type WHERE contribution_name='$contribution'";
if($conn->query($sql)->num_rows>0){
    echo"exists !!!!";
}
else{
    echo"Dont exists";
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<?php
include "mysql_connector.php";

if($_SERVER['REQUEST_METHOD']=="POST"){
    $useremail = $_POST['useremail'];
    $contribution = $_POST['contribution_name'];
    $amount_toPay = $_POST['amount_toPay'];
    $username = $_POST['username'];
    $username_id=$_COOKIE['userId'];

    $sql="SELECT contribution_name FROM contribution_type WHERE contribution_name='$contribution'";
    if($conn->query($sql)->num_rows>0){
        echo"exists !!!!";
    }
    else{
        echo"Dont exists";
    }
    
    // PHONE NUMBER TO RECEIVE MONEY 
    $phone_Number = '0720000000';

    echo '
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                Contribution Payment
            </div>
            <div class="card-body">
                <h5 class="card-title">Hello '.$username.'</h5>
                <p class="card-text">You are required to send your contribution to '.$phone_Number.'. Since your balance is '.$amount_toPay.', avoid sending money exceeding your balance.</p>
                <form method="POST" action="mPESAclientForm_receiver.php">
                    <div class="mb-3">
                        <label for="Mpesacodes" class="form-label">Mpesa Codes</label>
                        <input name="username_id" value="'.$username_id.'" hidden>
                        <input name="useremail" value="'.$useremail.'" hidden>
                        <input name="contribution_name" value="'.$contribution.'" hidden>
                        <input name="username" value="'.$username.'" hidden>
                        <input type="text" class="form-control" id="Mpesacodes" name="mpesacodes" placeholder="eg: KXMLUOP">
                    </div>
                    <div class="mb-3">
                        <label for="Amountpaid" class="form-label">Amount Paid</label>
                        <input type="number" class="form-control" id="amount" name="amount">
                    </div>
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
            </div>
        </div>
    </div>';
}
?>

</body>
</html>

<?php
// include "/public_html/application/views/pages/fundraiser.php";


$token = "2e17768127ee40a38b41d8d1639d517cfbc3158edc8e4915b3d780813b637640823a7bee91854a4081469c64b7739efc";
$server = "localhost";
$user = "jkusdach_root";
$pwd = "X\$X@E2#Nwc!=";
$db = "jkusdach_db";

header("Content-Type:application/json");
if (!isset($_GET["token"])) exit();
if ($_GET["token"] != $token) exit();
if (!$request = file_get_contents('php://input')) exit();
$conn = mysqli_connect($server, $user, $pwd, $db);
if (!$conn) exit();

$req_body = json_decode($request, true);
$transactiontype = mysqli_real_escape_string($conn, $req_body['TransactionType']);
$transid = mysqli_real_escape_string($conn, $req_body['TransID']);
$transtime = mysqli_real_escape_string($conn, $req_body['TransTime']);
$transamount = mysqli_real_escape_string($conn, $req_body['TransAmount']);
$businessshortcode = mysqli_real_escape_string($conn, $req_body['BusinessShortCode']);
$billrefno = mysqli_real_escape_string($conn, $req_body['BillRefNumber']);
$invoiceno = mysqli_real_escape_string($conn, $req_body['InvoiceNumber']);
$msisdn = mysqli_real_escape_string($conn, $req_body['MSISDN']);
$orgaccountbalance = mysqli_real_escape_string($conn, $req_body['OrgAccountBalance']);
$firstname = mysqli_real_escape_string($conn, $req_body['FirstName']);
$middlename = mysqli_real_escape_string($conn, $req_body['MiddleName']);
$lastname = mysqli_real_escape_string($conn, $req_body['LastName']);
$sql = "INSERT INTO paybill_payments(
        TransactionType,
        TransID,
        TransTime,
        TransAmount,
        BusinessShortCode,
        BillRefNumber,
        InvoiceNumber,
        MSISDN,
        FirstName,
        MiddleName,
        LastName,
        OrgAccountBalance
        ) VALUES (
        '$transactiontype',
        '$transid',
        '$transtime',
        '$transamount',
        '$businessshortcode',
        '$billrefno',
        '$invoiceno',
        '$msisdn',
        '$firstname',
        '$middlename',
        '$lastname',
        '$orgaccountbalance')";
        
$sum = "SELECT TransactionType,
        TransID,
        TransTime,
        SUM(TransAmount) AS 'GanzeTotal',
        BusinessShortCode,
        BillRefNumber,
        InvoiceNumber,
        MSISDN,
        FirstName,
        MiddleName,
        LastName,
        OrgAccountBalance FROM paybill_payments
        WHERE (BillRefNumber LIKE '%Fund%' OR '%Ganze%' OR '%Steps%' OR '%Mission%')";
        
// $total = $conn->query($sum);

// $row = $total->fetch_assoc();
// $total_ = $row['GanzeTotal'];

// //This part seems to be having an issue
// // display($total_);

if (!mysqli_query($conn, $sql)) {
    echo mysqli_error($conn);
} else {
    echo '{"ResultCode":0,"ResultDesc":"Confirmation received successfully"}';
}
mysqli_close($conn);
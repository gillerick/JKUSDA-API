<?php

$server = {servername};
$user = {username};
$pwd = {password};
$db = {database};


$leo = date("ymd", time());
$this_month = date("ym", time());
$jana = date("ymd", strtotime('yesterday'));


$conn = mysqli_connect($server, $user, $pwd, $db);
if (!$conn) exit();

$sql = "SELECT SUM(TransAmount) as 'GanzeTotal' FROM `paybill_payments` WHERE (BillRefNumber LIKE '%Ganze%' OR BillRefNumber LIKE '%Pledge%' OR BillRefNumber LIKE '%steps%' OR BillRefNumber LIKE '%Mission%' OR BillRefNumber LIKE '%IHS%' OR BillRefNumber LIKE '%fund%' OR BillRefNumber LIKE '%508123%' OR BillRefNumber LIKE '%pledge%' OR BillRefNumber LIKE '%Prof%') AND TransTime > '20200112'";
$res = $conn->query($sql);
$row = $res->fetch_assoc();
$total = $row['GanzeTotal'];

$sql1 = "SELECT (TransAmount) AS 'Latest', TransTime AS 'LatestDate', MiddleName AS 'Contributor', FirstName AS 'Contributor1', TransTime AS 'TimeStamp' FROM `paybill_payments` WHERE (BillRefNumber LIKE '%Pledge%' OR BillRefNumber LIKE '%Ganze%' OR BillRefNumber LIKE '%steps%' OR BillRefNumber LIKE '%Mission%' OR BillRefNumber LIKE '%IHS%' OR BillRefNumber LIKE '%fund%' OR BillRefNumber LIKE '%508123%' OR BillRefNumber LIKE '%pledge%' OR BillRefNumber LIKE '%Prof%') AND TransTime > '20200112' GROUP BY RowId ORDER BY RowId DESC LIMIT 1";
$last = $conn->query($sql1);
$row = $last->fetch_assoc();
$latest = $row['Latest'];
$member = $row['Contributor'];
$member1 = $row['Contributor1'];
$time_ = $row['TimeStamp'];
$l_date = $row['LatestDate'];


$sql2 = "SELECT SUM(TransAmount) as 'Today' FROM `paybill_payments` WHERE (BillRefNumber LIKE '%Ganze%' OR BillRefNumber LIKE '%Pledge%' OR BillRefNumber LIKE '%steps%' OR BillRefNumber LIKE '%Mission%' OR BillRefNumber LIKE '%IHS%' OR BillRefNumber LIKE '%fund%' OR BillRefNumber LIKE '%508123%' OR BillRefNumber LIKE '%pledge%' OR BillRefNumber LIKE '%Prof%') AND TransTime LIKE '%$leo%'";
$res = $conn->query($sql2);
$row = $res->fetch_assoc();
$today = $row['Today'];

$sql3 = "SELECT SUM(TransAmount) as 'Yesterday' FROM `paybill_payments` WHERE (BillRefNumber LIKE '%Ganze%' OR BillRefNumber LIKE '%Pledge%' OR BillRefNumber LIKE '%steps%' OR BillRefNumber LIKE '%Mission%' OR BillRefNumber LIKE '%IHS%' OR BillRefNumber LIKE '%fund%' OR BillRefNumber LIKE '%508123%' OR BillRefNumber LIKE '%pledge%' OR BillRefNumber LIKE '%Prof%') AND TransTime > '20200112' AND TransTime LIKE '%$jana%'";
$res = $conn->query($sql3);
$row = $res->fetch_assoc();
$yester = $row['Yesterday'];


$p = "SELECT SUM(TransAmount) AS 'Pledges' FROM `paybill_payments` WHERE BillRefNumber LIKE '%pledge%' AND TransTime > '20200112'";
$pledge = $conn->query($p);
$row = $pledge->fetch_assoc();
$pledge = $row['Pledges'];


$sql4 = "SELECT COUNT(DISTINCT MSISDN) as 'PCountToday' FROM `paybill_payments` WHERE (BillRefNumber LIKE '%Ganze%' OR BillRefNumber LIKE '%Pledge%' OR BillRefNumber LIKE '%steps%' OR BillRefNumber LIKE '%Mission%' OR BillRefNumber LIKE '%IHS%' OR BillRefNumber LIKE '%fund%' OR BillRefNumber LIKE '%508123%' OR BillRefNumber LIKE '%pledge%' OR BillRefNumber LIKE '%Prof%') AND TransTime > '20200112' AND TransTime LIKE '%$leo%'";
$res = $conn->query($sql4);
$row = $res->fetch_assoc();
$n_today = $row['PCountToday'];


$sql5 = "SELECT COUNT(DISTINCT MSISDN) as 'PCountYester' FROM `paybill_payments` WHERE (BillRefNumber LIKE '%Ganze%' OR BillRefNumber LIKE '%Pledge%' OR BillRefNumber LIKE '%steps%' OR BillRefNumber LIKE '%Mission%' OR BillRefNumber LIKE '%IHS%' OR BillRefNumber LIKE '%fund%' OR BillRefNumber LIKE '%508123%' OR BillRefNumber LIKE '%pledge%' OR BillRefNumber LIKE '%Prof%') AND TransTime LIKE '%$jana%' AND TransTime > '20200112'";
$res = $conn->query($sql5);
$row = $res->fetch_assoc();
$n_yester = $row['PCountYester'];


$sql6 = "SELECT COUNT(DISTINCT MSISDN) as 'PMonth' FROM `paybill_payments` WHERE (BillRefNumber LIKE '%Ganze%' OR BillRefNumber LIKE '%Pledge%' OR BillRefNumber LIKE '%steps%' OR BillRefNumber LIKE '%Mission%' OR BillRefNumber LIKE '%IHS%' OR BillRefNumber LIKE '%fund%' OR BillRefNumber LIKE '%508123%' OR BillRefNumber LIKE '%pledge%' OR BillRefNumber LIKE '%Prof%') AND TransTime LIKE '%$this_month%' AND TransTime > '20200112'";
$res = $conn->query($sql6);
$row = $res->fetch_assoc();
$this_month = $row['PMonth'];


$sql7 = "SELECT RowID as 'PrevID' FROM `paybill_payments` WHERE (BillRefNumber LIKE '%Ganze%' OR BillRefNumber LIKE '%Pledge%' OR BillRefNumber LIKE '%steps%' OR BillRefNumber LIKE '%Mission%' OR BillRefNumber LIKE '%IHS%' OR BillRefNumber LIKE '%fund%' OR BillRefNumber LIKE '%508123%' OR BillRefNumber LIKE '%pledge%' OR BillRefNumber LIKE '%Prof%') AND TransTime > '20200112'";
$res = $conn->query($sql7);
$row = $res->fetch_assoc();
$pID = $row['PrevID'];

$sql8 = "SELECT COUNT(DISTINCT MSISDN) as 'TCount' FROM `paybill_payments` WHERE (BillRefNumber LIKE '%Ganze%' OR BillRefNumber LIKE '%Pledge%' OR BillRefNumber LIKE '%steps%' OR BillRefNumber LIKE '%Mission%' OR BillRefNumber LIKE '%IHS%' OR BillRefNumber LIKE '%fund%' OR BillRefNumber LIKE '%508123%' OR BillRefNumber LIKE '%pledge%' OR BillRefNumber LIKE '%Prof%') AND TransTime > '20200112' AND TransTime > '20200112'";
$res = $conn->query($sql8);
$row = $res->fetch_assoc();
$n_total = $row['TCount'];


function duration($timestamp){
  
    date_default_timezone_set("Africa/Nairobi");         
    $time_ago        = strtotime($timestamp);
    $current_time    = time();
    $time_difference = $current_time - $time_ago;
    $seconds         = $time_difference;
  
    $minutes = round($seconds / 60); // value 60 is seconds  
    $hours   = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec  
    $days    = round($seconds / 86400); //86400 = 24 * 60 * 60;  
    $weeks   = round($seconds / 604800); // 7*24*60*60;  
    $months  = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60  
    $years   = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60
                  
    
    
    if (date('ymd',$time_ago) == date('ymd', strtotime('yesterday'))){
      return "Yesterday";
    }

    else if ($seconds < 60){

      return "Just now";
     
    }
    
    else if ($minutes < 60){
  
      if ($minutes == 1){
  
        return "1 minute ago";
  
      } else {
  
        return "$minutes minutes ago";
  
      }
  
    } else if ($hours < 24){
  
      if ($hours == 1){
        if ($minutes % 60 == 0){
  
          return "1 hour ago";
    
        }
      
        else {
          return "About 1 hour ago";
        }

      }
      
      else if($hours > 1)
      if ($minutes % 60 == 0){
        return "$hours hours ago";
      }
      else
      {
          return "About $hours hours ago";
  
      }
  
    } else if ($days < 7){
  
      if ($days == 2){

        return Date("D h:i A",$time_ago);
      }
    
      else {
  
        return "$days days ago";
  
      }
  
    } else if ($weeks <= 4.3){
  
      if ($weeks == 1){
  
        return "1 week ago";
  
      } else {
  
        return "$weeks weeks ago";
  
      }
  
    } else if ($months < 12){
  
      if ($months == 1){
  
        return "1 month ago";
  
      } else {
  
        return "$months months ago";
  
      }
    }
  }
  
$ago = duration($time_);



$data = [];
$data["sum"] = $total;
$data["latest"] = $latest;
$data["member"] = strtoupper($member);
$data["member1"] = strtoupper($member1);
$data["Timestamp"] = $ago;
$data["Pledges"] = $pledge;
$data["Today"] = $today;
$data["Jana"] = $yester;
$data["PCount"] = $n_today;
$data["PYester"] = $n_yester; 
$data["PMonth"] = $this_month;
$data["Time"] = strtotime($time_);
$data["TCount"] = $n_total;


echo json_encode($data);

<?php
session_start();
$username=$_REQUEST['str'];
require "config.php";
$sql="select * from customer where username='".$username."';";
$res=mysql_query($sql);
if($res == false){
    echo "OK";
}
else {
    $row=mysql_fetch_assoc($res);
    if($row['username']){
        echo $_SESSION['username'];
    }else{
        echo "Existed";
    }
}




?>
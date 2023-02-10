<?php
session_start();
if($_SESSION['id']==null){
    echo "<script>location.href='login2.php';</script>";
}
else{
include ("connect.php");
$subject=$_POST["subject"];
$content=$_POST["content"];
$user=$_SESSION["id"];
$query="INSERT INTO board (user,subject,content) values ('".$user."','".$subject."','".$content."')";
$result=$con->query($query) or die($mysqli->error);
if(!$result){
    echo("Error : ".mysqli_error($con));
}else{
    echo "<script>window.alert('저장되었습니다.');</script>";
    echo "<script>location.href='board.php';</script>";
}

}
?>
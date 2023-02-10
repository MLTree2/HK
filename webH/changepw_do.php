<?php
session_start();
if($_SESSION['id']==null){
   
    echo "<script>location.href='login2.php';</script>";
}
else{
    include ("connect.php");
    $id = $_SESSION['id'];
    $new_pw = $_POST['pw'];
    $query = "UPDATE users SET pw='$new_pw'where id='$id'";

    $result = mysqli_query($con, $query);

    if(!$result){
        echo("Error : ".mysqli_error($con));
    }
    else{
        echo "<script>window.alert('변경 성공!');</script>";
        echo "<script>location.href='changepw.php';</script>";
    }
}
?>
<?php

session_start();
if($_SESSION['id']==null) {
    echo "<script>window.alert('해당 페이지는 로그인이 필요합니다.');</script>"
    echo "<script>location.href='login.php';</script>";
}
else{
    
}
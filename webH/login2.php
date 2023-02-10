
<?php

session_start(); // 세션

if($_SESSION['id']==null) { // 로그인 하지 않았다면

?>



<html>
    <head>
        <title>로그인 페이지</title>
        <meta charset="uft-8">
    </head>
    <body>
        <h2>로그인</h2><hr>
        <br><br>

            <form name="login_form" action="login_check.php" method="post">
               ID : <input type="text" name="id"><br>
               PW:<input type="password" name="pw"><br><br>
               <input type="submit" name="login" value="Login">
            </form>
            
        
        
    </body>
</html>

<?php

}else{ // 로그인 했다면

   echo "<center><br><br><br>";
   echo $_SESSION['name']."(".$_SESSION['id'].")님이 로그인 하였습니다.";
   echo "&nbsp;<a href='logout.php'><input type='button' value='Logout'></a>";
   echo "&nbsp;<a href='board.php'><input type='button' value='게시판'></a>";
   echo "</center>";
}

?>
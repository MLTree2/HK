<?php
session_start();
if($_SESSION['id']==null){
    echo "<script>window.alert('해당 페이지는 로그인이 필요합니다.');</script>";
    echo "<script>location.href='login2.php';</script>";
}
else{
    include ("connect.php");
    $id = $_SESSION['id'];
    $query = "select * from users where id='$id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    ?>
    <html>
    <br><br>

        <form name="change_pw" action="changepw_do.php" method="post">
            현재 비밀번호 : <?php echo $row['pw']; ?><br>
            바꿀 비밀번호 : <input type="text" name="pw"><br><br>
            <?php echo "&nbsp;<a href='board.php'><input type='button' value='게시판'></a>"; ?>
            <input type="submit" name="submit" value="submit">
        </form>
    </html>
    <?php
}
?>
<?php
session_start();
if($_SESSION['id']==null){
    echo "<script>window.alert('해당 페이지는 로그인이 필요합니다.');</script>";
    echo "<script>location.href='login2.php';</script>";
}
else{
    include ("connect.php");
    
    
    $search = $_POST['search'];
    if($search==null){
        $query = "select * from board";
    }
    else{
        $query = "select * from board where subject LIKE '%$search%'";
    }
    $result = mysqli_query($con, $query);
    if(!$result){
        ?>
        <tr height="50">
            <td colspan="5" width="580"><?php die("Error: " . mysqli_error($con)); ?></td>
        </tr>
<?php
    }
    while($rs = $result->fetch_object()){
        $rsc[]=$rs;
    }
    


?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    
  </head>
  <body>

        <table class="table" style="width:70%;margin:auto;">
        <thead>
            <tr>
            <th scope="col">번호</th>
            <th scope="col">글쓴이</th>
            <th scope="col">제목</th>
            <th scope="col">등록일</th>
            </tr>
        </thead>
        <tbody>
        <?php 
            $i=1;
            foreach($rsc as $r){
            ?>
            <tr>
            <th scope="row"><?php echo $i++;?></th>
            <td><?php echo $r->user?></td>
            <td><a href="view.php?bid=<?php echo $r->bid;?>"><?php echo $r->subject?></a></td>
            <td><?php echo $r->date?></td>
            </tr>
            <?php }?>
        </tbody>
        </table>
        <br>

        <div class="col-md-4" style="float:right;padding:20px;">
        <a href="write.php"><button type="button" class="btn btn-primary">글쓰기</button><a>
        </div>
        <form style="width:70%;margin:auto;" action="board.php" method="post">
            <input type="text" size="40"placeholder="입력하세요." name="search">
            <input type="submit" name="searchbtn" value="검색">
        </form>
        

  </body>
</html>
<?php
}

?>
<?php
session_start();
if($_SESSION['id']==null){
    echo "<script>window.alert('해당 페이지는 로그인이 필요합니다.');</script>";
    echo "<script>location.href='login2.php';</script>";
}
else{
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

    <title>게시판 리스트</title>
  </head>
  <body>
    <div class="col-md-8" style="margin:auto;padding:20px;">
        <form method="post" action="write_save.php" enctype="multipart/form-data">
            <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">제목</label>
                <input type="text" name="subject" class="form-control" id="exampleFormControlInput1" placeholder="제목을 입력하세요.">
            </div>
            <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">내용</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="content" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <input type="file" name="upfile">
            </div>
            <button type="submit" class="btn btn-primary">등록</button>
        </form>
    <div>
</body>
</html>
<?php
}
?>
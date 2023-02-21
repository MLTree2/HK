<?php
include ("connect.php");

$bid=$_GET["bid"];
$result = $con->query("select * from board where bid=".$bid) or die("query error => ".$mysqli->error);
$rs = $result->fetch_object();

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

    <title>게시판 보기</title>
  </head>
  <body>


    <div class="col-md-8" style="margin:auto;padding:20px;">
      <h3 class="pb-4 mb-4 fst-italic border-bottom" style="text-align:center;">
        - 게시판 보기 -
      </h3>

      <article class="blog-post">
        <h2 class="blog-post-title"><?php echo $rs->subject;?></h2>
        <p class="blog-post-meta"><?php echo $rs->date;?> by <a href="#"><?php echo $rs->user;?></a></p>

        <hr>
        <p>
          <?php echo $rs->content;?>
        </p>
        <hr>
      </article>

      <nav class="blog-pagination" aria-label="Pagination">
        <a class="btn btn-outline-primary" href="board.php">목록</a>
      </nav>

    </div>

</body>
</html> 
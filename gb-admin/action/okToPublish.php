<?php
include('../../gb-includes/dbConnect.inc.php');
include('../../gb-classes/comment.cl.php');
$conn = dbConnect();
$newComment = new Comment;
$newComment->setLinkToDatabase($conn);
$newComment->setTableName('gbtable');
$newComment->decideComment('approve');
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<title>حذف التعليق</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Other metas for SEO -->
<link rel="stylesheet" type="text/css" href="../../gb-assests/back_style.css">
<link rel="stylesheet" type="text/css" href="../../gb-assests/front_style.css">
<link rel="icon" type="image/png" href="../../gb-imgs/favicon.png">
<script src="https://use.fontawesome.com/d966b4a993.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
  <style>
@font-face {
    font-family: droid-sans;
    src: url(../../gb-assests/droid-sans.ttf);
}
</style>
</head>
<body>
    <div class="decide-body">
    <div class="container decide-box">
        <br><br>
    <h3><?php echo $newComment->decidingMessage; ?></h3>
    <br>
<p><a href="../index.php" id="backToCp">الرجوع الى الصفحة السابقة</a></p>
<br><br>
</div>
</div>
</body> 
</html>

<?php 
include('../gb-includes/dbConnect.inc.php');
include('../gb-classes/comment.cl.php');
$conn = dbConnect();
$newComment = new Comment;
$newComment->setLinkToDatabase($conn);
$newComment->setTableName('gbtable');
$newComment->setStatusFlag('y');
$newComment->setResultPerPage(10);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<title>سجل الزوار | لوحة التحكم</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Other metas for SEO -->
<link rel="stylesheet" type="text/css" href="../gb-assests/back_style.css">
<link rel="stylesheet" type="text/css" href="../gb-assests/front_style.css">
<link rel="icon" type="image/png" href="../gb-imgs/favicon.png">
<script src="https://use.fontawesome.com/d966b4a993.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
  <style>
@font-face {
    font-family: droid-sans;
    src: url(../gb-assests/droid-sans.ttf);
}
</style>
</head>
<body>
    <div class="container">
<nav>
<?php include('../gb-partials/adminNav.part.php'); ?>
</nav>
<ul class="list-group">
<?php
$newComment->showComments();
foreach($newComment->sqlLimitedcomments as $rowShowWaiting) {
?>
<li class="list-group-item">
<p><span><i class="fa fa-user" aria-hidden="true"></i> &nbsp; </span><?php echo $rowShowWaiting['gb_name']; ?></p>
<p><span><i class="fa fa-envelope-open" aria-hidden="true"></i> &nbsp; </span><?php echo $rowShowWaiting['gb_email']; ?></p>
<p><span><i class="fa fa-commenting" aria-hidden="true"></i> &nbsp; </span><?php echo $rowShowWaiting['gb_comment']; ?></p>
<a href="action/deleteComment.php?gb_id=<?php echo $rowShowWaiting['gb_id']; ?>" class="isPublished">حذف</a></p>
</li>
<?php } ?>
</ul>
<?php $newComment->showPaginationLinks($_SERVER['PHP_SELF']); ?>
</div>
</div>
<?php $conn = null; ?>

</div>
</div><!-- Container -->

<div class="footer"> 
<?php include('../gb-partials/footer.part.php') ?>
</div>
   <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../gb-assests/op.js"></script>
</body>
</html>

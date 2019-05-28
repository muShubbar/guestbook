<?php
    include('gb-includes/dbConnect.inc.php');
    include('gb-classes/comment.cl.php');
    $conn = dbConnect();
    $newComment = new Comment;
    $newComment->setLinkToDatabase($conn);
    $newComment->setTableName('gbtable');
    $newComment->setStatusFlag('y');
    $newComment->setResultPerPage(10);
if (array_key_exists('submit', $_POST)) {
    $newComment->addComment($_POST['inputNameGb'], $_POST['inputEmailGb'], $_POST['inputComment']);
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<title>سجل الزوار</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Other metas for SEO -->
<link rel="stylesheet" type="text/css" href="gb-assests/front_style.css">
<link rel="icon" type="image/png" href="gb-imgs/favicon.png">
<script src="https://use.fontawesome.com/d966b4a993.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
  <style>
@font-face {
    font-family: droid-sans;
    src: url(gb-assests/droid-sans.ttf);
}
</style>
</head>
<body>
    <div class="container">
<nav>
<?php include('gb-partials/nav.part.php'); ?>
</nav>
<div id="inputBox">
<div class="jumbotron">
  <p><i class="fa fa-book" aria-hidden="true"></i> &nbsp; مرحبا بكم في سجل الزوّار، اكتب شيئا هنا ليبقى تذكارا في هذه الصفحة</p>
</div>
<?php $newComment->showResultMessages(); ?>

<form name="formGb" method="post" id="formGb" onSubmit="return checkForm()" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
<div class="form-group">
<p><i class="fa fa-user-circle" aria-hidden="true"></i> &nbsp; <label for="inputNameGb" id="labelNameGb">الإسم: </label>
<input type="text" name="inputNameGb" class="form-control input-lg" value="" required></p>
</div>
<div class="form-group">
<p><i class="fa fa-envelope-open" aria-hidden="true"></i> &nbsp; <label for="inputEmailGb" id="labelEmailGb">البريد الألكتروني: </label>
<input type="text" name="inputEmailGb" class="form-control input-lg" value="" required></p>
</div>
<div class="form-group">
<p><i class="fa fa-commenting" aria-hidden="true"></i> &nbsp; <label for="inputComment">التعليق: </label>
<textarea name="inputComment" class="form-control" required></textarea></p>
</div>
<br>
<div class="form-group">
<p><input type="submit" name="submit" class="btn btn-lg btn-success" value="أرسل التعليق"></p>
</div>
<br>
<p class="requiredNotice"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> &nbsp; جميع الحقول مطلوبة</p>
</form>
<br>
<hr>
<br>
</div>
<div id="commentsListBox">
<div class="well well-lg"><h4><i class="fa fa-list-ul" aria-hidden="true"></i> &nbsp; جميع التعليقات</h4></div>

<?php
$newComment->showComments();
foreach ($newComment->sqlLimitedcomments as $rowShowComments) { ?>


    <div class="row">
        <div class="col-sm-12 one-comment-box">
            <div class="panel panel-white post panel-shadow">
                <div class="post-heading">
                    <div class="pull-right image">
                        <img src="gb-imgs/avatar.png" class="img-circle avatar" alt="user profile image">
                    </div>
                    <div class="pull-right meta">
                        <div class="title h5">
                            <b><?php echo $rowShowComments['gb_name']; ?></b>
                        </div>
                        <h6 class="text-muted time"><?php echo $rowShowComments['gb_created']; ?></h6>
                    </div>
                </div> 
                <div class="post-description"> 
                    <p><?php echo $rowShowComments['gb_comment']; ?></p>
                </div>
            </div>
        </div>
    </div>




<?php } ?>
<?php $newComment->showPaginationLinks($_SERVER['PHP_SELF']); ?>
</div>
<?php $conn = null; ?>
</div><!-- Container -->
<div class="footer"> 
<?php include('gb-partials/footer.part.php') ?>
</div>
   <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="gb-assests/op.js"></script>
</body>
</html>

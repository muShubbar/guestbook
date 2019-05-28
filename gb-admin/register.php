<?php
include('../gb-includes/dbConnect.inc.php');
include('../gb-includes/sessions.inc.php');
include('../gb-includes/magicQuotes.inc.php');
startSession();
if (isset($_POST['submit'])) {
	nukeMagicQuotes();
	$username = trim($_POST['username']);
	$pwd = trim($_POST['pwd']);
	$message = array();
	if (strlen($username) < 6 || strlen($username) >15) {
		$message[] = 'إسم المستخدم يجب أن يكون مابين 6 و 15 حرف';
	}
	if (!ctype_alnum($username)) {
		$message[] = 'إسم المستخدم يجب أن يتكون من حروف و أرقام بدون مسافات';
	}
	if (strlen($pwd) < 6 || preg_match('/\s/', $pwd)) {
		$message[] = 'كلمة المرور يجب أن تحتوي على الأقل على 6 حروف بدون مسافات';
	}
	if ($pwd != $_POST['conf_pwd']) {
		$message[] = 'كلمة المرور لم تتطابق مع كلمة المرور التأكيدية';
	}
	if (!$message) {
		$conn = dbConnect();
		$checkDuplicate = "SELECT COUNT(*) FROM users WHERE username = '$username'";
		$result = $conn->query($checkDuplicate);
		$numRows = $result->fetchColumn();
		$result->closeCursor();
		if ($numRows) {
			$message[] = "$username هذا المستخدم موجود بالفعل، الرجاء إختيار إسم اخر";
		}
		else {
			$salt = time();
			$pwd = sha1($pwd.$salt);
			$insert = "INSERT INTO users (username, salt, pwd) VALUES ('$username', $salt, '$pwd')";
			$result = $conn->query($insert);
			if ($result) {
				$message[] = "تم إنشاء الحساب بنجاح $username";
			}
			else {
				$message[] = "هناك مشكلة في خلق حساب للمستخدم $username";
			}
		}
	}
}
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
<?php
	if (isset($message)) {
		foreach ($message as $item) {
			echo '<div class="alert alert-danger">' . $item . '</div>';
		}
	}
?>

<form name="registerForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
<div class="form-group">
<p><i class="fa fa-user-circle" aria-hidden="true"></i> &nbsp; <label for="username">إسم المستخدم: </label>
<input type="text" name="username" class="form-control input-lg" value=""></p>
</div>
<div class="form-group">
<p><i class="fa fa-envelope-open" aria-hidden="true"></i> &nbsp; <label for="pwd">كلمة السر: </label>
<input type="password" name="pwd" class="form-control input-lg" value=""></p>
</div>
<div class="form-group">
<p><i class="fa fa-envelope-open" aria-hidden="true"></i> &nbsp; <label for="conf_pwd">إعادة كلمة السر: </label>
<input type="password" name="conf_pwd" class="form-control input-lg" value=""></p>
</div>
<br>
<div class="form-group">
<p><input type="submit" name="submit" class="btn btn-lg btn-success" value="سجّل"></p>
</div>
<br>
<p class="requiredNotice"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> &nbsp; جميع الحقول مطلوبة</p>
</form>
<br>
<hr> 
<br>
<div class="jumbotron">
	<h4>المستخدمين الحاليين</h4> 
</div>
<?php 
$conn = dbConnect();
$sqlShowAdmin = "SELECT * FROM users";
$resultShowAdmin = $conn->query($sqlShowAdmin);
echo '<ul>';
foreach ($resultShowAdmin as $adminItem){
	echo '<li><h4>' . $adminItem['username'] . '</h4></li>';
}
?>
<br>
<hr> 
<br>
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
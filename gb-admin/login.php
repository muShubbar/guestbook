<?php
include('../gb-includes/dbConnect.inc.php');
if (array_key_exists('login', $_POST)) {
	session_start();
	$username = trim($_POST['username']);
	$pwd = trim($_POST['pwd']);
	$conn = dbConnect();
	$sql = "SELECT * FROM users WHERE username = ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute(array($username));
	$row = $stmt->fetch();
	if (sha1($pwd.$row['salt']) == $row['pwd']) {
		$_SESSION['authenticated'] = 'Jethro Tull';
	}
	else {
		$_SESSION = array();
		session_destroy();
		$error = 'غير صحيح';
	}
	if (isset($_SESSION['authenticated'])) {
		$_SESSION['start'] = time();
		header("Location: /gb-admin");
		exit;
	}
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link href="../gb-assests/signin.css" rel="stylesheet">
    <style>
@font-face {
    font-family: droid-sans;
    src: url(../gb-assests/droid-sans.ttf);
}
</style>
}
  </head>

  <body>

    <div class="container">

 <?php
if (isset($error)) {
  echo '<p class="alert alert-warning">'."$error".'</p>';
  }
elseif (isset($_GET['expired'])) {
?>
  <p class="alert alert-warning">إنتهت صلاحية الجلسة، الرجاء قم بتسجيل الدخول مرّة اخرى</p>
<?php } ?>

      <form class="form-signin" id="loginForm" name="form1" method="post" action="">
        <h2 class="form-signin-heading">الرجاء تسجيل الدخول</h2><br>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input name="username"  type="text" id="inputEmail" class="form-control" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input name="pwd" type="password" id="inputPassword" class="form-control" required>
        <button name="login" class="btn btn-lg btn-primary btn-block" type="submit">تسجيل</button>
      </form>

    </div> <!-- /container -->
  </body>
</html>

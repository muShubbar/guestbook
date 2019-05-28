<?php 
$thisPage = basename($_SERVER['SCRIPT_NAME']);
?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header navbar-right">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="/gb-admin/">لوحة التحكم</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
      <li class="adminNav"><a href="logout.php">تسجيل الخروج</a></li>
      <li class="adminNav <?php if($thisPage == 'register.php') echo 'active'; ?>"><a href="register.php">تسجيل عضو جديد</a></li>
       <li class="adminNav <?php if($thisPage == 'approvedComments.php') echo 'active'; ?>"><a href="approvedComments.php">التعليقات المنشورة</a></li>
	  <li class="adminNav <?php if($thisPage == 'index.php') echo 'active'; ?>"><a href="index.php">تعليقات تحت الإنتظار</a></li>

      </ul>
      <ul class="nav navbar-nav">
        <li><a href="/" target="_blank"><span class="glyphicon glyphicon-log-in"></span> مشاهدة السجل</a></li>
      </ul>
    </div>
  </div>
</nav>
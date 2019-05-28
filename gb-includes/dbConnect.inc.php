<?php
function dbConnect()
{
        $dbUser = 'mustafa';
        $dbPass = '172737';
    try {
        $conn = new PDO("mysql:host=localhost; dbname=guestbook; charset=utf8", $dbUser, $dbPass);
        return $conn;
    } catch (PDOException $e) {
        echo 'الإتصال بقاعدة البيانات غير متاح';
        exit;
    }
}

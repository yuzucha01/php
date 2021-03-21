<?php

session_start();

//入力しているかどうかチェック
if(
    !isset($_POST["email"]) || $_POST["email"]=="" ||
    !isset($_POST["message"]) || $_POST["message"]==""
){
    header("Location: form.php");
    exit;
}

//POSTデータの取得
$email  = $_POST["email"];
$message  = $_POST["message"];

//DBと接続
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}

//DBにデータを送る(form_table)
$stmt = $pdo -> prepare("INSERT INTO form_table(id, email, message, indate)
VALUES(NULL, :a1, :a2, sysdate())");

$stmt->bindParam(':a1', $email, PDO::PARAM_STR);
$stmt->bindParam(':a2', $message, PDO::PARAM_STR);
header("Location: top-page.php");
exit;

?>
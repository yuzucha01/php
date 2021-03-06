
<?php
session_start();

//POSTデータ取得
$email  = $_POST["email"];
$password  = $_POST["password"];

//入力チェック
if(
    !isset($_POST["email"]) || $_POST["email"]=="" ||
    !isset($_POST["password"]) || $_POST["password"]==""
){
    header("Location: index.php");
    exit;
}

// DBとの接続
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}

//DBからデータを取得
$sql = "SELECT * from gs_an_table where email=:email AND password=:password";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $email);
$stmt->bindValue(':password', $password);
$res = $stmt->execute();

$val = $stmt->fetch();

//重複したid有り
if($val["id"] != ""){
    $_SESSION["chk_ssid"] = session_id();//ユニークキー
    $_SESSION["email"] = $val['email'];
    header("Location: top-page.php");
    exit;  // 処理終了

} else {
// 認証失敗
header("Location: miss-login.php");
exit;
}

if($res==false){
  //SQL実行時にエラーがある場合（エラーオブジェクトを取得して表示）
  $error=$stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //index.phpへリダイレクト
  header("Location: index.php");
  exit;
}

?>





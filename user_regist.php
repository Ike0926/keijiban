<html>
<link rel="stylesheet" href="style.css">
<?php
/* 入力フォームからパラメータを取得 */
$formList = array('mode', 'input_userid', 'input_password', 'input_name', 'input_email');

/* ポストデータを取得しパラメータと同名の変数に格納 */
foreach($formList as $value) {
  $$value = $_POST[$value];
}
//エラーメッセージの初期化
$error = array();

$dsn = '*****';
$user = '*****';
$password = '*****';

//データベースに接続
$pdo = new PDO($dsn,$user,$password);

//ユーザーIDチェック
$sql = "SELECT userid FROM members WHERE userid = ?";
$stmt = $pdo->prepare($sql);
 $stmt->bindValue(1, $input_userid, PDO::PARAM_INT);
 $stmt->execute();
 $result = $stmt->fetch(PDO::FETCH_ASSOC);
 $count=$stmt->rowCount();


if($count > 0){ //ユーザーIDが存在
	array_push($error,"このユーザーIDは既に登録されています。");
}
if(count($error) == 0){
	//登録するデータにエラーがない場合、memberテーブルにデータを追加する。
	//トランザクション開始
	$pdo -> query("begin");
	$query = "INSERT INTO members(userid,password,name,email) VALUES('$input_userid','$input_password','$input_name','$input_email')";
	$result = $pdo -> query($query);
	
	if($result){//登録完了
	$pdo -> query("commit");
	
	mb_language("japanese");
	mb_internal_encoding("utf-8");
	
	$to = $input_email;
	$subject = "会員登録URL送信メール";
	$message = "会員登録ありがとうございました。\n"."登録いただいたユーザIDは[$input_userid]です。\n"."http://co-757.it.99sv-coco.com/login.html";
	$header = "From:abzuw.tak@gmail.com";
	
	if(!mb_send_mail($to,$subject,$message,$header)){
		array_push($error,"メールが送信出来ませんでした。<br>ただしデータベースの登録は完了しています。");
	}
  }else{//データベースへの登録作業失敗
  //ロールバック
  $pdo -> query("rollback");
  array_push($error,"データベースに登録できませんでした。");
  }
}
if(count($error) == 0){
?>
<body>
<form>
<div id = "form">
	<p class "form-title">登録完了</p>
	 <p class = "id">Thanks : 登録ありがとうございます。<br>登録完了のお知らせをメールで送信しました。確認ください。</p><br>
	 <a href="login.html">[ログイン画面へ]</a>
</form>
</div>
</body>
<?php
//エラー内容表示
}else{
?>
<body>
<form>
<div id = "form">
 <p class "form-title">登録エラー</p>
 <p class = "id">Error : 
 <?php
 foreach($error as $value){
 	print $value;
 ?>
 </p>
</form>
</div>
</body>
 <?php
 }
}
?>
</html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="style.css">
<?php
//フォームからメールアドレスを取得
$email = $_POST["email"];

//エラーメッセージ配列
$error = array();

$dsn = '******';
$user = '*****';
$password = '*****';
//データベースに接続
$pdo = new PDO($dsn,$user,$password);

if($email == ""){//未入力の場合、エラーを返す
	//エラーに配列を値を代入
	array_push($error,"メールアドレスを入力してください。"); //エラー配列に値を代入
}else{
//仮ユーザIDの生成
$pre_user_id = uniqid(rand(100,99));

//SQL文を発行
$sql = "INSERT INTO members(pre_userid,email) values('$pre_user_id','$email')";
$result = $pdo -> query($sql);

//データベース登録
if($result == false){
	array_push($error,"データベースに登録できませんでした。");//配列に値を代入
}else{
	//取得したメールアドレス宛にメールを送信
	mb_language("japanese");
	mb_internal_encoding("utf-8");
	
	$to = $email;
	$subject = "会員登録URL送信メール";
	$message = "以下のURLより会員登録してください。\n"."http://co-757.it.99sv-coco.com/home.php?pre_userid=$pre_user_id";
	$header = "From:abzuw.tak@gmail.com";
	
	if(!mb_send_mail($to,$subject,$message,$header)){
		array_push($error,"メールが送信できませんでした<a href='http://co-757.it.99sv-coco.com/home.php?pre_userid=$pre_user_id'>遷移先</a>"); //エラー配列に値を代入
	}
  }
}
if(count($error)>0){//エラーがあった場合
	//エラー内容表示
	foreach($error as $value){
?>
<body>
<form>
<div id ="form">
 <p class = "form-title">メールアドレス登録エラー</p>
  <p>Error : </p>
  <p><?php print $value; ?></p>
</form>
</div>
</body>
<?php
  } //foreach文の終了
 }else{//エラーがなかった場合
 ?>
<form>
<body>
<div id ="form">
  <p class = "form-title">メール送信成功しました。</p>
   <p>送信先メールアドレス：</p>
   <p><?php print $email ?></p>
 </div>
</body>

<?php 
}
?>
</div>
</body>
</html>
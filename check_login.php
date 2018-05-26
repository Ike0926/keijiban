<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
	//セッションの生成
	session_start();
	
//データベース接続
$dsn = '*****';
$user = '******';
$password = '*****';
$pdo = new PDO($dsn,$user,$password);

//ユーザ名/パスワード
$user = htmlspecialchars($_POST['user'],ENT_QUOTES);
$pass = htmlspecialchars($_POST['pass'],ENT_QUOTES);

	$sql = 'SELECT * FROM members WHERE userid = "'.$user.'" AND password ="'.$pass.'"';
	//$stmt = $pdo->query($sql);
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		print_r($result);
		
		echo $user;
		echo $pass;
		
	//認証
	if(($result[userid] == $user) && ($result[password] == $pass)){
		//echo "ログイン成功";
		$login = 'OK';
	}else{
		//ログイン失敗
		$login = 'Error';
	}
	
	//セッション変数に記録
	$_SESSION['login'] = $login;
	$_SESSION['name'] = $result[name];
	$_SESSION['pass'] = $result[userid];
	//移動
	if($login == 'OK'){
		//ログイン成功：ログイン成功画面へ
		header('Location: mission_2_15.php');
	}else{
		//ログイン失敗：ログインフォーム画面へ
		header('Location: login.html');
	}
?>
</html>
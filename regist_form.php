<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="style.css">
<?php
 //pre_useridの値を取得
 if($mode == "regist_form"){
 	$pre_userid = $_GET['pre_userid'];
 }
 
 //pre_userid 有効チェック
 $errorFlag = true;
 
 $dsn = '*****';
 $user = '*****';
 $password = '*****';
 
 //データベースに接続
 $pdo = new PDO($dsn,$user,$password);
 
 $sql = "SELECT * FROM members WHERE pre_userid = ?";
 $stmt = $pdo->prepare($sql);
 $stmt->bindValue(1, $pre_userid, PDO::PARAM_INT);
 $stmt->execute();
 $result = $stmt->fetch(PDO::FETCH_ASSOC);
 $count=$stmt->rowCount();
 //echo $count;
 //データベースにより取得したメールアドレスを表示
 if($count > 0){
 	//データが正常に取得できた
 	$errorFlag = false;
 	$email = $result['email'];
 	$num = 8; // パスワードの文字数
		$ar1 = range('a', 'z'); // アルファベット小文字を配列に
		$ar2 = range('A', 'Z'); // アルファベット大文字を配列に
		$ar3 = range(0, 9); // 数字を配列に
		$ar_all = array_merge($ar1, $ar2, $ar3); // すべて結合
		shuffle($ar_all); // ランダム順にシャッフル
		$input_userid = substr(implode($ar_all), 0, $num); // 先頭の8文字
 }
 if($errorFlag){
 ?>
 <body>
 <form>
 <div id = "form">
   <p class = "form-title">メールアドレス登録エラー</p>
    <p>Error :</p>
    <p>このURLは利用できません。<br>もう一度メールアドレスの登録からお願いします。</p>
    <a href = "home.php">会員登録ページ</a>
</form>
</div>
</body>
  <?php
 }else{//pre_useridが有効
 	//regist_confirmでのエラー表示
 	if(count($error) > 0){
 		foreach($error as $value){
 			print $value."<br>";
 		}
 	}
 ?>
 <form method = "post" action = "home.php">
 <div id = "form">
 	<input type = "hidden" name = "mode" value = "regist_confirm">
 	<input type = "hidden" name = "pre_userid" value = "<?php print $pre_userid; ?>">

 	 <p class = "form-title">会員登録フォーム</p>
 	  <p class = "id">ユーザID : </p><br>
 	  <p><?php print $input_userid; ?><input type = "hidden"  name = "input_userid" value = "<?php print $input_userid; ?>"></p><br>
 	  <p class = "pass">パスワード : </p>
 	  <p><input type = "text" size="30" name = "input_password" value = "<?php print $input_password; ?>">※ 6文字以上16文字以下</p><br>
 	  <p class = "name">名前 : </p>
 	  <p><input type = "text" size="30" name = "input_name" value = "<?php print $input_name; ?>"></p>
 	  </php print $email; ?><input type = "hidden" name = "input_email" value = "<?php print $email; ?>">
 	  <p class = "submit"><input type ="submit" value = "送信"></p>
 	 </form>
 	</div>
 	</body>
 <?php
 }
 ?>
 </html>
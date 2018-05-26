<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta charset=UTF-8">
	<title>画像登録＆アップロード</title>
</HEAD>
<BODY>
<FORM method="POST" enctype="multipart/form-data" action="img_upload.php">
	<P>画像登録＆アップロード</P>
	画像パス：<INPUT type="file" name="upfile" size="30"><BR>
	<INPUT type="submit" name="submit" value="送信">
</FORM>

<?php



if (count($_POST) > 0 && isset($_POST["submit"])){
	$upfile = $_FILES["upfile"]["tmp_name"];
	if ($upfile==""){
		print("ファイルのアップロードができませんでした。<BR>");
		exit;
	}

	// ファイル取得
	$imgdat = file_get_contents($upfile);
	$imgdat = mysql_real_escape_string($imgdat);


	//画像ファイルの指定
	$img_file = $_FILES["upfile"]["name"];;
	//echo "$img_file";
	//拡張子の取得
	$file_info = pathinfo($img_file);
	$img_extension = strtolower($file_info['extension']);
	//出力
	echo $img_extension."<br>";




	// DB接続
	$dsn = '*****';
	$user = '*****';
	$password = '*****';
	
	$pdo = new PDO($dsn,$user,$password);
	
    
	// データ追加
	$sql = "INSERT INTO keiji2 (img,ext) VALUES ('$imgdat','$img_extension')";

	$stmt = $pdo->query($sql);
	
	if (!$stmt){
		print("SQLの実行に失敗しました<BR>");
		exit;
	}

	print("登録が終了しました<BR>");
	}
	?>
	</BODY>
	</HTML>
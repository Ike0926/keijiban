<?php
// DB接続
	$dsn = '*****';
	$user = '*****';
	$password = '*****';
	
	$pdo = new PDO($dsn,$user,$password);


// 画像データ取得
$sql = "SELECT * FROM keiji WHERE id = '". $_GET['id']."'";
$results = $pdo -> query($sql);

foreach ($results as $row){
	// 画像ヘッダとしてjpegを指定（取得データがjpegの場合）
	header("Content-Type: image/jpeg");
    echo $row['img'];
}

?>
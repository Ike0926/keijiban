<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>動画表示</title>
</HEAD>
<BODY>
<FORM method="POST" action="display_mp4.php">
	<P>動画の表示</P>
	ID：<INPUT type="text" name="id">
	<INPUT type="submit" name="submit" value="送信">
	<BR><BR>
</FORM>

<?php
if (count($_POST) > 0 && isset($_POST["submit"])){
	$id = $_POST["id"];
	if ($id==""){
		print("IDが入力されていません。<BR>\n");
	} else {
		print("<video src=\"mp4_get.php?id=" . $id . "\" width=\"193\" height=\"130\"  controls>");
	}
}
?>
</BODY>
</HTML>
<?php
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>エラー画面</title>
</head>
<body>
<p id="fatalErrMsg"><?php echo "致命的なエラーが発生しました：".$_SESSION['fatalErrMsg']?></p>
</body>
</html>
<?php
	session_start();
	require "LogoutClass.php";
	require "DBAccessorClass.php";
	
	// ログイン状態のチェック
	if (!isset($_SESSION["SES_ADM_ID"])) {
		header("Location: ../contents/admLogin.php");
	  	exit;
	}

	if(isset($_POST["hdnTrans"])){
		if($_POST["hdnTrans"] === "logout"){
			// ログアウトボタンが押された場合
			$logout = new Logout();
			$logout->destroy();
			header("Location: ../contents/admLogin.php");
		}else if($_POST["hdnTrans"] === "rsvlist"){
			// 宿泊予約一覧ボタンが押された場合
			header("Location: ../contents/admRsvList.php");
		}else if($_POST["hdnTrans"] === "rgstAdm"){
			// 管理者登録ボタンが押された場合
			header("Location: ../contents/admRgst.php");
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理者メニュー画面</title>
<link rel="stylesheet" type="text/css" href="../css/contents.css" media="all">
<style type="text/css">
    <!--
	form{background: #eee;width:300px;}
	form div{padding: 10px 20px;}
    .clsFont{
		font-family:"ＭＳ Ｐゴシック";
		color:#000000;
		text-decoration: none;
	}
	.clsH1{
		text-align:center;
		padding-top:10px;
		font-size:20px;
	}
	.clsA{
		font-size:15px;
	}
	#frmAdmMenu{
		margin:auto;	
	}
    -->
</style>
</head>
<script type="text/javascript" src="../js/jquery-1.9.0.min.js"></script>
<script type="text/javascript">
// 宿泊予約一覧リンク押下
function fncRsvList(){
	
	$("#hdnTrans").val("rsvlist");
	$("#frmAdmMenu").submit();
	
}
// 管理者登録リンク押下
function fncRgstAdm(){
	
	$("#hdnTrans").val("rgstAdm");
	$("#frmAdmMenu").submit();
	
}
// ログアウトリンク押下
function fncLogout(){
	
	$("#hdnTrans").val("logout");
	$("#frmAdmMenu").submit();
	
}
</script>
<body>
<form id="frmAdmMenu" action="<?php print($_SERVER['PHP_SELF']) ?>" method="post">
	<h1 class="clsFont clsH1">管理者メニュー</h1>
	<p><span class="clsErrMsg"><?php echo $errMsg ?></span></p>
    <div>
    	<a href="#" class="clsA" onclick="fncRsvList();return false;">宿泊予約一覧</a>
    </div>    
    <div>
    	<a href="#" class="clsA" onclick="fncRgstAdm();return false;">管理者登録</a>
    </div>
    <div>
        <a href="#" class="clsA" onclick="fncLogout();return false;">ログアウト</a>
    </div>
    <input type="hidden" id="hdnTrans" name="hdnTrans"/>
</form>
</body>
</html>

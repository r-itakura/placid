<?php
	session_start ();
	require "DBAccessorClass.php";
		
	// ログイン状態のチェック
	if (!isset($_SESSION["SES_ADM_ID"])) {
		header("Location: ../contents/admLogin.php");
	 	exit;
	}
	
	if(isset($_POST["hdnTrans"])){
		if($_POST["hdnTrans"] === "menu"){
			// 管理者メニューへボタンが押された場合、管理者メニュー画面へ遷移する。
			header("Location: ../contents/admMenu.php");
		}else if($_POST["hdnTrans"] === "return"){
			// 戻るボタンが押された場合、宿泊予約一覧画面へ遷移する。
			header("Location: ../contents/admRsvList.php");
		}else if($_POST["hdnTrans"] === "delfinal"){
			// 取消確定ボタンが押された場合、取消確定処理へ遷移する。
			header("Location: ../contents/admRsvDel.php");
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>予約取消確認</title>
<link rel="stylesheet" type="text/css" href="../css/contents.css" media="all">
<style type="text/css">
    <!--
    form{background: #eee;width:700px;padding-bottom:50px;}
	form div{padding: 10px 20px;}
	table {
	  margin:auto;
	  width: auto;
	  border-spacing: 0;
	  font-size:14px;
	   border:1px solid #aaa;
	}
	table th {
	  color: #000;
	  padding: 8px 15px;
	  background: #eee;
	  background:-moz-linear-gradient(#eee, #ddd 50%);
	  background:-webkit-gradient(linear, 100% 0%, 100% 50%, from(#eee), to(#ddd));
	  font-weight: bold;
	  line-height: 120%;
	  text-align: center;
	  text-shadow:0 -1px 0 rgba(255,255,255,0.9);
	  box-shadow: 0px 1px 1px rgba(255,255,255,0.3) inset;
	}
	table tr td {
	  padding: 8px 15px;
	  text-align: left;
	}
	table tr {
	  background: #fff;
	}
	table tr:nth-child(2n+1) {
	  background: #f5f5f5;
	}
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
	.submit{
		border:1px solid #777;
		padding: 4px 10px;
		color: #fff;
		cursor: pointer;
		background: #428ec9;
		border-radius: 5px;
		
		/* Webkit */
		background: -webkit-gradient(
			linear,
			left top,
			left bottom,
			from(#99c9e5),
			to(#428ec9)
			);
		-webkit-border-radius: 5px;
		-webkit-box-shadow: 1px 1px 1px #fff;
			
		/* Firefox */
		background: -moz-linear-gradient(
			top,
			#99c9e5,
			#428ec9
			);
		-moz-border-radius: 5px;
		-moz-box-shadow: 1px 1px 1px #fff;
		
		/* IE */
		filter:progid:DXImageTransform.Microsoft.gradient
			(startColorstr=#ff99c9e5,endColorstr=#ff428ec9);
		zoom: 1;
	}
	#frmRsvDelConfirm{
		margin:auto;	
	}
	#bthMenu{
		padding-left:17px;	
	}
    -->
</style>
</head>
<script type="text/javascript" src="../js/jquery-1.9.0.min.js"></script>
<script type="text/javascript">
// 管理者メニューへボタン押下
function fncMenu(){
	
	$("#hdnTrans").val("menu");
	$("#frmRsvDelConfirm").submit();
	
}
// 戻るボタン押下
function fncReturn(){
	
	$("#hdnTrans").val("return");
	$("#frmRsvDelConfirm").submit();
	
}
// 取消確定ボタン押下
function fncDelFinal(){
	
	$("#hdnTrans").val("delfinal");
	$("#frmRsvDelConfirm").submit();
	
}
</script>
<body>
<form id="frmRsvDelConfirm" action="<?php print($_SERVER['PHP_SELF']) ?>" method="post">
	<h1 class="clsH1">予約取消確認</h1>
    <div id="bthMenu">
    	<input type="button" class="submit" value="管理者メニューへ" onclick="fncMenu()">
    </div>
    <div id="msgErr">
		<p><span class="clsErrMsg">以下の予約を取消します。よろしいですか？</span></p>
    </div>
	<input type="hidden" id="hdnTrans" name="hdnTrans"/>
<table>
<?php
		
		// 一覧から送られてきた予約IDを取得する。
		$rsvId = $_SESSION['delRsvId'];

		$dbAccessor = new DBAccessor();
		$stmt = $dbAccessor->getRsvDelInfo($rsvId);
		
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		echo "<tr><th>予約ID</th><td>".$row["RESERVE_ID"]."</td></tr>";
		echo "<tr><th>宿泊者名</th><td>".$row["SEI"]." ".$row["MEI"]."</td></tr>";
		echo "<tr><th>予約日</th><td>".$row["RSV_D"]."</td></tr>";
		echo "<tr><th>プランタイトル</th><td>".$row["PLAN_TITLE"]."</td></tr>";
		echo "<tr><th>宿泊料金</th><td>".number_format($row["PRICE"])."円</td></tr>";
?>
</table>
<div>
    <input type="button" class="submit" value="戻る" onclick="fncReturn()">
    <input type="button" class="submit" value="取消確定" onclick="fncDelFinal()">
</div>
</form>
</body>

</html>
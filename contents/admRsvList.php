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
		}else if($_POST["hdnTrans"] === "del"){
			// 取消ボタンが押された場合、予約取消確認画面へ遷移する。
			$_SESSION['delRsvId'] = $_POST["hdnDelRsvId"];
			header("Location: ../contents/admRsvDelConfirm.php");
		}
	}
	
	$errMsg = "";
	
	// 宿泊予約件数取得
	$dbAccessor = new DBAccessor();
	$ret = $dbAccessor->getRsvListCount();
	
	if($ret === "0"){
		// 取得件数が0の場合
		$errMsg = "宿泊予約はありません。";
	}
		
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>宿泊予約一覧</title>
<link rel="stylesheet" type="text/css" href="../css/contents.css" media="all">
<style type="text/css">
    <!--
	form{background: #eee;width:960px;padding-bottom:50px;}
	form div{padding: 10px 20px;}
  table {
	  width: auto;
	  border-spacing: 0;
	  font-size:14px;
		margin-left:20px;
		margin-right:20px;
	}
	table th {
	  color: #fff;
	  padding: 8px 15px;
	  background: #258;
	  background:-moz-linear-gradient(rgba(34,85,136,0.7), rgba(34,85,136,0.9) 50%);
	  background:-webkit-gradient(linear, 100% 0%, 100% 50%, from(rgba(34,85,136,0.7)), to(rgba(34,85,136,0.9)));
	  font-weight: bold;
	  border-left:1px solid #258;
	  border-top:1px solid #258;
	  border-bottom:1px solid #258;
	  line-height: 120%;
	  text-align: center;
	  text-shadow:0 -1px 0 rgba(34,85,136,0.9);
	  box-shadow: 0px 1px 1px rgba(255,255,255,0.3) inset;
	}
	table th:first-child {
	  border-radius: 5px 0 0 0;	
	}
	table th:last-child {
	  border-radius:0 5px 0 0;
	  border-right:1px solid #258;
	  box-shadow: 2px 2px 1px rgba(0,0,0,0.1),0px 1px 1px rgba(255,255,255,0.3) inset;
	}
	table tr td {
	  padding: 8px 15px;
	  border-bottom: 1px solid #84b2e0;
	  border-left: 1px solid #84b2e0;
	  text-align: center;
	}
	table tr td:last-child {
	  border-right: 1px solid #84b2e0;
	  box-shadow: 2px 2px 1px rgba(0,0,0,0.1);
	}
	table tr {
	  background: #fff;
	}
	table tr:nth-child(2n+1) {
	  background: #f1f6fc;
	}
	table tr:last-child td {
	  box-shadow: 2px 2px 1px rgba(0,0,0,0.1);
	}
	table tr:last-child td:first-child {
	  border-radius: 0 0 0 5px;
	}
	table tr:last-child td:last-child {
	  border-radius: 0 0 5px 0;
	}
	table tr:hover {
	  background: #bbd4ee;
	  cursor:pointer;
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
	#frmRsvList{
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
	$("#frmRsvList").submit();
	
}
// 削除ボタン押下
function fncDel(rsvId){
	
	$("#hdnTrans").val("del");
	$("#hdnDelRsvId").val(rsvId);
	$("#frmRsvList").submit();
	
}
</script>
<body>
<form id="frmRsvList" action="<?php print($_SERVER['PHP_SELF']) ?>" method="post">
<h1  class="clsH1">宿泊予約一覧</h1>
    <div id="bthMenu">
    	<input type="button" class='submit'  value="管理者メニューへ" onclick="fncMenu()">
    </div>
<input type="hidden" id="hdnTrans" name="hdnTrans"/>
<input type="hidden" id="hdnDelRsvId" name="hdnDelRsvId"/>
<p>&nbsp;&nbsp;&nbsp;&nbsp;<span class="clsFontGothic clsErrMsg"><?php echo $errMsg?></span></p>
<table border="1">
	<tr>
        <th>予約ID</th><th>宿泊者名</th><th>予約日</th><th>プランタイトル</th><th>宿泊料金</th><th>   </th>
    </tr>
<?php
	// 宿泊予約一覧取得
	$dbAccessor = new DBAccessor();
	$stmt = $dbAccessor->getRsvList();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		echo "<tr>";
		echo "	<td>".$row["RESERVE_ID"]."</td>";
		echo "	<td>".$row['SEI']." ".$row['MEI']."</td>";
		echo "	<td>".$row['RSV_D']."</td>";
		echo "	<td>".$row['PLAN_TITLE']."</td>";
		echo "	<td>".number_format($row['PRICE'])."円</td>";
		if($row['CANCEL_FLG'] === "1"){
			echo "	<td>キャンセル済</td>";
		}else{
			echo "	<td><input type='button' class='submit' value='キャンセルする' onclick='fncDel(".$row["RESERVE_ID"].")'/></td>";
		}
		echo "</tr>";		
	}
		
?>
</table>
</form>
</body>
</html>
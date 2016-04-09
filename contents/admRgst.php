<?php
	session_start ();
	require "DBAccessorClass.php";

	$errMsg = "";
	
	if(isset($_POST["hdnTrans"])) {
		if($_POST["hdnTrans"] === "rgst"){
			
			// 登録チェック
			$dbAccessor = new DBAccessor();
			$ret = $dbAccessor->checkAdmRgst($_POST["txtAdmId"]);
	
			if(!$ret){
				// すでに登録されている管理者の場合
				$errMsg = '登録済みの管理者です。';
			}else{

				// パスワード暗号化
				$pass = $_POST["txtAdmPass"];
				$pass_hash = crypt($pass);
				
				$dbAccessor = new DBAccessor();
				$stmt = $dbAccessor->insertAdm($_POST["txtAdmId"], $_POST["txtAdmNm"], $pass_hash);
				
				$errMsg = '登録が完了しました。';
			}

		}else if($_POST["hdnTrans"] === "menu"){
			// 管理者メニューへボタンが押された場合、管理者メニュー画面へ遷移する。
			header("Location: ../contents/admMenu.php");
		}
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理者登録</title>
<link rel="stylesheet" type="text/css" href="../css/contents.css" media="all">
<style type="text/css">
    <!--
     form{background: #eee;width:300px;padding-bottom:50px;}
	form div{padding: 10px 20px;}
	table {background-color:#ffffff;}
	.text{
		border:1px solid #777;
		padding: 5px;
		color: #999;
		background: #fff;
		border-radius: 5px;
		
		/* Webkit */
    	background: -webkit-gradient(
        linear,
        left top,
        left bottom,
        from(#eee),
        to(#fff)
        );
		-webkit-border-radius: 5px;
		-webkit-box-shadow: 1px 1px 1px #fff;
     
		/* Firefox */
		background: -moz-linear-gradient(
			top,
			#eee,
			#fff
			);
		-moz-border-radius: 5px;
		-moz-box-shadow: 1px 1px 1px #fff;
		
		/* IE */
		filter:progid:DXImageTransform.Microsoft.gradient
			(startColorstr=#ffeeeeee,endColorstr=#ffffffff);
		zoom: 1;
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
	.clsHead{
		font-size:12px;
	}
	#frmAdmRgst{
		margin:auto;	
	}
	#bthMenu{
		padding-left:17px;	
	}
    -->
</style>
</head>
<script type="text/javascript" src="../js/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="../js/common.js"></script>
<script type="text/javascript">
// 初期表示時処理
$(document).ready(function(){
	// 画面項目初期化
	$("#txtAdmId").val("");
	$("#txtAdmNm").val("");
	$("#txtAdmPass").val("");
	$("#admIdMsg").val("");
	$("#admNmMsg").val("");
	$("#admPassMsg").val("");
	
	$("#txtAdmId").focus();
	
});
// 登録時処理
function fncRgstAdm(){
	// エラーメッセージクリア
	$("#admIdMsg").val("");
	$("#admNmMsg").val("");
	$("#admPassMsg").val("");
	$("#errMsg").text("");
	
	// 必須入力チェック
	var flg = true;
	if(jQuery.trim($("#txtAdmId").val()) == ''){
		$("#admIdMsg").text("管理者IDを入力してください");
		flg = false;
	}else{
		$("#admIdMsg").text("");
	}
	
	if(jQuery.trim($("#txtAdmNm").val()) == ''){
		$("#admNmMsg").text("管理者名を入力してください");
		flg = false;
	}else{
		$("#admNmMsg").text("");
	}
	
	if(jQuery.trim($("#txtAdmPass").val()) == ''){
		$("#admPassMsg").text("パスワードを入力してください");
		flg = false;
	}else{
		$("#admPassMsg").text("");
	}
	
		// 形式チェック
	if(jQuery.trim($("#txtAdmId").val()) != '' && !$("#txtAdmId").val().match(/^[a-zA-Z0-9]+$/)){
		$("#admIdMsg").text("管理者IDは半角英数で入力してください。");
		flg = false;
	}
	if(jQuery.trim($("#txtAdmPass").val()) != '' && !$("#txtAdmPass").val().match(/^[a-zA-Z0-9]+$/)){
		$("#admPassMsg").text("パスワードは半角英数で入力してください。");
		flg = false;
	}
	
	// byte数チェック
	if(jQuery.trim($("#txtAdmId").val()) != '' && getByte($("#txtAdmId").val()) > 10){
		$("#admIdMsg").text("管理者IDは10文字以内で入力してください");
		flg = false;
	}
	if(jQuery.trim($("#txtAdmId").val()) != '' && getByte($("#txtAdmId").val()) > 20){
		$("#admIdMsg").text("管理者名は10文字以内で入力してください");
		flg = false;
	}
	if(jQuery.trim($("#txtAdmPass").val()) != '' && getByte($("#txtAdmPass").val()) > 20){
		$("#admPassMsg").text("パスワードは20文字以内で入力してください");
		flg = false;
	}
	
	if(!flg){
		// 入力チェックエラーの場合、画面に戻る。
		return;
	}
	
	$("#hdnTrans").val("rgst");
	$("#frmAdmRgst").submit();
	
}
// 管理者メニューへボタン押下
function fncMenu(){
	
	$("#hdnTrans").val("menu");
	$("#frmAdmRgst").submit();
	
}
</script>
<body>
<form id="frmAdmRgst" action="<?php print($_SERVER['PHP_SELF']) ?>" method="post">
    <h1 class="clsH1">管理者登録</h1>
    <div id="btnMenu">
        <input type="button" class="submit" value="管理者メニューへ" onclick="fncMenu()">
    </div>
	<p><span class="clsFontGothic clsErrMsg"><?php echo $errMsg ?></span></p>
    <div>
    	<label class="clsFont clsHead">ID</label>
        <p id="admIdMsg"  class="clsFontGothic clsErrMsg"></p>
        <input type="text" class="text" id="txtAdmId" size="30" maxlength="10" name="txtAdmId"/>
    </div>
    <div>
    	<label class="clsFont clsHead">管理者名</label>
        <p id="admNmMsg"  class="clsFontGothic clsErrMsg"></p>
        <input type="text" class="text" id="txtAdmNm" size="30" maxlength="20" name="txtAdmNm"/>
    </div>  
    <div>
    	<label class="clsFont clsHead">Pass</label>
        <p id="admPassMsg"  class="clsFontGothic clsErrMsg"></p>
        <input type="text" class="text" id="txtAdmPass" size="30" maxlength="10"  name="txtAdmPass"/>
    </div>
    <div>
        <input type="button" class="submit" value="登録" onclick="fncRgstAdm();return ralse;"/>
    </div>
    <input type="hidden" id="hdnTrans" name="hdnTrans"/>
</form>
</body>
</html>

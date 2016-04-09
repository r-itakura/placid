<?php
	session_start ();
	require "DBAccessorClass.php";

	$errMsg = "";
	
	if(isset($_POST["hdnTrans"])) {
		if($_POST["hdnTrans"] === "login"){
			// ログインチェック
			$dbAccessor = new DBAccessor();
			$ret = $dbAccessor->checkLogin($_POST["txtAdmId"], $_POST["txtAdmPass"]);
	
			if(!$ret){
				// 条件に合致する管理者がいない場合
				$errMsg = 'IDまたはパスワードが合致しません。';
			}else{
				
				// 管理者メニュー一覧画面へ遷移する。
				header("Location: ../contents/admMenu.php");
			}
		}else if($_POST["hdnTrans"] === "top"){
			// Topボタンが押された場合
			// セッション情報クリア
			$_SESSION = array(); 
			session_destroy();
			
			header("Location: ../index.php");
		}
    }
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理者ログイン</title>
<link rel="stylesheet" type="text/css" href="../css/contents.css" media="all">
<style type="text/css">
    <!--
	form{background: #eee;width:300px;}
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
	#frmAdmLogin{
		margin:auto;	
	}
	-->
</style>
</head>
<body>
<script type="text/javascript" src="../js/jquery-1.9.0.min.js"></script>
<script type="text/javascript">
// 初期表示時処理
$(document).ready(function(){
	// 画面項目初期化
	$("#txtAdmId").val("");
	$("#txtAdmPass").val("");
	$("#admIdMsg").val("");
	$("#admPassMsg").val("");
	
	// エラーメッセージクリア
	$("#admIdMsg").val("");
	$("#admPassMsg").val("");
	
	$("#txtAdmId").focus();
	
});
// ログイン時処理
function fncLogin(){
	// エラーメッセージクリア
	$("#admIdMsg").val("");
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
	
	if(jQuery.trim($("#txtAdmPass").val()) == ''){
		$("#admPassMsg").text("パスワードを入力してください");
		flg = false;
	}else{
		$("#admPassMsg").text("");
	}
	
	if(!flg){
		// 入力チェックエラーの場合、画面に戻る。
		return;
	}
	
	$("#hdnTrans").val("login");
	$("#frmAdmLogin").submit();
	
}
// トップボタン押下
function fncTop(){

	$("#hdnTrans").val("top");
	$("#frmAdmLogin").submit();
	
}
</script>
<form id="frmAdmLogin" action="<?php print($_SERVER['PHP_SELF']) ?>" method="post">
	<h1 class="clsH1">管理者ログイン</h1>
	<p><span class="clsFontGothic clsErrMsg"><?php echo $errMsg ?></span></p>
    <div>
    	<label class="clsFont clsHead">ID</label>
        <p id="admIdMsg"  class="clsFontGothic clsErrMsg"></p>
        <input type="text" class="text" id="txtAdmId" value="" size="30" maxlength="10"  name="txtAdmId"/>
    </div>    
    <div>
    	<label class="clsFont clsHead">Pass</label>
        <p id="admPassMsg"  class="clsFontGothic clsErrMsg"></p>
        <input type="text" class="text" id="txtAdmPass" value="" size="30" maxlength="10"  name="txtAdmPass"/>
    </div>
    <div>
        <input type="button" class="submit" value="ログイン" onclick="fncLogin();return ralse;"/>
        <input type="button" class="submit" value="Top" onclick="fncTop();return ralse;"/>
    </div>
    <input type="hidden" id="hdnTrans" name="hdnTrans"/>
</form>
</body>
</html>

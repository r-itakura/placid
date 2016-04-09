<?php
	session_start();
	require "DBAccessorClass.php";
	
	$errMsg = "";
	
	if(isset($_POST["hdnTrans"])){
		if($_POST["hdnTrans"] === "search"){
			// 検索ボタンが押された場合。
			// 検索条件をセッションに詰める。
			$_SESSION["htlIdCond"] = $_POST["hdnSelHtlId"]; // ホテルID
			$_SESSION["rsvDYCond"] = $_POST["hdnSelRsvDY"]; //チェックイン年
			$_SESSION["rsvDMCond"] = $_POST["hdnSelRsvDM"]; //チェックイン月
			$_SESSION["rsvDDCond"] = $_POST["hdnSelRsvDD"]; //チェックイン日
			$_SESSION["rsvDNumCond"] = $_POST["hdnSelRsvDNum"]; //宿泊日数
			$_SESSION["gstNumCond"] = $_POST["hdnSelGstNum"]; //宿泊者数
			$_SESSION["chkNoSmkCond"] = $_POST["hdnChkNoSmk"]; // 禁煙フラグ
			
			// プラン一覧画面へ遷移する。
			header("Location: ../contents/planList.php");
		}else if($_POST["hdnTrans"] === "contact"){
			// 予約取消・お問い合わせボタンが押された場合、お問い合わせ画面へ遷移する。
			header("Location: ../contents/contact.php");
		}else if($_POST["hdnTrans"] === "return"){
			// 戻るボタンが押された場合、プラン一覧画面へ遷移する。
			header("Location: ../contents/planList.php");
		}else if($_POST["hdnTrans"] === "confirm"){
			// 確認ボタンが押された場合、メールアドレスの重複登録チェックを行う。
			$dbAccessor = new DBAccessor();
			$ret = $dbAccessor->checkDuplMailAddr($_POST["hdnTxtMail"]);
			if(!$ret){
				// チェック結果がfalseの場合、元の画面に戻る。
				$errMsg = "すでに登録されているメールアドレスです。他のメールアドレスを入力してください。";
			}else{
				// 画面情報をセッションに格納する。
				$_SESSION["mail"] = $_POST["hdnTxtMail"]; // メールアドレス
				$_SESSION["sei"] = $_POST["hdnTxtSei"]; // 姓
				$_SESSION["mei"] = $_POST["hdnTxtMei"]; // 名
				$_SESSION["seiKana"] = $_POST["hdnTxtSeiKana"]; // 姓カナ
				$_SESSION["meiKana"] = $_POST["hdnTxtMeiKana"]; // 名カナ
				$_SESSION["tel"] = $_POST["hdnTxtTel"]; // 電話番号
				$_SESSION["sex"] = $_POST["hdnRdoSex"]; // 性別

				// 予約内容確認画面へ遷移する。
				header("Location: ../contents/rsvDtlConfirm.php");
			}
		}
	}
	
	$dbAccessor = new DBAccessor();
	
	// プランタイトルとプラン金額を取得する。
	$stmtPlnInfo = $dbAccessor->getPlnInfo($_SESSION["rsvPlnId"]);
	$rowPlnInfo = $stmtPlnInfo->fetch(PDO::FETCH_ASSOC);
	
	$rsvPlnTitle = $rowPlnInfo["PLAN_TITLE"];
	$_SESSION["rsvPlnTitle"] = $rsvPlnTitle;
	$_SESSION["rsvPlnPrice"] = $rowPlnInfo["PLAN_PRICE"];
	
	// ホテル名リスト取得
	$stmt = $dbAccessor->getHotelList();
	
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>予約詳細入力</title>
<link rel="stylesheet" type="text/css" href="../css/reset.css" media="all">
<link rel="stylesheet" type="text/css" href="../css/contents.css" media="all">
</head>
<body>
<script type="text/javascript" src="../js/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="../js/common.js"></script>
<script type="text/javascript">
// 初期表示時処理
$(document).ready(function(){
	// 画面項目初期化
	// 検索条件
	$("select[id='selHtlId']").val(<?php echo $_SESSION["htlIdCond"] ?>);
	$("select[id='selRsvDY']").val(<?php echo $_SESSION["rsvDYCond"] ?>);
	$("select[id='selRsvDM']").val(<?php echo $_SESSION["rsvDMCond"] ?>);
	$("select[id='selRsvDD']").val(<?php echo $_SESSION["rsvDDCond"] ?>);
	$("select[id='selRsvDNum']").val(<?php echo $_SESSION["rsvDNumCond"] ?>);
	$("select[id='selGstNum']").val(<?php echo $_SESSION["gstNumCond"] ?>);
	$("#chkNoSmk").attr("checked", <?php echo $_SESSION["chkNoSmkCond"] ?> );
	$("#txtRsvDY").focus();

	// 予約詳細
	$("input[id='rdoSex']").val(['man']);
	$("#txtMail").focus();
	
});
// 戻るボタン押下
function fncReturn(){
	
	$("#hdnTrans").val("return");
	$("#frmRsvDtlInput").submit();
	
}
// 確認ボタン押下
function fncConfirm(){
	
	// 入力チェック
	// 必須入力チェック
	var flg = true;
	if(jQuery.trim($("#txtMail").val()) == ''){
		$("#mailMsg").text("メールアドレスを入力してください");
		flg = false;
	}else{
		$("#mailMsg").text("");
	}
	if(jQuery.trim($("#txtMailConf").val()) == ''){
		$("#mailConfMsg").text("確認用メールアドレスを入力してください");
		flg = false;
	}else{
		$("#mailConfMsg").text("");
	}
	if(jQuery.trim($("#txtSei").val()) == ''){
		$("#nameMsg").text("氏名を入力してください");
		flg = false;
	}else{
		$("#nameMsg").text("");
	}
	if(jQuery.trim($("#txtMei").val()) == ''){
		$("#nameMsg").text("氏名を入力してください");
		flg = false;
	}else{
		$("#nameMsg").text("");
	}
	if(jQuery.trim($("#txtMeiKana").val()) == ''){
		$("#nameKanaMsg").text("氏名（フリガナ）を入力してください");
		flg = false;
	}else{
		$("#nameKanaMsg").text("");
	}
	if(jQuery.trim($("#txtSeiKana").val()) == ''){
		$("#nameKanaMsg").text("氏名（フリガナ）を入力してください");
		flg = false;
	}else{
		$("#nameKanaMsg").text("");
	}
	if(jQuery.trim($("#txtTel").val()) == ''){
		$("#telMsg").text("電話番号を入力してください");
		flg = false;
	}else{
		$("#telMsg").text("");
	}
	if(!$("input:radio[name='rdoSex']:checked").val()){
		$("#sexMsg").text("性別を選択してください");
		flg = false;
	}else{
		$("#sexMsg").text("");
	}
	
	// 形式チェック
	if(jQuery.trim($("#txtMail").val()) != '' && !$("#txtMail").val().match(/^[A-Za-z0-9]+[\w-]+@[\w\.-]+\.\w{2,}$/)){
		$("#mailMsg").text("メールアドレスの形式が正しくありません");
		flg = false;
	}
	if(jQuery.trim($("#txtMailConf").val()) != '' && !$("#txtMailConf").val().match(/^[A-Za-z0-9]+[\w-]+@[\w\.-]+\.\w{2,}$/)){
		$("#mailConfMsg").text("確認用メールアドレスの形式が正しくありません");
		flg = false;
	}
	if(jQuery.trim($("#txtSeiKana").val()) != '' && !$("#txtSeiKana").val().match(/^[ァ-ヾ]+$/)){
		$("#nameKanaMsg").text("氏名（フリガナ）の形式が正しくありません");
		flg = false;
	}
	if(jQuery.trim($("#txtMeiKana").val()) != '' && !$("#txtMeiKana").val().match(/^[ァ-ヾ]+$/)){
		$("#nameKanaMsg").text("氏名（フリガナ）の形式が正しくありません");
		flg = false;
	}
	if(jQuery.trim($("#txtTel").val()) != '' && !$("#txtTel").val().match(/^[0-9]+$/)){
		$("#telMsg").text("電話番号の形式が正しくありません");
		flg = false;
	}
	
	// byte数チェック
	if(jQuery.trim($("#txtMail").val()) != '' && getByte($("#txtMail").val()) > 100){
		$("#mailMsg").text("メールアドレスは100文字以内で入力してください");
		flg = false;
	}
	if(jQuery.trim($("#txtMailConf").val()) != '' && getByte($("#txtMailConf").val()) > 100){
		$("#mailConfMsg").text("確認用メールアドレスは100文字以内で入力してください");
		flg = false;
	}
	if(jQuery.trim($("#txtSei").val()) != '' && getByte($("#txtSei").val()) > 20){
		$("#nameMsg").text("氏名（姓）は10文字以内で入力してください");
		flg = false;
	}
	if(jQuery.trim($("#txtMei").val()) != '' && getByte($("#txtMei").val()) > 20){
		$("#nameMsg").text("氏名（名）は10文字以内で入力してください");
		flg = false;
	}
	if(jQuery.trim($("#txtSeiKana").val()) != '' && getByte($("#txtSeiKana").val()) > 20){
		$("#nameKanaMsg").text("氏名（姓）フリガナは10文字以内で入力してください");
		flg = false;
	}
	if(jQuery.trim($("#txtMeiKana").val()) != '' && getByte($("#txtMeiKana").val()) > 20){
		$("#nameKanaMsg").text("氏名（名）フリガナは10文字以内で入力してください");
		flg = false;
	}
	if(jQuery.trim($("#txtTel").val()) != '' && getByte($("#txtTel").val()) > 11){
		$("#telMsg").text("電話番号は11文字以内で入力してください");
		flg = false;
	}
	
	// Mail相関チェック
	if(jQuery.trim($("#txtMail").val()) != '' && jQuery.trim($("#txtMailConf").val()) != ''){
		if($("#txtMail").val() != $("#txtMailConf").val()){
			$("#mailConfMsg").text("メールアドレスと入力内容が異なります");
			flg = false;
		}
	}
	
	if(!flg){
		// 入力チェックエラーの場合、画面に戻る。
		return;
	}
	
	// 画面入力値をhiddenに詰める。
	$("#hdnTxtMail").val($("#txtMail").val());
	$("#hdnTxtSei").val($("#txtSei").val());
	$("#hdnTxtMei").val($("#txtMei").val());
	$("#hdnTxtSeiKana").val($("#txtSeiKana").val());
	$("#hdnTxtMeiKana").val($("#txtMeiKana").val());
	$("#hdnTxtTel").val($("#txtTel").val());
	$("#hdnRdoSex").val($("#rdoSex").val());
	$("#hdnRdoSex").val($('input[id="rdoSex"]:checked').val());
	$("#hdnTrans").val("confirm");
	$("#frmRsvDtlInput").submit();
	
}
// バイト数を取得する
function getByte(aStr){
 if(aStr.length == 0){return 0;}
 var count = 0;
 var Str = "";
 for(var i=0;i <aStr.length;i++){
   Str = aStr.charAt(i);
   Str = escape(Str);
   if( Str.length  < 4 ){
     count = count + 1;
   }else{
     count = count + 2;
   }
 }
 return count;
}
</script>
<form id="frmRsvDtlInput" action="<?php print($_SERVER['PHP_SELF']) ?>" method="post">
    <input type="hidden" id="hdnTrans" name="hdnTrans"/>
    <div id="divHeader">
        <!--ヘッダー-->
        <?php include("../contents/includeHeader.php"); ?>
    </div>
    <div id="divNav">
        <!--ナビゲーション-->
        <?php include("../contents/includeNav.php"); ?>
    </div>
    <div id="divSearch">
        <!--空室検索-->
        <hr>
        <?php include("../contents/includeSearch.php"); ?>
    </div>
	<div id="divContents">
    	<div id="divContentsMainRsv">
            <div id="divRsvDtlIn">
                <div id="divRsvNav">
                    <ol type="1">
                        <li id="liImgPlanSel"><img src="../images/imgPlanSelOff.png" alt="プラン選択" width="134" height="52"></li>
                        <li id="liImgArrow1"><img src="../images/imgArrow.png" alt="右矢印" width="9" height="12"></li>
                        <li id="liImgRsvIn"><img src="../images/imgRsvInOn.png" alt="予約詳細入力" width="134" height="52"></li>
                        <li id="liImgArrow2"><img src="../images/imgArrow.png" alt="右矢印" width="9" height="12"></li>
                        <li id="liImgRsvConf"><img src="../images/imgRsvConfOff.png" alt="予約内容確認" width="134" height="52"></li>
                        <li id="liImgArrow3"><img src="../images/imgArrow.png" alt="右矢印" width="9" height="12"></li>
                        <li id="liImgRsvComp"><img src="../images/imgRsvCompOff.png" alt="予約完了" width="134" height="52"></li>
                    </ol>
                </div>
                <div id="divRsvDtlInMain">
                    <div id="divRsvDtlInMsg">
                        <p><span class="clsFontGothic clsErrMsg"><?php echo $errMsg?></span></p>
                        <p><span class="clsEx">お客様の情報をご入力頂き、「確認」ボタンをクリックしてください。</span></p>
                        <p><span class="clsExRed">※</span><span class="clsEx">がついている項目は必ず入力してください。</span></p>
                    </div>
                    <div id="divRsvDtlInInput">
                        <input type="hidden" id="hdnTxtPlnTitle" name="hdnTxtPlnTitle">
                        <input type="hidden" id="hdnTxtMail" name="hdnTxtMail">
                        <input type="hidden" id="hdnTxtSei" name="hdnTxtSei">
                        <input type="hidden" id="hdnTxtMei" name="hdnTxtMei">
                        <input type="hidden" id="hdnTxtSeiKana" name="hdnTxtSeiKana">
                        <input type="hidden" id="hdnTxtMeiKana" name="hdnTxtMeiKana">
                        <input type="hidden" id="hdnTxtTel" name="hdnTxtTel">
                        <input type="hidden" id="hdnRdoSex" name="hdnRdoSex">
                        <table>
                            <tr><th class="clsTblHead" colspan="2">プラン</th><td><p><?php echo $rsvPlnTitle?></p></td></tr>
                            <tr><th class="clsTblHead" colspan="2">メールアドレス<span class="clsExRed">※</span></th><td><p id="mailMsg" class="clsFontGothic clsErrMsg"></p><input type="text" id="txtMail" maxlength="50" name="txtMail"/><p><span class="clsNotes">確認のため、もう一度ご入力ください</span></p><p id="mailConfMsg"  class="clsFontGothic clsErrMsg"></p><input type="text" id="txtMailConf" maxlength="50" name="txtMailConf"/></td></tr>
                            <tr><th class="clsTblHead" colspan="2">氏名<span class="clsExRed">※</span></th><td><p id="nameMsg" class="clsFontGothic clsErrMsg"></p>姓&nbsp;<input type="text" id="txtSei" maxlength="10" name="txtSei"/>&nbsp;&nbsp;名&nbsp;<input type="text" id="txtMei"maxlength="10" name="txtMei"/></td></tr>
                            <tr><th class="clsTblHead">氏名(フリガナ)<span class="clsExRed">※</span><td class="clsTblHead clsTdleft"><span class="clsNotes">全角カタカナ</span></td></th><td><p id="nameKanaMsg" class="clsFontGothic clsErrMsg"></p>セイ&nbsp;<input type="text" id="txtSeiKana" maxlength="10" name="txtSeiKana"/>&nbsp;&nbsp;メイ&nbsp;<input type="text" id="txtMeiKana" maxlength="10" name="txtMeiKana"/></td></tr>
                            <tr><th class="clsTblHead">電話番号<span class="clsExRed">※</span><td class="clsTblHead clsTdleft"><span class="clsNotes">ハイフンなし</span><p><span class="clsNotes">半角数字</span></p></td></th><td><p id="telMsg" class="clsFontGothic clsErrMsg"></p><input type="text" id="txtTel" maxlength="11" name="txtTel"/></td></tr>
                            <tr><th class="clsTblHead" colspan="2">性別<span class="clsExRed">※</span></th><td><p id="sexMsg" class="clsFontGothic clsErrMsg"></p><label>男性&nbsp;<input type="radio" id="rdoSex" name="rdoSex" value="man" /></label>&nbsp;<label>女性&nbsp;<input type="radio" id="rdoSex" name="rdoSex" value="woman" /></label></td></tr>
                        </table>            	
                	</div>
                </div>
                <div id="divBtn">
                    <div id="divBtnBack">
                        <input type='image' src='../images/btnBack.png' value='戻る' onclick='fncReturn();'/>
                    </div>
                    <div id="divBtnConf">
                        <input type='image' src='../images/btnConf.png' value='確認' onclick='fncConfirm();return false;'/>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div id="divFooter">
        <!--フッター-->
        <?php include("../contents/includeFooter.php"); ?>
    </div>
</form>
</body>

</html>
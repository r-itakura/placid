<?php
	session_start();
	require "DBAccessorClass.php";

	// コンストプロパティファイル取得
	$consts = parse_ini_file("../properties/const.properties");
	
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
			header("Location: ../contents/rsvDtlInput.php");
		}else if($_POST["hdnTrans"] === "rsvcommit"){
			// 予約確定ボタンが押された場合。
			// 予約登録処理を行う。
			$htlId = $_SESSION["htlIdCond"]; // ホテルID
			$plnId = $_SESSION["rsvPlnId"]; // プランID
			$gstNum =  $_SESSION["gstNumCond"]; // 宿泊者数
			$rsvD =  $_SESSION["rsvDYCond"].str_pad($_SESSION["rsvDMCond"], 2, "0", STR_PAD_LEFT).str_pad($_SESSION["rsvDDCond"], 2, "0", STR_PAD_LEFT); // 予約日
			$rsvDNum = $_SESSION["rsvDNumCond"]; // 宿泊日数
			$totalprice = $_SESSION["totalAmount"]; // 金額
			$rmId = $_SESSION["rsvRmId"];  // 部屋ID
			
			$sei = $_SESSION["sei"]; // 姓
			$mei = $_SESSION["mei"]; // 名
			$seikana = $_SESSION["seiKana"]; // 姓カナ
			$meikana = $_SESSION["meiKana"]; // 名カナ
			$mail = $_SESSION["mail"]; // EMAIL
			$tel = $_SESSION["tel"]; // 電話番号
			if($_SESSION["sex"] === "man"){
				$sex = "1"; // 性別
			}else{
				$sex = "2";
			}
			
			$dbAccessor = new DBAccessor();
			//$stmt = $dbAccessor->insertReserve($htlId, $plnId, $gstNum, $rsvD, $rsvDNum, $totalprice, $rmId, $sei, $mei, $seikana, $meikana, $mail, $tel, $sex);
			
			header("Location: ../contents/rsvEnd.php");
		}
	}
	
	// 予約詳細入力画面から送られてきた情報を取得する。	
	$rsvPlanId = $_SESSION["rsvPlnId"]; // プランID
	$rsvPlnTitle = $_SESSION["rsvPlnTitle"]; // プランタイトル
	$rsvPlnPrice = $_SESSION["rsvPlnPrice"]; // プラン金額
	$mail = $_SESSION["mail"]; // メールアドレス
	$sei = $_SESSION["sei"]; // 姓
	$mei = $_SESSION["mei"]; // 名
	$seiKana = $_SESSION["seiKana"]; // 姓カナ
	$meiKana = $_SESSION["meiKana"]; // 名カナ
	$tel = $_SESSION["tel"]; // 電話番号
	$sex = $_SESSION["sex"]; // 性別
	
	// 検索条件を取得する。
	$rsvDNumCond = $_SESSION["rsvDNumCond"]; // 泊数
	$gstNumCond = $_SESSION["gstNumCond"]; // 宿泊人数
	
	// プランの金額を計算(プラン金額×泊数×宿泊人数×消費税)
	$totalAmount= 0;
	$totalAmount = $rsvPlnPrice * $rsvDNumCond * $gstNumCond * $consts["tax"];
	$_SESSION["totalAmount"] = $totalAmount; // 合計金額
	
	// ホテル名リスト取得
	$dbAccessor = new DBAccessor();
	$stmt = $dbAccessor->getHotelList();
	
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>予約内容確認</title>
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
	
});
// 戻るボタン押下
function fncReturn(){

	$("#hdnTrans").val("return");
	$("#frmRsvDtlConfirm").submit();
	
}
// 予約確定ボタン押下
function fncCommit(){
	
	$("#hdnTrans").val("rsvcommit");
	$("#frmRsvDtlConfirm").submit();
	
}
</script>
<form id="frmRsvDtlConfirm" action="<?php print($_SERVER['PHP_SELF']) ?>" method="post">
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
            <div id="divRsvDtlConf">
                <div id="divRsvNav">
                    <ol type="1">
                        <li id="liImgPlanSel"><img src="../images/imgPlanSelOff.png" alt="プラン選択" width="134" height="52"></li>
                        <li id="liImgArrow1"><img src="../images/imgArrow.png" alt="右矢印" width="9" height="12"></li>
                        <li id="liImgRsvIn"><img src="../images/imgRsvInOff.png" alt="予約詳細入力" width="134" height="52"></li>
                        <li id="liImgArrow2"><img src="../images/imgArrow.png" alt="右矢印" width="9" height="12"></li>
                        <li id="liImgRsvConf"><img src="../images/imgRsvConfOn.png" alt="予約内容確認" width="134" height="52"></li>
                        <li id="liImgArrow3"><img src="../images/imgArrow.png" alt="右矢印" width="9" height="12"></li>
                        <li id="liImgRsvComp"><img src="../images/imgRsvCompOff.png" alt="予約完了" width="134" height="52"></li>
                    </ol>
                </div>
                <div id="divRsvDtlConfMain">
                    <div id="divRsvDtlConfMsg">
                        <p><span class="clsFontGothic clsErrMsg"><?php echo $errMsg?></span></p>
                        <p><span class="clsEx">ご入力いただいたお客様情報をご確認ください。</span></p>
                    </div>
                    <div id="divRsvDtlConfConfirm">
                        <table>
                            <tr><th class="clsTblHead">プラン</th><td><p><?php echo $rsvPlnTitle?></p></br><p><?php echo $_SESSION["rsvDMCond"]?>月<?php echo $_SESSION["rsvDDCond"]?>日から<?php echo $rsvDNumCond?>泊　<?php echo $gstNumCond?>名　<?php echo number_format($totalAmount)?>円&nbsp;（消費税・サービス料込み）</p></td></tr>
                            <tr><th class="clsTblHead">メールアドレス</th><td><p><?php echo $mail?></p></td></tr>
                            <tr><th class="clsTblHead">氏名</th><td><p><?php echo $sei." ".$mei."　様"?></p></td></tr>
                            <tr><th class="clsTblHead">氏名(フリガナ)</th><td><p><?php echo $seiKana." ".$meiKana."　様"?></p></td></tr>
                            <tr><th class="clsTblHead">電話番号</th><td><p><?php echo $tel?></p></td></tr>
                            <tr><th class="clsTblHead">性別</th><td><p><?php echo $consts[$sex]?></p></td></tr>
                        </table>
                    </div>
                </div>            
                <div id="divBtn">
                    <div id="divBtnBack">
                        <input type='image' src='../images/btnBack.png' value='戻る' onclick='fncReturn();'/>
                    </div>
                    <div id="divBtnCommit">
                        <input type='image' src='../images/btnRsvComp.png' value='予約確定' onclick='fncCommit();return false;'/>
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
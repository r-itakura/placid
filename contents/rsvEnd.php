<?php
	session_start ();
	require "DBAccessorClass.php";
	
	if(isset($_POST["hdnTrans"])) {
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
		}else if($_POST["hdnTrans"] === "top"){
			// Topボタンが押された場合
			// セッション情報クリア
			$_SESSION = array(); 
			session_destroy();
			
			header("Location: ../index.php");
		}
    }
	
	// ホテル名リスト取得
	$dbAccessor = new DBAccessor();
	$stmt = $dbAccessor->getHotelList();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>予約完了</title>
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
// トップボタン押下
function fncTop(){

	$("#hdnTrans").val("top");
	$("#frmRsvEnd").submit();
	
}
</script>
<form id="frmRsvEnd" action="<?php print($_SERVER['PHP_SELF']) ?>" method="post">
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
            <div id="divRsvEnd">
                <div id="divRsvNav">
                    <ol type="1">
                        <li id="liImgPlanSel"><img src="../images/imgPlanSelOff.png" alt="プラン選択" width="134" height="52"></li>
                        <li id="liImgArrow1"><img src="../images/imgArrow.png" alt="右矢印" width="9" height="12"></li>
                        <li id="liImgRsvIn"><img src="../images/imgRsvInOff.png" alt="予約詳細入力" width="134" height="52"></li>
                        <li id="liImgArrow2"><img src="../images/imgArrow.png" alt="右矢印" width="9" height="12"></li>
                        <li id="liImgRsvConf"><img src="../images/imgRsvConfOff.png" alt="予約内容確認" width="134" height="52"></li>
                        <li id="liImgArrow3"><img src="../images/imgArrow.png" alt="右矢印" width="9" height="12"></li>
                        <li id="liImgRsvComp"><img src="../images/imgRsvCompOn.png" alt="予約完了" width="134" height="52"></li>
                    </ol>
                </div>
                <div id="rsvEndMsg">
                    <p class='clsFontGothic clsNotice'>予約が完了しました。</p>
                </div>
                <div id="divBtn">
                    <div id="divBtnTop">
                        <input type='image' src='../images/btnTop.png' value='トップへ' onclick='fncTop()'/>
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
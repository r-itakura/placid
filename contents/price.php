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
<title>料金表</title>
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
});
</script>
<form id="frmPrice" action="<?php print($_SERVER['PHP_SELF']) ?>" method="post">
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
    	<div id="divContentsMain">
        	<div id="divImgNightView">
                <div id="divTitleBack">
                	<div id="divTitle">
                    	<img src="../images/lblPrice.png" alt="料金表" width="64" height="20">
                    </div>
                </div>
            </div>
            <hr />
            <div id="divImgPrice">
            	<img src="../images/imgPriceList.png" alt="料金表" width="432" height="228">
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
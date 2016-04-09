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
		}else if($_POST["hdnTrans"] === "admlogin"){
			// 管理者ログインボタンが押された場合、管理者ログイン画面へ遷移する。
			header("Location: ../contents/admLogin.php");
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
<title>アクセス</title>
<link rel="stylesheet" type="text/css" href="../css/reset.css" media="all">
<link rel="stylesheet" type="text/css" href="../css/contents.css" media="all">
</head>
<body>
<script type="text/javascript" src="../js/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="../js/common.js"></script>
<script type="text/javascript">
// 初期表示時処理
$(document).ready(function(){
	
});
</script>
<form id="frmAccess" action="<?php print($_SERVER['PHP_SELF']) ?>" method="post">
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
                    	<img src="../images/lblAccess.png" alt="アクセス" width="72" height="17">
                    </div>
                </div>
            </div>
            <hr />
            <div id="divTrain">
                <div id="divImgLblTrain">
                    <img src="../images/lblTrain.png" alt="電車でお越しのお客様" width="272" height="21">
                </div>
                <div id="divImgTrainMap">
                    <img src="../images/imgTrainMap.png" alt="路線図" width="794" height="652">
                </div>
            </div>
            <div id="divMap">
            	<div id="divOte">
                    <div id="divImgLblOte">
                        <img src="../images/lblOtemachi.png" alt="PLACID 大手町" width="212" height="21">
                    </div>
                    <div id="divImgOteMap">
                        <img src="../images/imgOtemachiMap.png" alt="大手町地図" width="387" height="361">
                    </div>
                </div>
                <div id="divKudan">
                    <div id="divImgLblKudan">
                        <img src="../images/lblKudanshita.png" alt="PLACID 九段下" width="212" height="21">
                    </div>
                    <div id="divImgKudanMap">
                        <img src="../images/imgKudanshitaMap.png" alt="九段下地図" width="387" height="361">
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
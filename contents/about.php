<?php
	session_start ();

	date_default_timezone_set ("Asia/Tokyo");

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
<title>PLACID HOTELSとは</title>
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
<form id="frmAbout" action="<?php print($_SERVER['PHP_SELF']) ?>" method="post">
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
                    	<img src="../images/lblAbout.png" alt="PLACID HOTELSとは" width="204" height="18">
                    </div>
                </div>
            </div>
            <hr />
            <div id="divAbout">
                <div id="divImgAbout">
                    <img src="../images/imgAbout.jpg" alt="フロント" width="594" height="230">
                </div>
                <div id="divAboutNote">
                    <p class="clsFontGothic clsAboutArticle">東京の中心、大手町と九段下に位置し、アクセスに優れたホテルとなっております。<br>私達はお客様が心からくつろげる空間とおもてなしを提供し、より活き活きとした明日を迎えて頂きたいと考えています。</p>
                </div>
            </div>
            <div id="divRoom">
            	<div id="divLblRoom">
                	<img src="../images/lblRoom.png" alt="客室" width="38" height="19">
                </div>
                <hr>
                <div id="divDtl">
                  <div id="divImgRoom">
                    <img src="../images/imgRoom.jpg" alt="客室" width="298" height="224">
                  </div>
                  <div id="divRoomNote">
                    <p class="clsFontGothic clsAboutDtlArticle">モダンデザインで統一された客室はすべて天井の高い広々とした空間となっており、ごゆっくりおくつろぎ頂けます。<br><br>理想の寝心地を追及したベッドと無線インターネット接続環境が各室に標準装備されております。</p>
                  </div>
                </div>
            </div>
            <div id="divBreakfast">
            	<div id="divLblBreakfast">
                	<img src="../images/lblBreakFast.png" alt="朝食" width="42" height="19">
                </div>
                <hr>
                <div id="divDtl">
                  <div id="divImgBreakFast">
                    <img src="../images/imgBreakFast.jpg" alt="朝食" width="298" height="224">
                  </div>
                  <div id="divBreakFastNote">
                    <p class="clsFontGothic clsAboutDtlArticle">すべての食材にこだわった新鮮なメニューと、彩り豊かなおかずをお召し上がりいただけます。<br><br>お食事は日替わりでご用意しており、元気な一日の始まりを応援します。<br>シェフこだわりのメニューを是非お楽しみください。</p>
                  </div>
                </div>
            </div>
            <div id="divSpa">
            	<div id="divLblSpa">
                	<img src="../images/lblSpa.png" alt="スパ" width="35" height="15">
                </div>
                <hr>
                <div id="divDtl">
                  <div id="divImgSpa">
                    <img src="../images/imgSpa.jpg" alt="スパ" width="298" height="224">
                  </div>
                  <div id="divSpaNote">
                    <p class="clsFontGothic clsAboutDtlArticle">ホテルの最上階には、展望スパをご用意しております。目の前に広がる眺望をお楽しみください。<br>広々としたスパで極上のリラックスとリラックスをご体感いただけます。<br>手足をのばしてゆっくりとおくつろぎください。<br><br>※展望スパはPLACID 九段下にございます。<br>PLACID大手町にはございません。ご了承ください。</p>
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

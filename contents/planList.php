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
		}else if($_POST["hdnTrans"] === "rsv"){
			// 予約ボタンが押された場合、
			// 部屋ＩＤをセッションに詰める。
			$_SESSION["rsvRmId"] = $_POST["hdnRsvRmId"]; // 予約する部屋ＩＤ
			$_SESSION["rsvPlnId"] = $_POST["hdnPlnId"]; // 予約するプランID
			
			// 詳細入力画面の入力内容がセッションに残っていた場合削除する。
			$_SESSION["mail"] = ""; // メールアドレス
			$_SESSION["sei"] = ""; // 姓
			$_SESSION["mei"] = ""; // 名
			$_SESSION["seiKana"] = ""; // 姓カナ
			$_SESSION["meiKana"] = ""; // 名カナ
			$_SESSION["tel"] = ""; // 電話番号
			$_SESSION["sex"] = ""; // 性別
			
			// 予約詳細入力画面へ遷移する。
			header("Location: ../contents/rsvDtlInput.php");
		}
    }
	
	$dbAccessor = new DBAccessor();
	
	// 日付チェック
	if(checkdate($_SESSION["rsvDMCond"], $_SESSION["rsvDDCond"], $_SESSION["rsvDYCond"])){
		// 検索条件の取得
		$htlIdCond = $_SESSION["htlIdCond"]; // ホテルID
		$rsvDCond = $_SESSION["rsvDYCond"].str_pad($_SESSION["rsvDMCond"], 2, "0", STR_PAD_LEFT).str_pad($_SESSION["rsvDDCond"], 2, "0", STR_PAD_LEFT); // チェックイン年月日
		$rsvDNumCond = $_SESSION["rsvDNumCond"]; // 宿泊日数
		$gstNumCond =  $_SESSION["gstNumCond"]; // 宿泊者数
		if($_SESSION["chkNoSmkCond"] === "true"){
			$smkFlgCond = "1"; // 禁煙フラグ 
		}else{
			$smkFlgCond = "0";
		}
		
		$ret = $dbAccessor->getPlanListCount($htlIdCond, $smkFlgCond, $gstNumCond, $rsvDCond);

	}else{
		$ret = "0";
	}

	

	// ホテル名リスト取得
	$stmt = $dbAccessor->getHotelList();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>プラン一覧</title>
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
// 予約ボタン押下
function fncRsv(rsvRmId, rsvPlnId){

	$("#hdnTrans").val("rsv");
	$("#hdnRsvRmId").val(rsvRmId);
	$("#hdnPlnId").val(rsvPlnId);
	$("#frmPlanList").submit();
	
}
</script>
<form id="frmPlanList" action="<?php print($_SERVER['PHP_SELF']) ?>" method="post">
    <input type="hidden" id="hdnTrans" name="hdnTrans"/>
    <input type="hidden" id="hdnRsvRmId" name="hdnRsvRmId"/>
    <input type="hidden" id="hdnPlnId" name="hdnPlnId"/>
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
            <div id="divList">
                <div id="divRsvNav">
                    <ol type="1">
                        <li id="liImgPlanSel"><img src="../images/imgPlanSelOn.png" alt="プラン選択" width="134" height="52"></li>
                        <li id="liImgArrow1"><img src="../images/imgArrow.png" alt="右矢印" width="9" height="12"></li>
                        <li id="liImgRsvIn"><img src="../images/imgRsvInOff.png" alt="予約詳細入力" width="134" height="52"></li>
                        <li id="liImgArrow2"><img src="../images/imgArrow.png" alt="右矢印" width="9" height="12"></li>
                        <li id="liImgRsvConf"><img src="../images/imgRsvConfOff.png" alt="予約内容確認" width="134" height="52"></li>
                        <li id="liImgArrow3"><img src="../images/imgArrow.png" alt="右矢印" width="9" height="12"></li>
                        <li id="liImgRsvComp"><img src="../images/imgRsvCompOff.png" alt="予約完了" width="134" height="52"></li>
                    </ol>
                </div>
                <?php
                if($ret === "0"){
                    // 取得件数が0の場合
                    echo "<p class='clsFontGothic clsNotice'>該当するプランはありません。</p>";
                }
                else{
                ?>
                <div id="divListMain">
                    <?php // プラン一覧取得
                        $stmtPlnList = $dbAccessor->getPlanList($htlIdCond, $smkFlgCond, $gstNumCond, $rsvDCond); 
                    ?>
                    <table>
                    <?php
                        while($row = $stmtPlnList->fetch(PDO::FETCH_ASSOC)){
                            echo "<tr>";
                            echo "	<td colspan='3'><div id='divListTtlBack'><div id='divListTtl'><span class='clsFontGothic clsListTitle'><h1>【".$row['PLAN_TITLE']."】</h1></span></div></div></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "	<td><div id='divImgPlan'><img src='../images/".$row["PLAN_IMG"]."' alt='".$row['PLAN_TITLE']."'></div></td>";
                            echo "	<td><div id='divPlanComment'><span class='clsFontGothic clsPlanComment'>".$row['PLAN_CONTENT']."</span></div></td>";
                            echo "	<td><div id='divBtnRsv'><input type='image' src='../images/btnRsv.png' value='ご予約' onclick='fncRsv(".$row["ROOM_ID"].",\"".$row["PLAN_ID"]."\")'/></div></td>";
                            echo "</tr>";
                        }
                    ?>
                    </table>
                </div>
                <?php
                }
                ?>
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
<?php

	session_start ();

	date_default_timezone_set ("Asia/Tokyo");

	require "contents/DBAccessorClass.php";

	// セッション情報クリア
	$_SESSION = array();

	if(isset($_POST["hdnTrans"])) {
		if($_POST["hdnTrans"] === "search"){
			// 検索ボタンが押された場合。
			// 検索条件をセッションに詰める。
			$_SESSION["htlIdCond"] = $_POST["hdnSelHtlId"]; //ホテルID
			$_SESSION["rsvDYCond"] = $_POST["hdnSelRsvDY"]; //チェックイン年
			$_SESSION["rsvDMCond"] = $_POST["hdnSelRsvDM"]; //チェックイン月
			$_SESSION["rsvDDCond"] = $_POST["hdnSelRsvDD"]; //チェックイン日
			$_SESSION["rsvDNumCond"] = $_POST["hdnSelRsvDNum"]; //宿泊日数
			$_SESSION["gstNumCond"] = $_POST["hdnSelGstNum"]; //宿泊者数
			$_SESSION["chkNoSmkCond"] = $_POST["hdnChkNoSmk"]; //禁煙フラグ

			// プラン一覧画面へ遷移する。
			header("Location: contents/planList.php");
		}else if($_POST["hdnTrans"] === "contact"){
			// 予約取消・お問い合わせボタンが押された場合、お問い合わせ画面へ遷移する。
			header("Location: contents/contact.php");
		}else if($_POST["hdnTrans"] === "admlogin"){
			// 管理者ログインボタンが押された場合、管理者ログイン画面へ遷移する。
			header("Location: contents/admLogin.php");
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
<title>トップページ</title>
<link rel="stylesheet" type="text/css" href="css/reset.css" media="all">
<link rel="stylesheet" type="text/css" href="css/contents.css" media="all">
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43135140-1', 'cho88.com');
  ga('send', 'pageview');

</script>
</head>
<body>
<script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript">
// 初期表示時処理
$(document).ready(function(){
	// 画面項目初期化
	d = new Date() ;
	month	= d.getMonth()+1;
	day	= d.getDate();

	// 検索条件
	$("select[id='selHtlId']").val(1);
	$("select[id='selRsvDY']").val(1);
	$("select[id='selRsvDM']").val(month);
	$("select[id='selRsvDD']").val(day);
	$("select[id='selRsvDNum']").val(1);
	$("select[id='selGstNum']").val(1);
	$("#chkNoSmk").attr("checked", false );

});
</script>
<form id="frmIndex" action="<?php print($_SERVER['PHP_SELF']) ?>" method="post">
    <input type="hidden" id="hdnTrans" name="hdnTrans"/>
    <div id="divHeader">
        <!--ヘッダー-->
        <?php include("contents/includeHeader.php"); ?>
    </div>
    <div id="divMainView">
        <!--メインビジュアル-->
        <div id="divNavTop">
            <!--ナビゲーション-->
            <?php include("contents/includeNav.php"); ?>
        </div>
    </div>
    <div id="divSearch">
        <!--空室検索-->
        <hr>
        <?php include("contents/includeSearch.php"); ?>
    </div>
    <div id="divContents">
    	<div id="divContentsMainTop">
            <div id="divBanner">
                <!--バナー-->
                <ul>
                    <li id="banner1"><a href="#"><img src="images/banner1.png" alt="春のキャンペーンご宿泊料金20%off" width="200" height="80"></a></li>
                    <li id="banner2"><a href="#"><img src="images/banner2.png" alt="PLACID九段下オープンキャンペーン" width="200" height="80"></a></li>
                </ul>
            </div>
            <div id="divNews">
                <!--記事-->
                <h1 id="divNewsTitle"><img src="images/lblNewsTitle.png" alt="NewsTopics" width="174" height="26"></h1>
                <ul id="divArticle">
                    <li id="article1"><span class="clsFontGothic clsArticleDay">2013.3.25</span><span class="clsFontGothic clsArticle">　　　　　　　　　【春のキャンペーン】ご宿泊料金20%offキャンペーンについて</span></li>
                    <li id="article2"><span class="clsFontGothic clsArticleDay">2013.3.15</span><span class="clsFontGothic clsArticle">　　　　　　　　　大浴場がご利用いただけるようになりました。</span></li>
                    <li id="article3"><span class="clsFontGothic clsArticleDay">2013.3.12</span><span class="clsFontGothic clsArticle">　　　　　　　　　朝食をリニューアルしました。是非ご利用ください。</span></li>
                    <li id="article4"><span class="clsFontGothic clsArticleDay">2013.3.10</span><span class="clsFontGothic clsArticle">　　　　　　　　　支配人よりお得なお知らせがございます。</span></li>
                    <li id="article5"><span class="clsFontGothic clsArticleDay">2013.3.1</span><span class="clsFontGothic clsArticle">　　　　　　　　　　PLACID 九段下　オープンキャンペーンについて</span></li>
                    <li id="ichiran"><span class="clsFontGothic clsArticle">&gt;&gt;　一覧はこちら</span></li>
                </ul>
            </div>
    	</div>
    </div>
   	<div id="divFooter">
        <!--フッター-->
        <?php include("contents/includeFooter.php"); ?>
    </div>
</form>
</body>
</html>

<?php
	$topPath = "";
	$logoPath = "";
	$last_include_path = str_replace("/", "", strrchr($_SERVER["SCRIPT_NAME"], "/"));
	if($last_include_path === "index.php"){
		// index.phpから呼び出された場合
		$topPath = "index.php";
		$logoPath = "images/logo.png";
		
	}else{
		// index.php以外から呼び出された場合
		$topPath = "../index.php";
		$logoPath = "../images/logo.png";
	}
?>

<div id="divHaderInner">
    <!--ヘッダー-->
    <div id="divLogo"><a href="<?php echo $topPath ?>"><img src="<?php echo $logoPath ?>" alt="ロゴ" width="145" height="51"></a></div>
    <div id="divHdrLnk"><a href="#" class="clsFontGothic clsHdrLnk" onclick="">予約取消・お問い合わせ</a></div>
</div>
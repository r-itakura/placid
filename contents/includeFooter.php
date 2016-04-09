<?php
	$topPath = "";
	$aboutPath = "";
	$pricePath = "";
	$hotellistPath = "";
	$accessPath = "";
	$dispAdmin = false;

	$last_include_path = str_replace("/", "", strrchr($_SERVER["SCRIPT_NAME"], "/"));
	if($last_include_path === "index.php"){
		// index.phpから呼び出された場合
		$topPath = "index.php";
		$aboutPath = "contents/about.php";
		$pricePath = "contents/price.php";
		$hotellistPath = "contents/hotellist.php";
		$accessPath = "contents/access.php";
		
		$dispAdmin = true;
	}else{
		// index.php以外から呼び出された場合
		$topPath = "../index.php";
		$aboutPath = "../contents/about.php";
		$pricePath = "../contents/price.php";
		$hotellistPath = "../contents/hotellist.php";
		$accessPath = "../contents/access.php";
		
		$dispAdmin = false;
	}
?>
<div id="divFooterInner">
	<div id="divFtLnk">
        <div id="divFtLnk1">
            <ul>
                <li id="ftLnk1"><a class="clsFtLnk" href="<?php echo $topPath ?>" onclick="">トップ</a></li>
                <li id="ftLnk2"><a class="clsFtLnk" href="<?php echo $aboutPath ?>" onclick="">PLACID HOTELSとは</a></li>
                <li id="ftLnk3"><a class="clsFtLnk" href="<?php echo $pricePath ?>" onclick="">料金表</a></li>
                <li id="ftLnk4"><a class="clsFtLnk" href="<?php echo $hotellistPath ?>" onclick="">ホテル一覧</a></li>
            </ul>
        </div>
        <div id="divFtLnk2">
            <ul>
                <li id="ftLnk5"><a class="clsFtLnk" href="<?php echo $accessPath ?>" onclick="">アクセス</a></li>
            </ul>
        </div>
    </div>
    <div id="divAddr">
        <div id="divAddrOte">
            <p class="clsFt">PLACID 大手町<br><br><span class="clsFtAddr">〒100-0005<br>東京都千代田区丸の内1-6-3<br>03-1111-2222<br>ootemachi@placidhotels.co.jp</span></p>  
        </div>
        <div id="divAddrKudan">
            <p class="clsFt">PLACID 九段下<br><br><span class="clsFtAddr">〒101-0065<br>東京都千代田区西神田2-4-4<br>03-3333-4444<br>kudanshita@placidhotels.co.jp</span></p>  
        </div>
    </div>
    <?php if($dispAdmin){
        echo "<div id='divAdmLogin'><a href='#' class='clsFt' onclick='fncAdmLogin();'>管理者ログイン</a></div>";
    }
    ?>
</div>
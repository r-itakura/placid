<?php
	$topPath = "";
	$aboutPath = "";
	$pricePath = "";
	$hotellistPath = "";
	$accessPath = "";
	$path = "";
	$last_include_path = str_replace("/", "", strrchr($_SERVER["SCRIPT_NAME"], "/"));
	if($last_include_path === "index.php"){
		// index.phpから呼び出された場合
		$topPath = "index.php";
		$aboutPath = "contents/about.php";
		$pricePath = "contents/price.php";
		$hotellistPath = "contents/hotellist.php";
		$accessPath = "contents/access.php";
	}else{
		// index.php以外から呼び出された場合
		$topPath = "../index.php";
		$aboutPath = "../contents/about.php";
		$pricePath = "../contents/price.php";
		$hotellistPath = "../contents/hotellist.php";
		$accessPath = "../contents/access.php";
		
		$path = "../";
	}
?>

<div id="divNavBtn">
    <ul id="ulNavBtn">
        <li id="navTop"><a href="<?php echo $topPath ?>" class="rollover"><img src="<?php echo $path ?>images/navTopOff.png" alt="トップ" width="198" height="62"></a></li>
        <li id="navAbout"><a href="<?php echo $aboutPath ?>" class="rollover"><img  src="<?php echo $path ?>images/navAboutOff.png" alt="PlacidHotelsとは" width="198" height="62"></a></li>
        <li id="navPrice"><a href="<?php echo $pricePath ?>" class="rollover"><img src="<?php echo $path ?>images/navPriceOff.png" alt="料金表" width="198" height="62"></a></li>
        <li id="navList"><a href="<?php echo $hotellistPath ?>" class="rollover"><img src="<?php echo $path ?>images/navListOff.png" alt="ホテル一覧" width="198" height="62"></a>
            <ul>
                <li><a href="<?php echo $hotellistPath ?>#divImgOte"><img src="<?php echo $path ?>images/navOoteOn.png" alt="PLACID大手町" width="198" height="62"></a></li>
                <li><a href="<?php echo $hotellistPath ?>#divImgKudan"><img src="<?php echo $path ?>images/navKudanOn.png" alt="PLACID九段下" width="198" height="62"></a></li>
            </ul>
        </li>
        <li id="navAccess"><a href="<?php echo $accessPath ?>" class="rollover"><img src="<?php echo $path ?>images/navAccessOff.png" alt="アクセス" width="198" height="62"></a></li>
    </ul>
</div>
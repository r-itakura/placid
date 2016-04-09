<!-- 空室検索Start -->
<input type="hidden" id="hdnSelHtlId" name="hdnSelHtlId">
<input type="hidden" id="hdnSelRsvDY" name="hdnSelRsvDY">
<input type="hidden" id="hdnSelRsvDM" name="hdnSelRsvDM">
<input type="hidden" id="hdnSelRsvDD" name="hdnSelRsvDD">
<input type="hidden" id="hdnSelRsvDNum" name="hdnSelRsvDNum">
<input type="hidden" id="hdnSelGstNum" name="hdnSelGstNum">
<input type="hidden" id="hdnChkNoSmk" name="hdnChkNoSmk">
<?php
	// 空室検索
	$lblSearchPath = "";
	$btnSearchPath = "";
	$last_include_path = str_replace("/", "", strrchr($_SERVER["SCRIPT_NAME"], "/"));
	if($last_include_path === "index.php"){
		// index.phpから呼び出された場合
		$lblSearchPath = "images/lblSearch.png";
		$btnSearchPath = "images/btnSearch.png";
	}else{
		// index.php以外から呼び出された場合
		$lblSearchPath = "../images/lblSearch.png";
		$btnSearchPath = "../images/btnSearch.png";
	}
	echo "<div id='divSearchInner'>";
	echo "<div id='divLblSearch'><img src='".$lblSearchPath."' alt='空室検索' width='64' height='15'></div>";
	echo "<table id='tblSearch' class='clsSearch'><tr><td>ホテル</td><td><span class='clsMargin20'>チェックイン</span></td><td><span class='clsMargin20'>ご宿泊日数</span></td><td><span class='clsMargin20'>人数</span></td><td><span class='clsMargin20'>禁煙</span></td><td id='tdBtnSearch' rowspan='2'><span class='clsMargin80'><input type='image' src='".$btnSearchPath."' value='検索' alt='検索' onclick='fncSearch(this.form.id);'></span></td></tr>";
	echo "<tr>";
	// ホテル名セレクトボックス
	echo "<td><select id='selHtlId' name='selHtlId' tabindex='1'>";
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		echo "<option value=".$row["HOTEL_ID"].">".$row["HOTEL_NM"]."</option>";
	}
	echo "</select></td>";
	
	$today = getdate();
	$year = $today['year'];
	$month = 1;
	$day = 1;
	
	// 年セレクトボックス
	$i = 0;
	echo "<td><span class='clsMargin20'><select id='selRsvDY' name='selRsvDY' tabindex='2'>";
	for($i = 0; $i < 5; $i++){
		echo "<option value=".$year.">".$year."</option>";
		$year++;
	}
	echo "</select></span><span class='clsMargin10'>年</span>";
	
	// 月セレクトボックス
	$j = 0;
	echo "<span class='clsMargin15'><select id='selRsvDM' name='selRsvDM' tabindex='3'>";
	for($j = 0; $j < 12; $j++){
		echo "	<option value=".$month.">".$month."</option>";
		$month++;
	}
	echo "</select></span><span class='clsMargin10'>月</span>";
	
	// 日セレクトボックス
	$k = 0;
	echo "<span class='clsMargin15'><select id='selRsvDD' name='selRsvDD' tabindex='4'>";
	for($k = 0; $k < 31; $k++){
		echo "	<option value=".$day.">".$day."</option>";
		$day++;
	}
	echo "</select></span><span class='clsMargin10'>日</span></td>";
	
	// 宿泊日数セレクトボックス
	$l = 0;
	$rsvDNum = 1;
	echo "<td><span class='clsMargin20'><select id='selRsvDNum' name='selRsvDNum' tabindex='5'>";
	for($l = 0; $l < 10; $l++){
		echo "	<option value=".$rsvDNum.">".$rsvDNum."</option>";
		$rsvDNum++;
	}
	echo "</select></span></td>";
	
	// 人数セレクトボックス
	$m = 0;
	$gstNum = 1;
	echo "<td><span class='clsMargin20'><select id='selGstNum' name='selGstNum' tabindex='6'>";
	for($l = 0; $l < 2; $l++){
		echo "	<option value=".$gstNum.">".$gstNum."</option>";
		$gstNum++;
	}
	echo "</select></span></td>";
?>
<td><span class='clsMargin20'><input type="checkbox" id="chkNoSmk" name="chkNoSmk" value="chkNoSmk"/></span></td>
<td></td>
</tr>
</table>
</div>
<!-- 空室検索End -->
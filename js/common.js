// ナビゲーション初期設定
$(function() {
	$("#ulNavBtn li").hover(function() {
		$(this).children('ul').show();
	}, function() {
		$(this).children('ul').hide();
	});
});
// 検索ボタン押下
function fncSearch(formId){

	// 検索条件をhiddenに詰める。
	$("#hdnSelHtlId").val($("select[id='selHtlId']").val());
	$("#hdnSelRsvDY").val($("select[id='selRsvDY']").val());
	$("#hdnSelRsvDM").val($("select[id='selRsvDM']").val());
	$("#hdnSelRsvDD").val($("select[id='selRsvDD']").val());
	$("#hdnSelRsvDNum").val($("select[id='selRsvDNum']").val());
	$("#hdnSelGstNum").val($("select[id='selGstNum']").val());
	if($('#chkNoSmk').is(':checked')){
		$("#hdnChkNoSmk").val(true);
	}else{
		$("#hdnChkNoSmk").val(false);
	}
	
	$("#hdnTrans").val("search");

	$("#" + formId).submit();
	
}
// 管理者ログインボタン押下
function fncAdmLogin(){
	$("#hdnTrans").val("admlogin");
	$("#frmIndex").submit();
	
}
// ロールオーバー
$(function(){	
	$('.rollover').each(function(){
		var navBtn = $(this).find("img");
		
		var srcOff = navBtn.attr("src");
		var srcOn = srcOff.replace("Off", "On");

		$(this).hover(function(){
			navBtn.attr("src", srcOn);
		}, function(){
			navBtn.attr("src", srcOff);
		});
		
	});
});
// 予約取消・お問い合わせボタン押下
function fncContact(){
	$("#hdnTrans").val("contact");
	$("#frmIndex").submit();
	
}
// バイト数を取得する
function getByte(aStr){
 if(aStr.length == 0){return 0;}
 var count = 0;
 var Str = "";
 for(var i=0;i <aStr.length;i++){
   Str = aStr.charAt(i);
   Str = escape(Str);
   if( Str.length  < 4 ){
     count = count + 1;
   }else{
     count = count + 2;
   }
 }
 return count;
}
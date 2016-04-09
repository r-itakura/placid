<?php
class Logout{
	// コンストラクタ
    function Logout() {
		// 何もしない
    }
	function destroy(){
		// セッション破棄
		$_SESSION = array(); 
		session_destroy();
	}
}
?>
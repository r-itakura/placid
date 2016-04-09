<?php
	session_start ();
	require "DBAccessorClass.php";
		
	// ログイン状態のチェック
	if (!isset($_SESSION["SES_ADM_ID"])) {
		header("Location: ../contents/admLogin.php");
	 	exit;
	}

	// 一覧から送られてきた予約IDを取得する。
	$rsvId = $_SESSION['delRsvId'];

	// セッションの削除
	unset($_SESSION['delRsvId']);
	
	// 宿泊予約キャンセル処理
	$dbAccessor = new DBAccessor();
	$dbAccessor->modifyCancelFlg($rsvId);

	// 宿泊予約一覧画面へ遷移
	header("Location: ../contents/admRsvList.php");
		
?>
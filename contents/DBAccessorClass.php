<?php
require "DBConnectionClass.php";
class DBAccessor{
	// 宿泊予約件数取得
	function getRsvListCount(){
		try{
			$flgCon = false;
			$ret = 0;
			
			// DB接続取得
			$dbCon = new DBConnectionClass();
			
			// 一覧件数取得SQL作成
			$strSqlCnt = "select ";
			$strSqlCnt .= "  count(*) as COUNT ";
			$strSqlCnt .= "from ";
			$strSqlCnt .= "  TRESERVE ";
			$strSqlCnt .= "  inner join TGUEST on TRESERVE.GUEST_ID = TGUEST.GUEST_ID ";
			$strSqlCnt .= "  left outer join TPLAN on TRESERVE.PLAN_ID = TPLAN.PLAN_ID ";
			$strSqlCnt .= "where cast(TRESERVE.RSV_D as date) >= current_date ";
			
			// SQL実行
			$stmtCnt = $dbCon->prepare($strSqlCnt);
			$stmtCnt->execute();
			$rowCnt = $stmtCnt->fetch(PDO::FETCH_ASSOC);
			
			if($rowCnt != NULL){
				$ret =  $rowCnt["COUNT"];
			}
			
			// DB接続終了
			$flgCon = $dbCon->close();
			
			return $ret;
			
		}catch(Exception $e){
			if(!$flgCon){
				// DB接続終了
				$dbCon->close();
			}

			$_SESSION['fatalErrMsg'] = $e->getMessage();
			header("Location: error.php");
    		die();
		}
	}
	// 宿泊予約一覧取得
	function getRsvList(){
		try{
			$flgCon = false;
			$ret = 0;
			
			// DB接続取得
			$dbCon = new DBConnectionClass();
			
			// 一覧取得SQL文作成
			$strSql = "select ";
			$strSql .= "  TRESERVE.RESERVE_ID, ";
			$strSql .= "  TGUEST.SEI, ";
			$strSql .= "  TGUEST.MEI, ";
			$strSql .= "  TRESERVE.RSV_D, ";
			$strSql .= "  TPLAN.PLAN_TITLE, ";
			$strSql .= "  TRESERVE.PRICE, ";
			$strSql .= "  TRESERVE.CANCEL_FLG ";
			$strSql .= "from ";
			$strSql .= "  TRESERVE ";
			$strSql .= "  inner join TGUEST on TRESERVE.GUEST_ID = TGUEST.GUEST_ID ";
			$strSql .= "  left outer join TPLAN on TRESERVE.PLAN_ID = TPLAN.PLAN_ID ";
			$strSql .= "where cast(TRESERVE.RSV_D as date) >= current_date ";
			$strSql .= "order by TRESERVE.RSV_D asc, TRESERVE.RESERVE_ID asc ";
			
			// SQL実行
			$stmt = $dbCon->prepare($strSql);
			$stmt->execute();
			
			// DB接続終了
			$flgCon = $dbCon->close();
			
			return $stmt;
			
		}catch(Exception $e){
			if(!$flgCon){
				// DB接続終了
				$dbCon->close();
			}

			$_SESSION['fatalErrMsg'] = $e->getMessage();
			header("Location: error.php");
    		die();
		}
	}
	// ログインチェック
	function checkLogin($admId, $admPass){
		try{
			$flgCon = false;
			$ret = false;

			// DB接続取得
			$dbCon = new DBConnectionClass();
			
			// SQL実行
			$stmt = $dbCon->prepare("select * from TADMIN where ADM_ID = ?");
			$stmt->execute(array($admId));
			$flg = false;
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				if($admId === $row["ADM_ID"]){
					// 入力条件に合致する管理者IDが存在する場合
					if (crypt($admPass, $row["ADM_PASS"]) == $row["ADM_PASS"]) {
						// パスワードが合致する場合
						// セッションIDを新規に発行する
						session_regenerate_id(TRUE);
						$_SESSION["SES_ADM_ID"] = $row["ADM_ID"];	
								
						$ret = true;
						break;
					}
				}
			}
			
			// DB接続終了
			$flgCon = $dbCon->close();
			
			return $ret;
			
		}catch(Exception $e){
			if(!$flgCon){
				// DB接続終了
				$dbCon->close();
			}

			$_SESSION['fatalErrMsg'] = $e->getMessage();
			header("Location: error.php");
    		die();
		}
	}
	// メールアドレス重複登録チェック
	function checkDuplMailAddr($mailAddr){
		try{
			$flgCon = false;
			$ret = false;
			
			// DB接続取得
			$dbCon = new DBConnectionClass();
			
			// SQL実行
			$stmt = $dbCon->prepare("select count(*) as COUNT from TGUEST where EMAIL = ? and DATE_FORMAT(REG_DT,'%Y%m%d') >= current_date");
			$stmt->execute(array($mailAddr));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if($row != NULL && $row["COUNT"] === "0"){
				// 取得件数が0の場合
				$ret = true;
			}

			// DB接続終了
			$flgCon = $dbCon->close();

			return $ret;
			
		}catch(Exception $e){
			if(!$flgCon){
				// DB接続終了
				$dbCon->close();
			}

			$_SESSION['fatalErrMsg'] = $e->getMessage();
			header("Location: error.php");
    		die();
		}
	}
	// 宿泊予約キャンセル処理
	function modifyCancelFlg($rsvId){
		try{
			$flgCon = false;
			
			// DB接続取得
			$dbCon = new DBConnectionClass();
			
			// キャンセルフラグ更新SQL文作成
			$strSql = "UPDATE TRESERVE SET  ";
			$strSql .= "  TRESERVE.CANCEL_FLG = '1' ";
			$strSql .= "WHERE TRESERVE.RESERVE_ID = ? ";
			
			// SQL実行
			$stmt = $dbCon->prepare($strSql);
			$stmt->execute(array($rsvId));
			
			// DB接続終了
			$flgCon = $dbCon->close();
			
		}catch(Exception $e){
			if(!$flgCon){
				// DB接続終了
				$dbCon->close();
			}

			$_SESSION['fatalErrMsg'] = $e->getMessage();
			header("Location: error.php");
    		die();
		}
	}
	// 予約取消対象情報取得
	function getRsvDelInfo($rsvId){
		try{
			$flgCon = false;
			$ret = false;
			
			// DB接続取得
			$dbCon = new DBConnectionClass();
			
			// 予約取消対象取得SQL文作成
			$strSql = "select ";
			$strSql .= "  TRESERVE.RESERVE_ID, ";
			$strSql .= "  TGUEST.SEI, ";
			$strSql .= "  TGUEST.MEI, ";
			$strSql .= "  TRESERVE.RSV_D, ";
			$strSql .= "  TPLAN.PLAN_TITLE, ";
			$strSql .= "  TRESERVE.PRICE, ";
			$strSql .= "  TRESERVE.CANCEL_FLG ";
			$strSql .= "from ";
			$strSql .= "  TRESERVE ";
			$strSql .= "  inner join TGUEST on TRESERVE.GUEST_ID = TGUEST.GUEST_ID ";
			$strSql .= "  left outer join TPLAN on TRESERVE.PLAN_ID = TPLAN.PLAN_ID ";
			$strSql .= "where TRESERVE.RESERVE_ID = ? ";
			
			// SQL実行
			$stmt = $dbCon->prepare($strSql);
			$stmt->execute(array($rsvId));
			
			// DB接続終了
			$flgCon = $dbCon->close();
			
			return $stmt;
			
		}catch(Exception $e){
			if(!$flgCon){
				// DB接続終了
				$dbCon->close();
			}

			$_SESSION['fatalErrMsg'] = $e->getMessage();
			header("Location: error.php");
    		die();
		}
	}
	// ホテルリスト取得
	function getHotelList(){
		try{
			$flgCon = false;
			$ret = false;
			
			// DB接続取得
			$dbCon = new DBConnectionClass();
			
			// 予約取消対象取得SQL文作成
			$strSql = "select ";
			$strSql .= "  THOTEL.HOTEL_ID, ";
			$strSql .= "  THOTEL.HOTEL_NM ";
			$strSql .= "from ";
			$strSql .= "  THOTEL ";
			
			// SQL実行
			$stmt = $dbCon->prepare($strSql);
			$stmt->execute();
			
			// DB接続終了
			$flgCon = $dbCon->close();
			
			return $stmt;
			
		}catch(Exception $e){
			if(!$flgCon){
				// DB接続終了
				$dbCon->close();
			}

			$_SESSION['fatalErrMsg'] = $e->getMessage();
			header("Location: contents/error.php");
    		die();
		}
	}
	// プラン一覧件数取得
	function getPlanListCount($htlId, $smkFlg, $gstNum, $rsvD){
		try{
			$flgCon = false;
			$ret = false;
			
			// DB接続取得
			$dbCon = new DBConnectionClass();
			
			// 部屋テーブルとプランテーブルから条件に合うプラン件数を取得
			$strSqlRmCnt = "select ";
			$strSqlRmCnt .= " COUNT(*) as COUNT ";
			$strSqlRmCnt .= "from ";
			$strSqlRmCnt .= " TROOM ";
			$strSqlRmCnt .= " INNER JOIN TPLAN ON ";
			$strSqlRmCnt .= " TROOM.PLAN_ID_1 = TPLAN.PLAN_ID ";
			$strSqlRmCnt .= " or TROOM.PLAN_ID_2 = TPLAN.PLAN_ID  ";
			$strSqlRmCnt .= "where ";
			$strSqlRmCnt .= " (TROOM.RESERVE_ID IS NULL || TROOM.RESERVE_ID = 0) ";
			$strSqlRmCnt .= " and TROOM.HOTEL_ID = ? ";
			$strSqlRmCnt .= " and TROOM.NOSMOKE_FLG = ? ";
			$strSqlRmCnt .= " and TROOM.ABLE_GUEST_NUM >= ? ";
			$strSqlRmCnt .= " and cast(TPLAN.PLAN_ST_D as date) <= cast(? as date) ";
			$strSqlRmCnt .= " and cast(TPLAN.PLAN_ED_D as date) >= cast(? as date) ";
			$strSqlRmCnt .= " and cast(? as date) >= current_date ";
			
			// SQL実行
			$stmtPlnListCnt = $dbCon->prepare($strSqlRmCnt);
			$stmtPlnListCnt->execute(array($htlId,  $smkFlg, $gstNum, $rsvD, $rsvD, $rsvD));
			$rowCnt = $stmtPlnListCnt->fetch(PDO::FETCH_ASSOC);
			
			if($rowCnt != NULL){
				$ret =  $rowCnt["COUNT"];
			}
			
			// DB接続終了
			$flgCon = $dbCon->close();
			
			return $ret;
			
		}catch(Exception $e){
			if(!$flgCon){
				// DB接続終了
				$dbCon->close();
			}

			$_SESSION['fatalErrMsg'] = $e->getMessage();
			header("Location: error.php");
    		die();
		}
	}
	// プラン一覧取得
	function getPlanList($htlId, $smkFlg, $gstNum, $rsvD){
		try{
			$flgCon = false;
			$ret = false;

			// DB接続取得
			$dbCon = new DBConnectionClass();
			
			// 部屋テーブルとプランテーブルから条件に合うプランを取得
			$strSqlRm = "select ";
			$strSqlRm .= " TROOM.ROOM_ID, ";
			$strSqlRm .= " TROOM.HOTEL_ID, ";
			$strSqlRm .= " TROOM.PLAN_ID_1, ";
			$strSqlRm .= " TROOM.PLAN_ID_2, ";
			$strSqlRm .= " TROOM.NOSMOKE_FLG, ";
			$strSqlRm .= " TROOM.BED_TYPE, ";
			$strSqlRm .= " TROOM.ROOM_TYPE, ";
			$strSqlRm .= " TPLAN.PLAN_ID, ";
			$strSqlRm .= " TPLAN.PLAN_TITLE, ";
			$strSqlRm .= " TPLAN.PLAN_CONTENT, ";
			$strSqlRm .= " TPLAN.PLAN_PRICE, ";
			$strSqlRm .= " TPLAN.PLAN_IMG ";
			$strSqlRm .= "from ";
			$strSqlRm .= " TROOM ";
			$strSqlRm .= " INNER JOIN TPLAN ON ";
			$strSqlRm .= " TROOM.PLAN_ID_1 = TPLAN.PLAN_ID ";
			$strSqlRm .= " or TROOM.PLAN_ID_2 = TPLAN.PLAN_ID  ";
			$strSqlRm .= "where ";
			$strSqlRm .= " (TROOM.RESERVE_ID IS NULL || TROOM.RESERVE_ID = 0) ";
			$strSqlRm .= " and TROOM.HOTEL_ID = ? ";
			$strSqlRm .= " and TROOM.NOSMOKE_FLG = ? ";
			$strSqlRm .= " and TROOM.ABLE_GUEST_NUM >= ? ";
			$strSqlRm .= " and cast(TPLAN.PLAN_ST_D as date) <= cast(? as date) ";
			$strSqlRm .= " and cast(TPLAN.PLAN_ED_D as date) >= cast(? as date) ";
			$strSqlRm .= " and cast(? as date) >= current_date ";
			
			// SQL実行
			$stmtPlnList = $dbCon->prepare($strSqlRm);
			$stmtPlnList->execute(array($htlId,  $smkFlg, $gstNum, $rsvD, $rsvD, $rsvD));

			// DB接続終了
			$flgCon = $dbCon->close();
			
			return $stmtPlnList;
			
		}catch(Exception $e){
			if(!$flgCon){
				// DB接続終了
				$dbCon->close();
			}

			$_SESSION['fatalErrMsg'] = $e->getMessage();
			header("Location: error.php");
    		die();
		}
	}
	// 予約登録
	function insertReserve($htlId, $plnId, $gstNum, $rsvD, $rsvDNum, $price, $rmId, $sei, $mei, $seikana, $meikana, $mail, $tel, $sex){
		try{
			$flgCon = false;
			$ret = false;
			
			// DB接続取得
			$dbCon = new DBConnectionClass();
			
			//****************************
			// 予約IDと宿泊者IDの採番
			//****************************
			// 予約ID採番
			$newrsvid = 0;
			$stmtRsvId = $dbCon->prepare("select ifnull(MAX(RESERVE_ID), 0) as MAX_RSV_ID from TRESERVE");
			$stmtRsvId->execute();
			
			$rowRsvId = $stmtRsvId->fetch(PDO::FETCH_ASSOC);
			if($rowRsvId != NULL){
				// 新規採番
				$newrsvid = $rowRsvId["MAX_RSV_ID"] + 1;
			}
			
			// 宿泊者IDの採番
			// 宿泊者ID採番
			$newgstid = 0;
			$stmtGstId = $dbCon->prepare("select ifnull(MAX(GUEST_ID), 0) as MAX_GUEST_ID from TGUEST");
			$stmtGstId->execute();
			
			$rowGstId = $stmtGstId->fetch(PDO::FETCH_ASSOC);
			if($rowGstId != NULL){
				// 新規採番
				$newgstid = $rowGstId["MAX_GUEST_ID"] + 1;
			}
			
			//********************************
			// 予約テーブル登録
			//********************************
			// 予約登録SQL文作成
			$strSql = "insert into TRESERVE( ";
			$strSql .= " RESERVE_ID, ";
			$strSql .= " HOTEL_ID, ";
			$strSql .= " GUEST_ID, ";
			$strSql .= " PLAN_ID, ";
			$strSql .= " GUEST_NUM, ";
			$strSql .= " RSV_D, ";
			$strSql .= " RSV_D_NUM, ";
			$strSql .= " PRICE, ";
			$strSql .= " CANCEL_FLG, ";
			$strSql .= " REG_DT, ";
			$strSql .= " UPD_DT ";
			$strSql .= " ) VALUES ( ";
			$strSql .= " ?, ";
			$strSql .= " ?, ";
			$strSql .= " ?, ";
			$strSql .= " ?, ";
			$strSql .= " ?, ";
			$strSql .= " ?, ";
			$strSql .= " ?, ";
			$strSql .= " ?, ";
			$strSql .= " ?, ";
			$strSql .= " SYSDATE(), ";
			$strSql .= " SYSDATE() ";
			$strSql .= " ) ";
			
			// SQL実行
			$stmt = $dbCon->prepare($strSql);
			$stmt->execute(array($newrsvid, $htlId, $newgstid, $plnId, $gstNum, $rsvD, $rsvDNum, $price, "0"));
			
			//********************************
			// 宿泊者テーブル登録
			//********************************			
			// 宿泊者登録SQL文作成
			$strSqlGst = "insert into TGUEST( ";
			$strSqlGst .= " GUEST_ID, ";
			$strSqlGst .= " SEI, ";
			$strSqlGst .= " MEI, ";
			$strSqlGst .= " SEIKN, ";
			$strSqlGst .= " MEIKN, ";
			$strSqlGst .= " EMAIL, ";
			$strSqlGst .= " TEL, ";
			$strSqlGst .= " SEX, ";
			$strSqlGst .= " REG_DT, ";
			$strSqlGst .= " UPD_DT ";
			$strSqlGst .= " ) VALUES ( ";
			$strSqlGst .= " ?, ";
			$strSqlGst .= " ?, ";
			$strSqlGst .= " ?, ";
			$strSqlGst .= " ?, ";
			$strSqlGst .= " ?, ";
			$strSqlGst .= " ?, ";
			$strSqlGst .= " ?, ";
			$strSqlGst .= " ?, ";
			$strSqlGst .= " SYSDATE(), ";
			$strSqlGst .= " SYSDATE() ";
			$strSqlGst .= " ) ";
			
			// SQL実行
			$stmtGst = $dbCon->prepare($strSqlGst);
			$stmtGst->execute(array($newgstid, $sei, $mei, $seikana, $meikana, $mail, $tel, $sex));
			
			//********************************
			// 部屋テーブル更新
			//********************************			
			// 部屋テーブルの予約IDを更新するSQL文作成
			$strSqlUpdRm = "UPDATE TROOM SET  ";
			$strSqlUpdRm .= "  TROOM.RESERVE_ID = ? ";
			$strSqlUpdRm .= "WHERE TROOM.ROOM_ID = ? ";
			
			$stmtUpdRm = $dbCon->prepare($strSqlUpdRm);
			
			// SQL実行
			$stmtUpdRm->execute(array($newrsvid, $rmId));
			
			// DB接続終了
			$flgCon = $dbCon->close();
			
		}catch(Exception $e){
			if(!$flgCon){
				// DB接続終了
				$dbCon->close();
			}

			$_SESSION['fatalErrMsg'] = $e->getMessage();
			header("Location: error.php");
    		die();
		}
	}
	// プランタイトル、プラン金額取得
	function getPlnInfo($rsvPlnId){
		try{
			$flgCon = false;
			$ret = 0;
			
			// DB接続取得
			$dbCon = new DBConnectionClass();
			
			// プランタイトル、プラン金額取得SQL作成
			$strSql = "select ";
			$strSql .= "  TPLAN.PLAN_TITLE, ";
			$strSql .= "  TPLAN.PLAN_PRICE ";
			$strSql .= "from ";
			$strSql .= "  TPLAN ";
			$strSql .= "where ";
			$strSql .= "  TPLAN.PLAN_ID = ? ";
			
			// SQL実行
			$stmt = $dbCon->prepare($strSql);
			$stmt->execute(array($rsvPlnId));
			
			// DB接続終了
			$flgCon = $dbCon->close();
			
			return $stmt;
			
		}catch(Exception $e){
			if(!$flgCon){
				// DB接続終了
				$dbCon->close();
			}

			$_SESSION['fatalErrMsg'] = $e->getMessage();
			header("Location: error.php");
    		die();
		}
	}
	// 管理者登録済みチェック
	function checkAdmRgst($admId){
		try{
			$flgCon = false;
			$ret = true;

			// DB接続取得
			$dbCon = new DBConnectionClass();
			
			// SQL実行
			$stmt = $dbCon->prepare("select * from TADMIN where ADM_ID = ?");
			$stmt->execute(array($admId));
			$flg = false;
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				if($admId === $row["ADM_ID"]){
					// 入力条件に合致する管理者IDが存在する場合。							
					$ret = false;
					break;
				}
			}
			
			// DB接続終了
			$flgCon = $dbCon->close();
			
			return $ret;
			
		}catch(Exception $e){
			if(!$flgCon){
				// DB接続終了
				$dbCon->close();
			}

			$_SESSION['fatalErrMsg'] = $e->getMessage();
			header("Location: error.php");
    		die();
		}
	}
	// 管理者登録
	function insertAdm($admId, $admNm, $pass_hash){
		try{
			$flgCon = false;
			$ret = false;
			
			// DB接続取得
			$dbCon = new DBConnectionClass();
			
			//********************************
			// 管理者テーブル登録
			//********************************
			// 管理者登録SQL文作成
			$strSql = "insert into TADMIN( ";
			$strSql .= " ADM_ID, ";
			$strSql .= " ADM_NM, ";
			$strSql .= " ADM_PASS, ";
			$strSql .= " REG_DT, ";
			$strSql .= " UPD_DT ";
			$strSql .= " ) VALUES ( ";
			$strSql .= " ?, ";
			$strSql .= " ?, ";
			$strSql .= " ?, ";
			$strSql .= " SYSDATE(), ";
			$strSql .= " SYSDATE() ";
			$strSql .= " ) ";
			
			// SQL実行
			$stmt = $dbCon->prepare($strSql);
			$stmt->execute(array($admId, $admNm, $pass_hash));
			
			// DB接続終了
			$flgCon = $dbCon->close();
			
		}catch(Exception $e){
			if(!$flgCon){
				// DB接続終了
				$dbCon->close();
			}

			$_SESSION['fatalErrMsg'] = $e->getMessage();
			header("Location: error.php");
    		die();
		}
	}
}
?>
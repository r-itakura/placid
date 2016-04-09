<?php
class DBConnectionClass {

    var $dbh;

    // コンストラクタ
    function DBConnectionClass() {
		$dsn = 'mysql:dbname=site80_dev01;host=localhost';
		$user = 'site80_dev01';
		$password = 'site80_dev01';
		
		global $dbh;
		try{
    		$dbh = new PDO($dsn, $user, $password);
			$dbh->query("SET NAMES utf8;");
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch (PDOException $e){
			$_SESSION['fatalErrMsg'] = "Connection failed:".$e->getMessage();
			header("Location: contents/error.php");
			die();
		}
    }
	
	// PreparedStatement
	function prepare($sql){
		global $dbh;
		$stmt =  $dbh->prepare($sql);
		return $stmt;
	}

    // 切断
    function close() {
		global $dbh;
        $dbh = NULL;
		return true;
    }
}
?>
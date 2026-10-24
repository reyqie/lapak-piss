<?php
	session_start();
	include "connection.php";

	function antiInjection($data){
		$filter_sql = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
		return $filter_sql;
	}

	$login	= mysql_query("select username, role from admin 
			where username	= '".antiinjection($_POST["user"])."' and 
				password	= '".antiinjection($_POST["pass"])."' and
				lapak	 	= 'Yes'");
	$ketemu	= mysql_num_rows($login);
	$r		= mysql_fetch_array($login);
	
	if($ketemu==1){
		$_SESSION['username'] 	= $r['username'];
		$_SESSION['role'] 		= $r['role'];
		include "components/welcome_animation.php";
		echo "<script>setTimeout(function() { window.location.href = 'dashboard.php'; }, 3250);</script>";
		exit();
	}
	else{
		echo "<script>window.alert('Anda Tidak Memiliki Hak Untuk Masuk!');
			window.history.back()</script>";
		exit();
	}
?>
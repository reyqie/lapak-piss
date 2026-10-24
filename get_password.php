<?php
	session_start();
	include "connection.php";

	if (isset($_POST['username']) && isset($_POST['role'])) {
		$username = $_POST['username'];
		$role = $_POST['role'];

		if ($role == 'spv' || $role == 'pp') { 
			$query = "SELECT password FROM admin WHERE username = '$username' AND role = '$role'";
			$result = mysql_query($query);
			if ($result) {
				$row = mysql_fetch_assoc($result);
				if ($row) {
					echo $row['password'];
				} else {
					echo "Password tidak ditemukan";
				}
			} else {
				echo "Terjadi kesalahan dalam query: " . mysql_error();
			}
		} else {
			echo "Role tidak valid";
		}
	}
?>
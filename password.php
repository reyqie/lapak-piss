<style>
.password-wrapper {
	position: relative;
	width: 100%;
}
.password-wrapper input {
	padding-right: 40px; /* kasih ruang buat ikon */
}
.password-wrapper .toggle-password {
	position: absolute;
	right: 10px;
	top: 50%;
	transform: translateY(-50%);
	background: none;
	border: none;
	color: #666;
	cursor: pointer;
}
.password-wrapper .toggle-password:hover {
	color: #000;
}
</style>

<?php
	session_start();
	include "connection.php";
?>
<form action="update_password.php?user=<?php echo $_SESSION['username']; ?>" class="form-horizontal" method="post">
	<table class="table table-hover">
		<tbody>
			<tr>
				<td style="border: none;">
					<b>Username</b><br>
					<input style="margin-top: 5px;" type="text" class="form-control" value="<?php echo $_SESSION['username']; ?>" readonly>
				</td>
			</tr>

			<!-- Password Lama -->
			<tr>
				<td style="border: none;">
					<b>Password Lama</b><br>
					<div class="password-wrapper" style="margin-top:5px;">
						<input type="password" class="form-control" id="pass" name="pass" placeholder="Password Lama" />
						<button type="button" class="toggle-password" onclick="togglePassword('pass', this)">
							<i class="fa fa-eye-slash text-primary"></i>
						</button>
					</div>
				</td>
			</tr>

			<!-- Password Baru -->
			<tr>
				<td style="border: none;">
					<b>Password Baru</b><br>
					<div class="password-wrapper" style="margin-top:5px;">
						<input type="password" class="form-control" id="pass1" name="pass1" placeholder="Password Baru" />
						<button type="button" class="toggle-password" onclick="togglePassword('pass1', this)">
							<i class="fa fa-eye-slash text-primary"></i>
						</button>
					</div>
				</td>
			</tr>

			<!-- Ulangi Password Baru -->
			<tr>
				<td style="border: none;">
					<b>Ulangi Password Baru</b><br>
					<div class="password-wrapper" style="margin-top:5px;">
						<input type="password" class="form-control" id="pass2" name="pass2" placeholder="Ulangi Password Baru" />
						<button type="button" class="toggle-password" onclick="togglePassword('pass2', this)">
							<i class="fa fa-eye-slash text-primary"></i>
						</button>
					</div>
				</td>
			</tr>

			<tr>
				<td style="border: none;">
					<button type="submit" class="btn btn-block btn-primary">Simpan</button>
				</td>
			</tr>
		</tbody>
	</table>
</form>

<script>
function togglePassword(id, btn) {
	const input = document.getElementById(id);
	const icon = btn.querySelector('i');

	if (input.type === "password") {
		input.type = "text";
		icon.classList.remove("fa-eye-slash");
		icon.classList.add("fa-eye");
	} else {
		input.type = "password";
		icon.classList.remove("fa-eye");
		icon.classList.add("fa-eye-slash");
	}
}
</script>
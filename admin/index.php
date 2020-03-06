<?php
	require_once '../load.php';
	confirm_logged_in();
	verify_user();
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
	
<body>
<h2> Welcome! <?php echo $_SESSION['user_name'];?></h2>

<a href="admin_createuser.php">Create User</a>
<a href="admin_edituser.php">Edit User</a>
<a href="admin_logout.php">Logout</a>

 

    <script>
	var day = new Date();
	var hr = day.getHours();
	if (hr <= 12) {
	 document.write("Good morning! ");
	}
	if (hr <= 16) {
	 document.write("Good afternoon! ");
	}
	if (hr > 17) {
	 document.write("Good evening! ");
	}</script>
	Admin
</h2>

// <a href="admin_logout.php">Sign Out</a>
</body>
</html>
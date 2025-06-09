<?php
include("config.php");
session_start();

header("X-Frame-Options: DENY");  // Clickjacking 방지

//get post parameters

$user = mysqli_real_escape_string($db, $_POST['username']);
$old = mysqli_real_escape_string($db, $_POST['oldpasswd']);
$new = mysqli_real_escape_string($db, $_POST['newpasswd']);
$csrf = mysqli_real_escape_string($db, $_POST['csrf_token']);

//check session else redirect to login page
$check=$_SESSION['login_user'];
if($check==NULL)
{
	header("Location: /index.php");
}

//check values else redirect to settings page
if($check!=NULL && ($user==NULL || $old==NULL || $new==NULL) )
{
header("Location: /settings.php");	
}

// CSRF 감지
if ($_SESSION['csrf'] == $csrf) {

	if ( $check == $user) { // 진짜 사용자 확인
		//update password 

		$sql="UPDATE register set password='$new' where username='$user' AND password='$old'";

		echo htmlentities($sql);
		echo "</br>";

		$result=mysqli_query($db, $sql) or die('Error querying database.');

		if( mysqli_affected_rows($db)>0)
		{
			echo "<h2>Password updated successfully</h2>";
		}
		else {
			echo "<h2>Incorrect Password</h2>";
		}
	} else {
		echo "<h2>You are not authorized to change other user's passwords.</h2>";
	}
} else {
	echo "<h2>CSRF detected! Get out!</h2>";
}


mysqli_close($db);

?>

<html>
<body>
</br>

<a href="/settings.php" > <h3>Go back</h3> </a>

</body>
</html>

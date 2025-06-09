<?php
include("config.php");
session_start();

header("X-Frame-Options: DENY");  // Clickjacking 방지

//get post parameters
$user = mysqli_real_escape_string($db, $_SESSION['login_user']); //getting username from session 
$em = mysqli_real_escape_string($db, $_POST['email']);
$gen = mysqli_real_escape_string($db, $_POST['gender']);
$csrf = mysqli_real_escape_string($db, $_POST['csrf_token']);  // CSRF 방지

//check session else redirect to login page
$check=$_SESSION['login_user'];
if($check==NULL )
{
	header("Location: /index.php");
}

//check values else redirect to settings page
if($check!=NULL && ($em==NULL || $gen==NULL) )
{
header("Location: /settings.php");	
}

// CSRF detection
if($_SESSION['csrf'] == $csrf) {
	//update information

	$sql="UPDATE register SET  email='$em', gender='$gen' where username='$user'";
	echo htmlentities($sql);
	$result=mysqli_query($db, $sql) or die('Error querying database.');

	if( mysqli_affected_rows($db)>0)
	{
		echo "</br>";
		echo "<h2>Account updated successfully</h2>";
	}
	else {
		echo "</br>";
		echo "<h2>No modification done to profile</h2>" ;
	}
} else {
	echo "<h2>CSRF detected... Get out of here!</h2>";
}

mysqli_close($db); 

?>
<html>
<body>
</br>

<a href="/settings.php" > <h3>Go back</h3> </a>
</body>
</html>

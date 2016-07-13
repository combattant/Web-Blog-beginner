<?php 

require("config.php");

$db=mysqli_connect($dbhost, $dbuser, $dbpassword, $dbdatabase);

if(isset($_POST['submit']))
{	session_start();

	$check_user="SELECT * FROM logins WHERE username='"
	.$_POST['username']."' AND password='".$_POST['password']."';";

	$res_check_user=mysqli_query($db,$check_user);
	$num_check_user=mysqli_num_rows($res_check_user);

	if($num_check_user==1) 
	{
		$row_check_uesr=mysqli_fetch_assoc($res_check_user);

		$_SESSION['USERNAME']=$row_check_uesr['username'];
		$_SESSION['PASSWORD']=$row_check_uesr['password'];

		header("Location: ".$config_basedir);
	}	
	else {
		header("Location: ".$config_basedir."/login.php?error=1");
	}
}

else
{	
	session_start();
	require("header.php");

	if(isset($_GET['error'])) { 
		echo "Incorrect login, please try again!"; 
}

?>


<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method='post' >
<table>
<tr>
	<td>Username</td>
	<td><input type='text'  name='username'></td>
</tr>
<tr>
	<td>Password</td>
	<td><input type='password' name='password'></td>
</tr>
<tr>
	<td></td>
	<td><input type='submit' value='Login' name='submit'></td>
</tr>

</table>
</form>

<?php
}
/*
if(isset($_SESSION['USERNAME']))
{
	echo "[<a href='logout.php'>Log out</a>]";
}
// next else statement is senseless bcoz we already have form to login!!
// else
// { echo "[<a href='login.php'>Log in</a>]"; } 

if(isset($_SESSION['USERNAME']) )
	{	echo " - ";
		echo "[<a href='addentry.php'>Add entry</a>]";
		echo "[<a href='addcat.php'>Add category</a>]";
	} */
require("footer.php"); 	
?>
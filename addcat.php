<?php
//session is starting once again in header.php also!! wht to do?
session_start();
require("config.php");
$db=mysqli_connect($dbhost, $dbuser, $dbpassword, $dbdatabase);

if(isset($_SESSION['USERNAME']) == false)
{
	header("Location: ".$config_basedir);
}

if(isset($_POST['submit']))
{
	$insert_cat="INSERT INTO categories(cat) VALUES('".$_POST['cat']."');";
	$res_insert_cat=mysqli_query($db,$insert_cat);
	header("Location: ".$config_basedir."/viewcat.php");
}
else {
	require("header.php");
?>


<form action="<?php echo  $_SERVER['REQUEST_URI'] ?>" method="post">
	<table>
		<tr>
			<td>Category</td>
			<td><input type="text" name="cat"></td>
		</tr>
		<tr>
			<td></td>
			<td><input type='submit' name='submit' value='Add entry!'></td>
		</tr>
	</table>
</form>

<?php	
}
require("footer.php");
?>
<?php
// same as addcat.php and addentry.php
session_start();

require("config.php");
$db=mysqli_connect($dbhost, $dbuser, $dbpassword, $dbdatabase);


if(isset($_SESSION['USERNAME'])==FALSE)
	{ 	header("Location: ".$config_basedir); }

//validation of id
if( isset($_GET['id']) ==true )
{
	if( is_numeric($_GET['id']) == true) 
	{
		$valid_entry= $_GET['id'];
	}
	else {
		header("Location: ".config_basedir);
	}

}
else { $valid_entry=0; }

if(isset($_POST['submit']))
{
	$update_entries="UPDATE entries SET cat_id=".$_POST['cat']
			.", subject='".$_POST['subject']."', body='".$_POST['body']
			."', WHERE id=".$valid_entry.";";
	
	$res_update=mysqli_query($db, $update_entries);

	header("Location: ".$config_basedir."viewentry.php?id=".$valid_entry);
}

else
{
	require("header.php");

	$fill="SELECT * FROM entries WHERE id= ".$valid_entry.";";
	$res_fill=mysqli_query($db, $fill);
	$row_fill=mysqli_fetch_assoc($res_fill);

?>


<h1>Update Entry</h1>

<form action="<?php echo  $_SERVER['REQUEST_URI'] ?> method="post">
	<table>
		<tr>
			<td>Category</td>
			<td>
				<select name='cat'>
					<?php
					$all_cat="SELECT * FROM categories;";
					$res_all_cat=mysqli_query($db, $all_cat);
					while($row_all_cat=mysqli_fetch_assoc($res_all_cat))
					{
						echo "<option value=".$row_all_cat['id']; 
				//	if($row_all_cat['id']==$row_fill['cat_id']) 
						//	{ echo "selected"; }

						echo " >".$row_all_cat['cat']."</option>";
					} 
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Subject</td>
			<td><input type='text' name='subject' value="<?php echo $row_fill['subject']; ?>">
			</td>
		</tr>
		<tr>
			<td>Body</td>
			<td><textarea name='body' rows='10' cols='50'><?php echo $row_fill['body']; ?>
			     </textarea></td>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input type='submit' name='submit' value='Update Entry!'></td>
		</tr>
		
	</table>
</form>

<?php
}
require("footer.php");
?>
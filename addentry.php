<?php
// same prblm as in addcat.php 
session_start();

require("config.php");
$db=mysqli_connect($dbhost, $dbuser, $dbpassword, $dbdatabase);

if(isset($_SESSION['USERNAME']) == null)
{
	header("Location: ".$config_basedir);
}

if(isset($_POST['submit']))
	{
		$add_blog="INSERT INTO entries(cat_id, dateposted, subject, body) 
		VALUES('".$_POST['cat']."', NOW(), '". $_POST['subject'] ."', '".$_POST['body']."');";

		$res_add_blog=mysqli_query($db,$add_blog);
		
		header("Location: ".$config_basedir);
	}
else 
	{ require("header.php"); 
?>

<h1>Add new entry :)</h1>;
<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="POST">
	<table>
		<tr>
			<td>Category</td>
			<td>
				<select name="cat">
					<?php 
					$all_cat="SELECT * FROM categories;";
					$res_all_cat=mysqli_query($db, $all_cat);
					while($row_all_cat=mysqli_fetch_assoc($res_all_cat))
					{
						echo "<option value=".$row_all_cat['id'].">"
						.$row_all_cat['cat']."</option>";
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Subject</td>
			<td><input type='text' name='subject' ></td>
		</tr>
		<tr>
			<td>Body</td>
			<td><textarea name='body' rows='10' cols='50'></textarea></td>
		</tr>
		<tr> 
			<td></td>re
			<td><input type='submit' name='submit' value='Add entry!' ></td>
		</tr>
	</table>
</form>

<?php
}
require("footer.php");
?>
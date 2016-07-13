<?php

require("config.php");

//validation of requested url
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


//showing the blog entry
if($valid_entry==0)
{
	$show_blog="SELECT entries.*, categories.cat FROM entries, categories 
			WHERE entries.cat_id=categories.id ORDER BY dateposted DESC LIMIT 1;";
}
else {
	$show_blog="SELECT entries.*, categories.cat FROM entries, categories 
	WHERE entries.cat_id=categories.id AND entries.id=".$valid_entry." 
			ORDER BY dateposted DESC LIMIT 1;"; 
		}

$db=mysqli_connect($dbhost, $dbuser, $dbpassword, $dbdatabase);
$res_show_blog=mysqli_query($db, $show_blog);
$row_show_blog=mysqli_fetch_assoc($res_show_blog);

echo "<h2 class='heading'>".$row_show_blog['subject']."</h2></br>";
echo "In <a href='viewcat.php?id=".$row_show_blog['cat_id']."'> "
	.$row_show_blog['cat']."</a> Posted on "
	.date("D jS F Y g.iA", strtotime($row_show_blog['dateposted']))."</br>";

// giving an option to edit
	if(isset($_SESSION['USERNAME'])==true)
	{
		echo "    [<a href='updateentry.php?id=".$row_show_blog['id']."'>edit</a>]";
	}

echo '<p class="body">'.nl2br($row_show_blog['body'])."</p>";


//showing comments of a blog
$show_comm="SELECT comments.* FROM comments WHERE comments.blog_id="
		.$valid_entry." ORDER BY dateposted DESC;";

$res_show_comm=mysqli_query($db, $show_comm);
$num_rows_comm=mysqli_num_rows($res_show_comm);

if($num_rows_comm==0) {echo "No Comments. Would you like to add one!"; }
else{
	$i=1;
	while($row_show_comm=mysqli_fetch_assoc($res_show_comm))
		{
		
			echo "<a name='comment".$i."'></a>";
			echo "<h4>Comment by ".$row_show_comm['name']." on "
				.date("D jS F Y g.iA", strtotime($row_show_comm['dateposted'])).":</h4>".$row_show_comm['comment'];
			
			$i++;
		}
	}
?>

<br /><br />
 
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">

<table>
<tr>
<td> Your Name: </td>
<td> <input type="text" name="your_name"/></td>
</tr>

<tr>
<td>Comment:</td>
<td><textarea name="comment" rows="10" cols="50"></textarea></td>
</tr>

<tr>
<td colspan='2' align='middle'> <input type="submit" name="submit" value="Add Comment"/> </td>
</tr>

<?php 
//checking if submit has been clicked or not
 if(isset($_POST["submit"]))
{
	$db=mysqli_connect($dbhost, $dbuser, $dbpassword, $dbdatabase);
	$insert_comment="INSERT INTO comments( blog_id, dateposted, name, comment) 
	VALUES($valid_entry, NOW(), '".$_POST['your_name']."', '".$_POST['comment']."');";

	$res_insert_comment=mysqli_query($db, $insert_comment);
	$row_insert_comment=mysqli_fetch_assoc($res_insert_comment);


	header("Location: ".$config_basedir."/".$SCRIPT_NAME."?id=".$valid_entry);
}

 else
{	session_start();
	 require("header.php"); }

 ?>



</table>
</form>

<?php 
require("footer.php");
?>
<?php
session_start();
require("header.php");

//Displaying a blog entry

$my_query="SELECT entries.*, categories.cat FROM entries, categories 
			WHERE entries.cat_id=categories.id ORDER BY dateposted DESC LIMIT 1;";
$result=mysqli_query($db,$my_query);
$row=mysqli_fetch_assoc($result);

echo "<h2 class='heading'><a href='viewentry.php?id=". $row['id'] ."'>"
	.$row['subject']."</a></h2><br />";

echo "In <a href='viewcat.php?id=".$row['cat_id']."'>"
	.$row['cat']."</a>"." Posted on "
	.date("D jS F Y g.iA", strtotime($row['dateposted']));

// link to edit the blog
	
	if(isset($_SESSION['USERNAME']))
	{
		echo "  [<a href='updateentry.php?id=".$row['id']."'>edit</a>]";
	}

echo "<p class='body'>";
echo nl2br($row['body']);
echo "</p>";


//adding comments
echo "<p>";

$query_comments="SELECT name FROM comments 
					WHERE blog_id=".$row['id']." ORDER BY dateposted;";

$res_comm=mysqli_query($db,$query_comments);

$num_rows_comm = mysqli_num_rows($res_comm);

if($num_rows_comm==0) { echo "No Comments";}
else {
	echo "<strong>(".$num_rows_comm.")</strong>". " Comments: <br />";
	$i=1;
	while($row_comm=mysqli_fetch_assoc($res_comm))
	{
		echo "<a href='viewentry.php?id=".$row['id']."#comment".$i."'>"
		.$row_comm['name']."</a><br />";
		$i++;
	}
} 
echo "</p>";


//displaying recent entries
$prev_entries= "SELECT entries.*, categories.cat FROM entries, categories 
				WHERE entries.cat_id=categories.id ORDER BY dateposted DESC LIMIT 1,5;";

$res_prev_entries=mysqli_query($db,$prev_entries);
$num_rows_prev_entries= mysqli_num_rows($res_prev_entries);

if($num_rows_prev_entries==0) {echo " No previous entries. You didn't miss any!"; }
else {
	echo "<b>Some other blog entries:</b><ul>";
	while($row_prev_entries=mysqli_fetch_assoc($res_prev_entries))
	{
		echo "<li><a href='viewentry.php?id=".$row_prev_entries['id']."'>"
				.$row_prev_entries['subject']."</a></li>";
	} 
	echo "</ul>";
}				






require("footer.php");

?>
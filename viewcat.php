<?php

session_start();
require("header.php");
//validation of id
if(isset($_GET['id']))
{
	if(isset($_GET['id']) )
		 { $valid_cat=$_GET['id'];}
	else 
			{ header("Location: ".$config_basedir."/viewcat.php"); }
}
else { $valid_cat=0; }


//displaying list of all entries with selected category

$all_cat="SELECT * FROM categories;";
$res_all_cat= mysqli_query($db, $all_cat);

//loop to iterate through categories for matching category
while($row_all_cat=mysqli_fetch_assoc($res_all_cat))
{

	if($valid_cat==$row_all_cat['id'])
	{
		echo "<strong>".$row_all_cat['cat']."</strong><br />";

		$all_entries_cat="SELECT * FROM entries WHERE cat_id="
						.$valid_cat." ORDER BY dateposted DESC;";
		$res_all_entr_cat=mysqli_query($db, $all_entries_cat);

		$num_all_entr_cat=mysqli_num_rows($res_all_entr_cat);

		echo "<ul>";
		if($num_all_entr_cat==0) 
			{
            	echo "<li>No entries!</li>";
			}
		else 
		{
			
			//loop to iterate through all the entries of the category
			while($row_all_entr_cat=mysqli_fetch_assoc($res_all_entr_cat))
				{
					echo "<li>"
						.date("D jS F Y g.iA", strtotime($row_all_entr_cat['dateposted']) )
						." - <a href='viewentry.php?id=".$row_all_entr_cat['id']."'>"
						.$row_all_entr_cat['subject']."</a></li></br>";
				}
		}
		echo "</ul>";
	}

	//display all the unmatched categories
	else {
		echo "<a href='viewcat.php?id=".$row_all_cat['id']."'>"
		.$row_all_cat['cat']."</a><br />";
	}

}
 require("footer.php");

?>
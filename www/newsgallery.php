<?php
include("mysqlconnect.php");

$query = "SELECT images_path FROM  news_img where news_id=".$id;
$result = $conn->query($query);
	if(!$result){
				echo('Error selecting images: ' . mysql_error());
				exit();
	}
?>

<div class="slideshow-container">
	<?php
	$row = $result->fetch_assoc();
	
	{
		$id=18;
		echo '<img src='.$row["images_path"].'style="position: absolute; top: 50%; left: 50%; width: 780px; height: 600px; margin-top: -300px; margin-left: -390px;"/>';
	}
?>
</div>

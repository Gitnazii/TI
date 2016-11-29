<?php

session_start();
require_once "connect.php";

$conn=@new mysqli($host,$db_user,$db_pass,$db_name);

if($conn->connect_errno!=0)
{
	echo "Error Establishing a Database Connection".$conn->connect_errno;
}
else
{

$name=$_POST["name"];
$headline=$_POST["headline"];
$story=$_POST["story"];
$id=$_POST["id"];

$name=htmlentities($name,ENT_QUOTES,"UTF-8");
$headline=htmlentities($headline,ENT_QUOTES,"UTF-8");
$story=htmlentities($story,ENT_QUOTES,"UTF-8");

//$headline=nl2br($headline);
//$story=nl2br($story);

if(isset($_SESSION['logged']) && $_SESSION['root']==1)
	{	

		//echo $name.$headline.$story.$id;
		$query = sprintf("UPDATE news SET name = '%s', headline = '%s', story = '%s' WHERE id = %s",
		mysqli_real_escape_string($conn,$name),
		mysqli_real_escape_string($conn,$headline),
		mysqli_real_escape_string($conn,$story),
		mysqli_real_escape_string($conn,$id));
		echo $query;
	$result = $conn->query($query);
	if(!$result){
			echo 'Error updating news item: ' ;
			exit();
	}else{
			echo('Update successful!');
			sleep(2);
			header('Location:newsedit.php');
	}
	}
}
	?>
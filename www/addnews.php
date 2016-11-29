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

buildDB();	
	
$name=$_POST["name"];
$headline=$_POST["headline"];
$story=$_POST["story"];

$name=htmlentities($name,ENT_QUOTES,"UTF-8");
$headline=htmlentities($headline,ENT_QUOTES,"UTF-8");
$story=htmlentities($story,ENT_QUOTES,"UTF-8");


if(isset($_SESSION['logged']) && $_SESSION['root']==1)
	{	
	
		$conn->query(
		sprintf("INSERT INTO news(name, headline, story, timestamp)VALUES('%s', '%s', '%s', NOW())",
		mysqli_real_escape_string($conn,$name),
		mysqli_real_escape_string($conn,$headline),
		mysqli_real_escape_string($conn,$story))); 
		
		$query = "SELECT id FROM news ORDER BY timestamp DESC";
		$result = $conn->query($query);
		$row = $result->fetch_assoc();
		$id=$row["id"];
		
		/////////
	function GetImageExtension($imagetype)
{
	if(empty($imagetype)) return false;
	switch($imagetype)
	{
		case 'image/bmp': return '.bmp';
		case 'image/gif': return '.gif';
		case 'image/jpeg': return '.jpg';
		case 'image/png': return '.png';
		default: return false;
	}
}

if (!empty($_FILES["uploadedimage"]["name"])) {

	$file_name=$_FILES["uploadedimage"]["name"];
	$temp_name=$_FILES["uploadedimage"]["tmp_name"];
	$imgtype=$_FILES["uploadedimage"]["type"];
	$ext= GetImageExtension($imgtype);
	$imagename=date("d-m-Y")."-".time().$ext;
	$target_path = "news_images/".$imagename;
	$date = date("Y-m-d");
	
	if(move_uploaded_file($temp_name, $target_path))
	{
		$query_upload="INSERT into `news_img` (`news_id`,`images_path`,`submission_date`) 
		VALUES ( '".$id."','".$target_path."','".date("Y-m-d")."')";
		$conn->query($query_upload);
		//mysql_query($query_upload) or die("error in $query_upload == ----> ".mysql_error());
		//header('Location:index.php?subpage=6');
	}
	else
	{
		exit("Error While uploading image on the server");
	} 
}

////////
		
	
		header('Location:index.php?subpage=1');
	}else 
	{
		$_SESSION['error']='<span style="color:red"><br>Log in to update news.</span>';
		header('Location:index.php');
	}
}
$conn->close();

function buildDB() {
    $sql = <<<MySQL_QUERY
	CREATE TABLE IF NOT EXISTS news (
   id smallint(5) unsigned NOT NULL auto_increment,
   headline text NOT NULL,
   story text NOT NULL,
   name varchar(255),
   email varchar(255),
   timestamp datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   PRIMARY KEY (id) )
MySQL_QUERY;
 mysql_query($sql);
	$sql= "CREATE TABLE IF NOT EXISTS news ( news_id smallint(11) unsigned NOT NULL, img_id smallint(11) unsigned NOT NULL auto_increment, headline text NOT NULL, images_path varchar(200) NOT NULL, submission_date date DEFAULT NULL, PRIMARY KEY (img_id))";
return mysql_query($sql);
  }

?> 
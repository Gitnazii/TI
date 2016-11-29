<?php
include("mysqlconnect.php");
	
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
	$target_path = "images/".$imagename;
	$date = date("Y-m-d");
	
	if(move_uploaded_file($temp_name, $target_path))
	{
		$query_upload="INSERT into `images_tbl` (`images_path`,`submission_date`) 
		VALUES ('".$target_path."','".date("Y-m-d")."')";
		mysql_query($query_upload) or die("error in $query_upload == ----> ".mysql_error());
		header('Location:index.php?subpage=6');
	}
	else
	{
		exit("Error While uploading image on the server");
	} 
}
?>
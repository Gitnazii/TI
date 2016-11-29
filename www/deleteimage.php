<html>
<head>
<title>Edit News</title>
<meta http-equiv="Content-Type" content="text/html; charset="iso"-8859-1">
<link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
<?php
//session_start();
require_once "connect.php";

if($_SESSION['root'])
{

$conn=@new mysqli($host,$db_user,$db_pass,$db_name);
if($conn->connect_errno!=0)
{
	echo "Error Establishing a Database Connection".$conn->connect_errno;
}

if(!isset($a))
{
$query = "SELECT images_id, images_path, submission_date FROM images_tbl ORDER BY submission_date DESC";
$result = $conn->query($query);
if(!$result){
   echo('Error selecting news: ' . $mysql_error());
   exit();
}
if (mysqli_num_rows($result) > 0){
	echo '<table class="center" border=1px><tr><th>Image\'s ID</th><th>Image\'s path</th><th>Submission Date</th><th></th></tr>';
    while($row = $result->fetch_assoc())
    {
    echo '<tr> <td>'.$row['images_id'].'</td> </td> <td>'.$row['images_path'].'</td> <td>'.$row['submission_date'].'</td><td><form name="delete" method="post" action="index.php?subpage=10 "><input type="hidden" name="images_id" value="'.$row['images_id'].'"><input name="add" type="submit" id="add" value="Delete"></form></tr>';
	}
	echo '</table>';
	//echo '<a href="index.php"><-Back</a>';
	
}else{
   
   echo'<font size="-2">No images in the database</font>';
 }
}

if(isset($_POST["images_id"]))
{
	$images_id=$_POST["images_id"];

	//echo "delete".$_POST["id"];
	$query = "DELETE FROM images_tbl WHERE images_id = '$images_id'";
	$result = $conn->query($query);
	header("Location:index.php?subpage=10");
}
   $conn->close();
}
else
	 header("Location:index.php");
   ?>
   </body>
   </html>
   

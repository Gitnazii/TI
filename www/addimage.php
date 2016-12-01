<html>
<head>
<title>Add News</title>
<meta http-equiv="Content-Type" content="text/html; charset="iso"-8859-1">
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<?php
	//session_start();
	require_once "connect.php";

if($_SESSION['root'])
{
	echo '
	<form action="saveimage.php" enctype="multipart/form-data" method="post">
</br></br>
<table style="border-collapse: collapse; font: 12px Tahoma;" border="1" cellspacing="5" cellpadding="5" align="center">
<tbody><tr>
<td>
<input name="uploadedimage" type="file">
</td>

</tr>

<tr>
<td>
<input name="Upload Now" type="submit" value="Upload Image">
</td>
</tr>


</tbody></table>

</form>';
 } 
 else
	 header("Location:index.php");
 ?>
 
</body>
</html> 
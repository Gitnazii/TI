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
<form name="form1" method="post" enctype="multipart/form-data" action="addnews.php ">
</br>
  <table class="center">
    <tr>
      <td width="50%">Name</td>
	  <td><textarea name="name" id="name" style="width: 50%;"></textarea></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Headline</td>
	  <td><textarea name="headline" id="headline" style="width: 100%; height: 40px;"></textarea></td>
    </tr>
    <tr>
      <td>News Story</td>
      <td><textarea name="story" id="story" style="width: 100%; height: 300px;"></textarea></td>
	 </tr> 
	 <tr> 
	  <td>Image</td>
      <td><input name="uploadedimage" type="file"></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
          <input name="hiddenField" type="hidden" value="add_n">
          <input name="add" type="submit" id="add" value="Submit">
        </div></td>
    </tr>
  </table>
  </form> ';
 } 
 else
	 header("Location:index.php");
 ?>
 
</body>
</html> 
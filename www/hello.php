<?php
if($_SESSION['singinsuccess'])
{
	echo '<h>Hello!</h><br> <p> Now you can log in.<br> </p>';
	unset($_SESSION['singinsuccess']);
}
else
	header('Location:index.php');
?>
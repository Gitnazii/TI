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
$login=$_POST["login"];
$pass=$_POST["password"];

$login=htmlentities($login,ENT_QUOTES,"UTF-8");



//$sql="SELECT * FROM users WHERE login='$login' AND password='$pass'";
//if($rezultat=@$conn->query($sql))
	
if ($rezultat = @$conn->query(
		sprintf("SELECT * FROM users WHERE login='%s'",
		mysqli_real_escape_string($conn,$login)))) 
{
	$ilu=$rezultat->num_rows;
	if($ilu>0)
	{
		$wiersz=$rezultat->fetch_assoc();
		if(password_verify($pass,$wiersz['password']))
		{
			$_SESSION['logged']=true;
			$_SESSION['id']=$wiersz['user_id'];
			//
			$_SESSION['user_id']=$wiersz['user_id'];
			$_SESSION['root']=$wiersz['root'];
			$_SESSION['email']=$wiersz['email'];
			$_SESSION['login']=$wiersz['login'];
			
			
			unset($_SESSION['error']);
			$rezultat->free_result();
			header('Location:index.php');
		}
		else
		{
			$_SESSION['error']='<span style="color:red">Invalid login or password</span>';
			header('Location:index.php');
		}
	}else
	{
		$_SESSION['error']='<span style="color:red">Invalid login or password</span>';
		header('Location:index.php');
	}
}
$conn->close();
}


?> 
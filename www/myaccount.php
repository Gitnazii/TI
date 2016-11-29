<?php
require_once "connect.php";

mysqli_report(MYSQLI_REPORT_STRICT);
if(isset($_POST['pass1']))
	{
		$pass1=$_POST['pass1'];
		$pass2=$_POST['pass2'];
		if(strlen($pass1)<4 || (strlen($pass1)>20))
		{
			$OK=false;
			$_SESSION['e_pass']="Password must contain between 4 and 20 characters";
			$_POST['change']=1;
		}
		if($pass1!=$pass2)
		{
			$OK=false;
			$_SESSION['e_pass']="Passwords don't match";
			$_POST['change']=1;
		}
		$pass_hash=password_hash($pass1,PASSWORD_DEFAULT);
		
	}
		
		try
		{
			$conn=@new mysqli($host,$db_user,$db_pass,$db_name);
			if($conn->connect_errno!=0)
				{
					throw new Exception(mysqli_connect_errno());
				}
		
				else
				{
					if(isset($_POST['change']))
						$change=$_POST['change'];
					else
						$change=0;
					
					$rezultat = @$conn->query("SELECT user_id, login,name,surname, email FROM users WHERE user_id=".$_SESSION['user_id']);
					$wiersz=$rezultat->fetch_assoc();
					if(!$rezultat) throw new Exception($conn->error);
					echo '<h1>'.$wiersz['name'].' '.$wiersz['surname'].'</h1>';
					
					if(!isset($_SESSION['e_pass']) && isset($pass_hash))
					{
						$conn->query("UPDATE users SET password='".$pass_hash."' WHERE user_id=".$_SESSION['user_id']);
						
					}
					echo '<form name=ch_pass method="post" ><input type="hidden" name="change" value=1><input name="ch_pass" type="submit" id="ch_pass" value="Change password"></form>';
					
					if($change==1)
					{
						echo 'New password <br><form method="post"> <input type="password" name="pass1"><br>';
						echo 'New password again <br><input type="password" name="pass2"> <br>';
						if(isset($_SESSION['e_pass']))
							{
								echo '<div class="error">'.$_SESSION['e_pass'].'</div>';
								unset($_SESSION['e_pass']);
							}
						echo '<input name="add" type="submit" id="add" value="Change"></form>';
					}
				}
		}
		catch(Exception $e)
		{
			echo '<div class="error">Server error</div>';
			echo 'error:'.$e;
		}
		
	
?>

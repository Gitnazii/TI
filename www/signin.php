<html>
<head>
<title>Sign in</title>
<meta charset="utf-8" />
<link rel="stylesheet" href="style.css" type="text/css" />
<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>

<?php
	//session_start();
	require_once "connect.php";
	if(isset($_POST['email']))
	{
		// succes
		$OK=true;
		//walidacja
		//nick
		$nick=$_POST['nick'];
		if(strlen($nick)<3 || (strlen($nick)>20))
		{
			$OK=false;
			$_SESSION['e_nick']="Login must contain between 3 and 20 characters";
		}
		if(ctype_alnum($nick)==false)
		{
			$OK=false;
			$_SESSION['e_nick']="Login must contain letters and numbers only";
		}
		//email
		$email=$_POST['email'];
		$emailB=filter_var($email,FILTER_SANITIZE_EMAIL);
		if((filter_var($emailB,FILTER_VALIDATE_EMAIL)==false)||($emailB!=$email))
		{
			$OK=false;
			$_SESSION['e_email']="Incorrect email";
		}
		//passy
		$pass1=$_POST['pass1'];
		$pass2=$_POST['pass2'];
		if(strlen($pass1)<8 || (strlen($pass1)>20))
		{
			$OK=false;
			$_SESSION['e_pass']="Password must contain between 8 and 20 characters";
		}
		if($pass1!=$pass2)
		{
			$OK=false;
			$_SESSION['e_pass']="Passwords don't match";
		}
		$pass_hash=password_hash($pass1,PASSWORD_DEFAULT);
		//regulamin
		
		if(!isset($_POST['terms']))
		{
			$OK=false;
			$_SESSION['e_terms']="ACCEPT TERMS!!!";
		}
		//recaptcha
		$key="6LfxJAwUAAAAAOyXmAOjNdGsymnes4g86fiOvpkg";
		$check=file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$key.'&response='.$_POST['g-recaptcha-response']);
		$odp=json_decode($check);
		if($odp->success==false)
		{
			$OK=false;
			$_SESSION['e_bot']="you are bot!!!";
		}
		//imie nazwisko
		$name=$_POST['name'];
		$surname=$_POST['surname'];
		if(strlen($name)==0)
		{
			$OK=false;
			$_SESSION['e_name']="Enter your name";
		}
		if(preg_match('@[ęóąśłżźćńĘÓĄŚŁŻŹĆŃqazwsxedcrfvtgbyhnujmikolpQAZWSXEDCRFVTGBYHNUJMIKOLP]@', $name)==false)
		{
			$OK=false;
			$_SESSION['e_name']="Name must contain  letters only";
		}
		if(strlen($surname)==0)
		{
			$OK=false;
			$_SESSION['e_surname']="Enter your surname";
		}
		if(preg_match('@[ęóąśłżźćńĘÓĄŚŁŻŹĆŃqazwsxedcrfvtgbyhnujmikolpQAZWSXEDCRFVTGBYHNUJMIKOLP]@', $name)==false)
		{
			$OK=false;
			$_SESSION['e_surname']="Surname must contain  letters only";
		}
		
		$_SESSION['fr_nick'] = $nick;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_pass1'] = $pass1;
		$_SESSION['fr_pass2'] = $pass2;
		$_SESSION['fr_name'] = $name;
		$_SESSION['fr_surname'] = $surname;
		
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try
		{
			$conn=@new mysqli($host,$db_user,$db_pass,$db_name);
			if($conn->connect_errno!=0)
				{
					throw new Exception(mysqli_connect_errno());
				}
		
				else
				{
					//email
					$rezultat = @$conn->query("SELECT user_id FROM users WHERE email='$email'");
					if(!$rezultat) throw new Exception($conn->error);
					
					$ile=$rezultat->num_rows;
						if($ile>0)
						{
							$OK=false;
							$_SESSION['e_email']="Email already exist";
						}
					//login
					$rezultat = @$conn->query("SELECT user_id FROM users WHERE login='$nick'");
					if(!$rezultat) throw new Exception($conn->error);
					
					$ile=$rezultat->num_rows;
						if($ile>0)
						{
							$OK=false;
							$_SESSION['e_nick']="Login already exist";
						}
						//finalizacja
						if($OK==true)
						{  //$conn->query("INSERT INTO users VALUES (NULL,0, '$email', '$nick','$name','$surname','$pass_hash')"))
							if( mysqli_query($conn,"INSERT INTO users VALUES (NULL,0, '$email', '$nick','$name','$surname','$pass_hash')"))
							{
							
									$_SESSION['singinsuccess']=true;
									//header('Location:index.php?subpage=12');
							}
							else{
								throw new Exception($conn->error);
							}
						}
					
					$conn->close();
				}
		}		
		catch(Exception $e)
		{
			echo '<div class="error">Server error</div>';
			echo 'error:'.$e;
		}
		
	}  //formularz
?>

<form name="form1" method="post" class="center" >
 

    Nickname <br>
	 <input type='text' value="<?php
			if (isset($_SESSION['fr_nick']))
			{
				echo $_SESSION['fr_nick'];
				unset($_SESSION['fr_nick']);
			}
		?>" name='nick'> <br>
    
	<?php
	if(isset($_SESSION['e_nick']))
	{
		echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
		unset($_SESSION['e_nick']);
	}
	?>
    E-mail <br>
	  <input type='email' value="<?php
			if (isset($_SESSION['fr_email']))
			{
				echo $_SESSION['fr_email'];
				unset($_SESSION['fr_email']);
			}
		?>" name='email'> <br>
	  <?php
	  if(isset($_SESSION['e_email']))
	{
		echo '<div class="error">'.$_SESSION['e_email'].'</div>';
		unset($_SESSION['e_email']);
	}
	?>
    
      Password <br>
	  <input type='password' value="<?php
			if (isset($_SESSION['fr_pass1']))
			{
				echo $_SESSION['fr_pass1'];
				unset($_SESSION['fr_pass1']);
			}
		?>" name='pass1'><br>
    
      Password again<br>
	 <input type='password' value="<?php
			if (isset($_SESSION['fr_pass2']))
			{
				echo $_SESSION['fr_pass2'];
				unset($_SESSION['fr_pass2']);
			}
		?>" name='pass2'><br>
	 <?php
	  if(isset($_SESSION['e_pass']))
	{
		echo '<div class="error">'.$_SESSION['e_pass'].'</div>';
		unset($_SESSION['e_pass']);
	}
	?>
	Name<br>
	 <input type='text' value="<?php
			if (isset($_SESSION['fr_name']))
			{
				echo $_SESSION['fr_name'];
				unset($_SESSION['fr_name']);
			}
		?>" name='name'><br>
	 <?php
	  if(isset($_SESSION['e_name']))
	{
		echo '<div class="error">'.$_SESSION['e_name'].'</div>';
		unset($_SESSION['e_name']);
	}
	?>
	Surname<br>
	 <input type='text' value="<?php
			if (isset($_SESSION['fr_surname']))
			{
				echo $_SESSION['fr_surname'];
				unset($_SESSION['fr_surname']);
			}
		?>" name='surname'><br>
	 <?php
	  if(isset($_SESSION['e_surname']))
	{
		echo '<div class="error">'.$_SESSION['e_surname'].'</div>';
		unset($_SESSION['e_surname']);
	}
	?>
    <label><input type='checkbox' name='terms'> I accept terms and conditions</label><br>
	<?php
	  if(isset($_SESSION['e_terms']))
	{
		echo '<div class="error">'.$_SESSION['e_terms'].'</div>';
		unset($_SESSION['e_terms']);
	}
	?>
	 <div class="g-recaptcha" data-sitekey="6LfxJAwUAAAAADNZ1V7N_t04jq362diC7q1gqb2s"></div><br>
	 <?php
	  if(isset($_SESSION['e_bot']))
	{
		echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
		unset($_SESSION['e_bot']);
	}
	?>
	
	
	<input name="add" type="submit" id="add" value="Sign In"><br>
	
          
		  
   
  
  </form> 

 
</body>
</html> 
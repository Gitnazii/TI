<!DOCTYPE HTML>
<?php
session_start();
?>
<html lang="eng">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="stylesheet" href="style.css" type="text/css" />

	
	<title>Sports and recreation center's webpage!</title>
	<meta name="description" content="A webpage dedicated to customers of our sports and recreation center." />
	<meta name="keywords" content="sport, recreation, center" />
</head>


<body>
	<div id="container">
	
	
		<div id="logo">
		<a href="index.php">
			<img src="pictures\logo.jpg" width="1000px" height="200px" />
			</a>
		</div>
		
		
		<div id="subpages">
			<a href="index.php?subpage=1">
			<div class="rectangle">
			News
			</div>	
			</a>
			
			
			<a href="index.php?subpage=2">
			<div class="rectangle">
			Pricings
			</div>
			</a>
			
			
			<a href="index.php?subpage=3">
			<div class="rectangle">
			Schedule
			</div>	
			</a>
			
			
			<a href="index.php?subpage=4">
			<div class="rectangle">
			Courses
			</div>	
			</a>

			
			<a href="index.php?subpage=5">
			<div class="rectangle">
			Contact
			</div>	
			</a>

			
			<a href="index.php?subpage=6">
			<div class="rectangle">
			Gallery
			</div>	
			</a>

			<div id="panel">
				<?php
				if(isset($_SESSION['logged']))
				{
				echo str_repeat('&nbsp;', 3)."<small>Hello  ".$_SESSION['login'].'!! </small>';
				echo '<form action="logout.php" method="post"><input type="submit" id="logout" value="Log out"></form>';
				}
				else{
					
				echo '
				<form action="login.php" method="post">
					<input type="textbox" id="login" name="login" placeholder="Login">
					
					<input type="password" id="pass" name="password" placeholder="Password">
					
					<input type="submit" id="send" value="Log in">
					
				</form>';
				}
				?>
			</div>
		</div>				
		<div style="clear: both;"></div>

		
		<div id="main">
			<div id="content">
			
			<?php
			//###################################
			if(isset($_GET['subpage']))
			{
				switch ($_GET['subpage']) {
				case 1:
					include_once('news.php');
					break;
				case 2:
					include_once('pricings.php');
					break;
				case 3:
					include_once('schedule.php');
					break;
				case 4:
					include_once('courses.php');
					break;
				case 5:
					include_once('contact.php');
					break;
				case 6:
					include_once('gallery.php');
					break;
				case 7:
					include_once('newnews.php');
					break;
				case 8:
					include_once('newsedit.php');
					break;
				case 9:
					include_once('addimage.php');
					break;
				case 10:
					include_once('deleteimage.php');
					break;
				case 11:
					include_once('signin.php');
					break;
				case 12:
					include_once('hello.php');
					break;	
				case 13:
					include_once('accounts.php');
					break;
				case 14:
					include_once('myaccount.php');
					break;	
				case 15:
					include_once('start5.php');
					break;	
				default:
				break;
				}
}
			
			
			
			?>
			</div>
			
			
			<div id="column">
				<div id="acc">
			<?php
				
				if(isset($_SESSION['error']) && !isset($_SESSION['logged']) )
				{
					echo $_SESSION['error'];
					unset($_SESSION['error']);
				}
				
				//funkcjonalności konta
				
				if(isset($_SESSION['root']) && $_SESSION['root']==1)
				{
					?>
					<a href="index.php?subpage=7"><div class="rectangle2">Add news</div></a>
					<a href="index.php?subpage=8"><div class="rectangle2">Edit news</div></a>
					<a href="index.php?subpage=9"><div class="rectangle2">Add images</div></a>
					<a href="index.php?subpage=10"><div class="rectangle2">Delete images</div></a>
					<a href="index.php?subpage=13"><div class="rectangle2">Accounts management</div></a>
				<?php
				}
				if (!isset($_SESSION['logged']))
					?>
					<a href="index.php?subpage=11"><div class="rectangle2">Sign in</div></a>
				<?php
				if(isset($_SESSION['logged']) && $_SESSION['logged']==1)
					?>
					<a href="index.php?subpage=14"><div class="rectangle2">My account</div></a>
				<?php
			?>
				</div>
				
				
				<div id="space">
				</div>
			</div>
		</div>
		<div style="clear: both;"></div>
		
		
		<div id="footer">
		© 2016 Sports Center "Nazwa"
		</div>
	</div>
	
</body>
</html>
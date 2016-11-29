<?php
//session_start();
require_once "connect.php";

if($_SESSION['root'])
{

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
				if(!isset($a))
					{
					$query = "SELECT user_id, email, login FROM users WHERE root=0 ORDER BY user_id DESC";
					$result = $conn->query($query);
					if(!$result){
					   throw new Exception(mysqli_connect_errno());
					}
					if (mysqli_num_rows($result) > 0)
					{
						echo '<table class="center" border=1px><tr><th>user id</th><th>email</th><th>login</th><th></th><th></th></tr>';
						while($row = $result->fetch_assoc())
						{
						echo '<tr> <td>'.$row['user_id'].'</td> </td> <td>'.$row['email'].'</td> <td>'.$row['login'].'</td> <td><form name="edit" method="post" action="index.php?subpage=13"><input type="hidden" name="id" value="'.$row['user_id'].'"><input type="hidden" name="a" value="1"><input name="add" type="submit" id="add" value="Edit"></form></td> <td><form name="delete" method="post" action="index.php?subpage=13 "><input type="hidden" name="id" value="'.$row['user_id'].'"><input type="hidden" name="a" value="2"><input name="add" type="submit" id="add" value="Delete"></form></tr>';
						}
						echo '</table>';
						//echo '<a href="index.php"><-Back</a>';
						
					}else
						{
					   
						echo'<font size="-2">No users in the database</font>';
						}
					
					if(isset($_POST["a"]))
						{
							$a=$_POST["a"];
							$id=$_POST["id"];

						if($a==1)
						{
							$query = "SELECT  headline,story,name FROM news WHERE id=".$id;
							$result = $conn->query($query);
							$row = $result->fetch_assoc();
							
							$headline=$row["headline"];
							$story=$row["story"];

							echo '<form name="form1" method="post" action="newsupdate.php ">
							<table class="center" width="50%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <td width="50%">Name</td>
							  <td><textarea name="name" id="name" style="width: 50%;">'.$row["name"].'</textarea></td>
							</tr>
							
							<tr>
							  <td>&nbsp;</td>
							  <td>&nbsp;</td>
							</tr>
							<tr>
							  <td>Headline</td>
							  <td><textarea name="headline" id="headline" style="width: 100%; height: 40px;">'.$headline.'</textarea></td>
							</tr>
							<tr>
							  <td>News Story</td>
							  <td><textarea name="story" id="story" style="width: 100%; height: 400px;">'.$story.'</textarea></td>
							</tr>
							<tr>
							  <td colspan="2"><div align="center">
								  <input name="hiddenField" type="hidden" value="add_n">
								  <input type="hidden" name="id" value="'.$id.'">
								  <input name="add" type="submit" id="add" value="Update">
								</div></td>
							</tr>
						  </table>
						  </form>' ;
						}
							
						if($a==2)
						{
							//echo "delete".$_POST["id"];
							$query = "DELETE FROM users WHERE user_id = '$id'";
							$result = $conn->query($query);
							header("Location:index.php?subpage=13");
						}
	

					$conn->close();					
					
					}
					}
			}

		}	
			
		catch(Exception $e)
		{
			echo '<div class="error">Server error</div>';
			echo 'error:'.$e;
		}
		
}
  

   ?>


<iframe src="https://calendar.google.com/calendar/embed?mode=WEEK&amp;height=800&amp;wkst=2&amp;hl=en_GB&amp;bgcolor=%23cccccc&amp;src=5gl114pdun66thc146fr0n2r0s%40group.calendar.google.com&amp;color=%23AB8B00&amp;ctz=Europe%2FWarsaw" style="border-width:0" width="780" height="800" frameborder="0" scrolling="no"></iframe>
<?php
				require_once "connect.php";
				
				$conn=@new mysqli($host,$db_user,$db_pass,$db_name);
				
				if($conn->connect_errno!=0)
				{
					echo "Error Establishing a Database Connection".$conn->connect_errno;
				}
				else
				{
				
				$query = "SELECT id, course, day, hours FROM schedule ORDER BY id ASC";
				$result = $conn->query($query);
				if(!$result){
				echo('Error selecting news: ' . mysql_error());
				exit();
				}
				if (mysqli_num_rows($result) > 0){
					while($row = $result->fetch_assoc())
					{
						$id=$row["id"];
						$course=$row["course"];
						$day=$row["day"];
						$hours=$row["hours"];
					
					if ($course=="regular")
					{
						if($id==1) echo '</br></br></br><table border=1px style="margin: 0 auto;">';
						echo '<tr><th>'.$day.'</th><th>'.$hours.'</th></th>';
						if($id==7) echo '</table>';
					}
					
					if($course=="Swimming course")
					{
						if($id==8)
						{	
							echo '</br></br><table border=1px style="margin: 0 auto;">';
							echo '<tr><th colspan="2">'.$course.'</th></tr>';
						}
						echo '<tr><th>'.$day.'</th><th>'.$hours.'</th></th>';
						if($id==9) echo '</table>';
					}
					
					if($course=="Aqua aerobics")
					{
						if($id==10)
						{	
							echo '</br></br><table border=1px style="margin: 0 auto;">';
							echo '<tr><th colspan="2">'.$course.'</th></tr>';
						}
						echo '<tr><th>'.$day.'</th><th>'.$hours.'</th></th>';
						if($id==11) echo '</table>';
					}
					
					}
				}else{
				
				echo '<font size="-2">No news in the database</font>';
				}
				$conn->close();
				}
				?>
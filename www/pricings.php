<?php
				require_once "connect.php";
				
				$conn=@new mysqli($host,$db_user,$db_pass,$db_name);
				
				if($conn->connect_errno!=0)
				{
					echo "Error Establishing a Database Connection".$conn->connect_errno;
				}
				else
				{
				
				$query = "SELECT id, day, normal_ticket_until3pm, reduced_ticket_until3pm, normal_ticket_after3pm, reduced_ticket_after3pm FROM pricings ORDER BY id ASC";
				$result = $conn->query($query);
				if(!$result){
				echo('Error selecting news: ' . mysql_error());
				exit();
				}
				if (mysqli_num_rows($result) > 0){
					while($row = $result->fetch_assoc())
					{
						$id=$row["id"];
						$day=$row["day"];
						$normal_ticket_until3pm=$row["normal_ticket_until3pm"];
						$reduced_ticket_until3pm=$row["reduced_ticket_until3pm"];
						$normal_ticket_after3pm=$row["normal_ticket_after3pm"];
						$reduced_ticket_after3pm=$row["reduced_ticket_after3pm"];
					
						if($id==1)
						{	
							echo '</br></br>';
							echo '<table align=center border=1px><tr><th colspan="5">'.$day.'</th></tr>';
							echo '<tr><th></th><th>Normal ticket until 3pm</th><th>Reduced ticket until 3pm</th><th>Normal ticket after 3pm</th><th>Reduced ticket after 3pm</th></tr>';
							echo '<tr><th>60 minutes</th><th>'.$normal_ticket_until3pm.'</th><th>'.$reduced_ticket_until3pm.'</th><th>'.$normal_ticket_after3pm.'</th><th>'.$reduced_ticket_after3pm.'</th></tr>';
						}
						if($id==2)
						{
							echo '<tr><th>120 minutes</th><th>'.$normal_ticket_until3pm.'</th><th>'.$reduced_ticket_until3pm.'</th><th>'.$normal_ticket_after3pm.'</th><th>'.$reduced_ticket_after3pm.'</th></tr>';
						}
						if($id==3)
						{
							echo '<tr><th>per 1 extra min.</th><th>'.$normal_ticket_until3pm.'</th><th>'.$reduced_ticket_until3pm.'</th><th>'.$normal_ticket_after3pm.'</th><th>'.$reduced_ticket_after3pm.'</th></tr>';
							echo '</table>';
							echo '</br></br>';
						}
						
						
						if($id==4)
						{	
							echo '<table align=center border=1px><tr><th colspan="5">'.$day.'</th></tr>';
							echo '<tr><th></th><th>Normal ticket until 3pm</th><th>Reduced ticket until 3pm</th><th>Normal ticket after 3pm</th><th>Reduced ticket after 3pm</th></tr>';
							echo '<tr><th>60 minutes</th><th>'.$normal_ticket_until3pm.'</th><th>'.$reduced_ticket_until3pm.'</th><th>'.$normal_ticket_after3pm.'</th><th>'.$reduced_ticket_after3pm.'</th></tr>';
						}
						if($id==5)
						{
							echo '<tr><th>120 minutes</th><th>'.$normal_ticket_until3pm.'</th><th>'.$reduced_ticket_until3pm.'</th><th>'.$normal_ticket_after3pm.'</th><th>'.$reduced_ticket_after3pm.'</th></tr>';
						}
						if($id==6)
						{
							echo '<tr><th>per 1 extra min.</th><th>'.$normal_ticket_until3pm.'</th><th>'.$reduced_ticket_until3pm.'</th><th>'.$normal_ticket_after3pm.'</th><th>'.$reduced_ticket_after3pm.'</th></tr>';
							echo '</table>';
						}
					}
				}else{
				
				echo '<font size="-2">No news in the database</font>';
				}
				$conn->close();
				}
				?>
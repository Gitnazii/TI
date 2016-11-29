<?php
				require_once "connect.php";
				
				$conn=@new mysqli($host,$db_user,$db_pass,$db_name);
				
				if($conn->connect_errno!=0)
				{
					echo "Error Establishing a Database Connection".$conn->connect_errno;
				}
				else
				{
				
				$query = "SELECT id, street, postal_code, city, phone_number1, phone_number2, email FROM contact ORDER BY id ASC";
				$result = $conn->query($query);
				if(!$result){
				echo('Error selecting news: ' . mysql_error());
				exit();
				}
				if (mysqli_num_rows($result) > 0){
					while($row = $result->fetch_assoc())
					{
						$street=$row["street"];
						$postal_code=$row["postal_code"];
						$city=$row["city"];
						$phone_number1=$row["phone_number1"];
						$phone_number2=$row["phone_number2"];
						$email=$row["email"];
					
					echo '</br></br></br></br></br></br>';
					echo '<table style="text-align: left; margin: 0 auto;"><tr><th>'.$street.'</th></tr><tr><th>'.$postal_code.' '.$city.'</th></tr><tr><th>'.'Phone number:  '.$phone_number1.'</th></tr><tr><th>'.'Phone number:  '.$phone_number2.'</th></tr><tr><th>'.'e-mail:  '.$email.'</th></tr></table>';
					}
				}else{
				
				echo '<font size="-2">No news in the database</font>';
				}
				$conn->close();
				}
				?>
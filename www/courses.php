<?php
				require_once "connect.php";
				
				$conn=@new mysqli($host,$db_user,$db_pass,$db_name);
				
				if($conn->connect_errno!=0)
				{
					echo "Error Establishing a Database Connection".$conn->connect_errno;
				}
				else
				{
				
				$query = "SELECT id, name, description, price FROM courses ORDER BY id ASC";
				$result = $conn->query($query);
				if(!$result){
				echo('Error selecting news: ' . mysql_error());
				exit();
				}
				if (mysqli_num_rows($result) > 0){
					while($row = $result->fetch_assoc())
					{
						$name=$row["name"];
						$description=$row["description"];
						$price=$row["price"];
						$name=nl2br($name);
						$description=nl2br($description);
					
					echo "<div style='text-align: center; margin: 5px 5px;'><headline>".$name."</headline></div></br></br>";
					echo "<div style='text-align: justify; text-justify: inter-word; margin: 5px 5px;'><story>".$description."</story></div>";
					echo "<div style='text-align: right; margin: 5px 5px;'><name>"."Price: ".$price."</name></div></br></br></br>";
					}
				}else{
				
				echo '<font size="-2">No news in the database</font>';
				}
				$conn->close();
				}
				?>
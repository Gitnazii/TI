<?php
				require_once "connect.php";
				
				$conn=@new mysqli($host,$db_user,$db_pass,$db_name);
				
				if($conn->connect_errno!=0)
				{
					echo "Error Establishing a Database Connection".$conn->connect_errno;
				}
				else
				{
				
				$query = "SELECT id, headline, story,name, timestamp FROM news ORDER BY timestamp DESC";
				$result = $conn->query($query);
				if(!$result){
				echo('Error selecting news: ' . mysql_error());
				exit();
				}
				if (mysqli_num_rows($result) > 0){
					while($row = $result->fetch_assoc())
					{
						$id=$row["id"];
						$headline=$row["headline"];
						$story=$row["story"];
						$headline=nl2br($headline);
						$story=nl2br($story);
						
		
					$query = "SELECT images_path FROM  news_img where news_id=".$id;
					$result2 = $conn->query($query);
					if(!$result2){
					echo('Error selecting images: ' . mysql_error());
					exit();
					}
					$row2 = $result2->fetch_assoc();
					//headline
					echo "<div style='text-align: center; margin: 5px 5px;'><headline>".$headline."</headline></div>"."<div style='text-align: right; margin: -26px 10px;'><timestamp>".$row['timestamp']."</timestamp></div><br><br>";
					//image
					if(!empty($row2["images_path"]))
					echo '<div class="slideshow-container"><img src='.$row2["images_path"].' style="position: absolute; top: 50%; left: 50%; width: 780px; height: 600px; margin-top: -300px; margin-left: -390px;"/></div>';
					//rest
					echo "<div style='text-align: justify; text-justify: inter-word; margin: 5px 5px;'><story>".$story."</story></div>";
					echo "<div style='text-align: right; margin: 5px 5px;'><name>"."by ".$row['name']."</name></div><br>";
					}
				}else{
				
				echo '<font size="-2">No news in the database</font>';
				}
				$conn->close();
				}
				?>
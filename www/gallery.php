<link rel="stylesheet" href="bjqs.css">
<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="js/bjqs-1.3.min.js"></script>
<script>
  jQuery(document).ready(function($) {
    
    $('#banner-slide').bjqs({
      animtype      : 'slide',
      height        : 600,
      width         : 780,
      responsive    : true,
      randomstart   : true
    });
    
  });
</script>

<?php
include("mysqlconnect.php");

$select_query = "SELECT images_path FROM  images_tbl ORDER by images_id DESC";
$sql = mysql_query($select_query) or die(mysql_error());
?>


<div id="banner-slide">

        <ul class="bjqs">
		<?php
		while($row = mysql_fetch_array($sql,MYSQL_BOTH)){
		?>
			<li><img src="<?php echo $row["images_path"]; ?>"</li>
		
		<?php
		}
		?>
		</ul>
</div>


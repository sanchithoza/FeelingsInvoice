	<?php


	include('leftbar.php'); 
	if(!empty($_GET)) {

		if($_GET['type'] == 'backup'){

			$connection = mysqli_connect($servername, $username, $password, $db);
			$tables = array();
			$result = mysqli_query($connection,"SHOW TABLES");
			while($row = mysqli_fetch_row($result)){
				$tables[] = $row[0];
			}
			$return = '';
			foreach($tables as $table){
				$result = mysqli_query($connection,"SELECT * FROM ".$table);
				$num_fields = mysqli_num_fields($result);

				$return .= 'DROP TABLE '.$table.';';
				$row2 = mysqli_fetch_row(mysqli_query($connection,"SHOW CREATE TABLE ".$table));
				$return .= "\n\n".$row2[1].";\n\n";

				for($i=0;$i<$num_fields;$i++){
					while($row = mysqli_fetch_row($result)){
						$return .= "INSERT INTO ".$table." VALUES(";
						for($j=0;$j<$num_fields;$j++){
							$row[$j] = addslashes($row[$j]);
							if(isset($row[$j])){ $return .= '"'.$row[$j].'"';}
							else{ $return .= '""';}
							if($j<$num_fields-1){ $return .= ',';}
						}
						$return .= ");\n";
					}
				}
				$return .= "\n\n\n";
			}
	//save file
			$handle = fopen("backup.sql","w+");
			fwrite($handle,$return);
			fclose($handle);
			echo "Successfully backed up";
		}
		if($_GET['type'] == 'restore'){

	// Create connection
			$conn = new mysqli($servername, $username, $password);
	// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}

	// Create database
			$sql = "CREATE DATABASE myDB";
			if ($conn->query($sql) === TRUE) {
				echo "Database created successfully";
			} else {
				echo "Error creating database: " . $conn->error;
			}

			$conn->close();


	$connection = mysqli_connect('localhost','root','','myDB');//($servername, $username, $password, $db);
	$filename = 'backup.sql';
	$handle = fopen($filename,"r+");
	$contents = fread($handle,filesize($filename));
	$sql = explode(';',$contents);
	foreach($sql as $query){
		$result = mysqli_query($connection,$query);
		if($result){
			echo '<tr><td><br></td></tr>';
			echo '<tr><td>'.$query.' <b>SUCCESS</b></td></tr>';
			echo '<tr><td><br></td></tr>';
		}
	}
	fclose($handle);
	echo 'Successfully imported';
}
}
/* backup the db OR just a table */

?>
<div id="page-wrapper">
	<div class="row">
		<!-- <form  method="post" action="backup.php?type=backup"> -->
			<form  method="post" action="backup.php?type=backup">
				<button type="submit" value="Submit" class="btn btn-success btn-lg">Backup Database</button>

			</form>
			<form  method="post" action="backup.php?type=restore">
				<button type="submit" value="Submit" class="btn btn-success btn-lg">Restore Database</button>
			</form>
		</div>
	</div>
	<? include('footer.php'); ?>
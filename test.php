<?php
require 'includes/configg123.php';
$captenid = array();
$conn = new mysqli($servername, $username, $password, $dbmix);
	$sql1 = "SELECT steamid, timetopick FROM tournament WHERE capt = '1'";
	$result = $conn->query($sql1);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				array_push($captenid, $key = $row["steamid"], $value = $row["timetopick"]);
				//echo $row["steamid"];
			}
		}


print_r (each($captenid)); // Returns the key and value of the current element (now Joe), and moves the internal pointer forward
?>

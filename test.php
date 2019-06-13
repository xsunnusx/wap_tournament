<?php
require 'includes/configg123.php';
$captenid = array();
$conn = new mysqli($servername, $username, $password, $dbmix);
	$sql1 = "SELECT steamid, timetopick FROM tournament WHERE capt = '1'";
	$result = $conn->query($sql1);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				//$captenid[$row["timetopick"]] = $row["steamid"];
				echo '<br>'.$row["steamid"].' + '.$row["timetopick"].'</br>';
				array_push($captenid[$row["steamid"]] = $row["timetopick"]);
			}
		}


print_r ($captenid); // Returns the key and value of the current element (now Joe), and moves the internal pointer forward
?>

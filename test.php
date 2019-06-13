<?php
$stid = 76561198797555452;
require 'includes/configg123.php';
$captains = array();
$conn = new mysqli($servername, $username, $password, $dbmix);
	$sql1 = "SELECT steamid, timetopick FROM tournament WHERE capt = '1'";
	$result = $conn->query($sql1);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				array_push($captains[$row["steamid"]] = $row["timetopick"]);
			}
		}


print_r ($captenid); // Returns the key and value of the current element, and moves the internal pointer forward

echo "Captains:";
foreach ($captains as $key => $val) {
	if ($key == $stid && $val == 1) {
	echo "<br>Your time to pick</br>";
	break;
	}
	else {
		echo "Another captain is picking";
		break;
	}
}
?>


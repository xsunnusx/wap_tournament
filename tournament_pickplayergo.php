
<?php
require 'includes/configg123.php';
require 'Examples/Example.php';
include 'includes/steamauth/userInfo.php';
if(isset($_POST['steamidpicked'])){
$stid = $_POST['steamidpicked'];
$team = $_POST['teamnr'];
$name = $_POST['nick'];
$capt = $_POST['capt'];
}

	$conn = new mysqli($servername, $username, $password, $dbmix);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "UPDATE tournament SET team = '$team' , picked = '1' WHERE steamid = '$stid'";
	$sql2 = "UPDATE tournament SET timetopick = '0' WHERE steamid = '$capt'";
	$sql3 = "UPDATE tournament SET timetopick = '1' WHERE capt = '1' AND timetopick = '0' LIMIT 1"; // vaja panna järgmisele kaptenile timetopick 1 aga järjest kordamööda, ja kui lõppeb table siis alustab algusest, nagu loop
	$result = $conn->query($sql);
	$result = $conn->query($sql3);
	$result = $conn->query($sql2);
	$conn->close();


echo "You picked: $name to your team";
//echo $capt;

?>


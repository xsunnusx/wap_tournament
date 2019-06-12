
<?php
require 'includes/configg123.php';
require 'Examples/Example.php';
include 'includes/steamauth/userInfo.php';
if(isset($_POST['steamidpicked'])){
$stid = $_POST['steamidpicked'];
$team = $_POST['teamnr'];
$name = $_POST['nick'];
}

	$conn = new mysqli($servername, $username, $password, $dbmix);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "UPDATE tournament SET team = '$team' , picked = '1' WHERE steamid = '$stid'";
	$result = $conn->query($sql);
	$conn->close();


echo "You picked: $name to team $team with steamid: $stid";

?>


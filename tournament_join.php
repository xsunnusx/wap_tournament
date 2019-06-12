<center><table style="width:500px;">
<tr><th>

<?php

require 'includes/configg123.php';
require 'Examples/Example.php';
require 'includes/steamauth/userInfo.php';

$self = $_SERVER['PHP_SELF'];
//Get the steamid (really the community id)
$communityid = $_SESSION['steamid'];
//Get the map name
//See if the second number in the steamid (the auth server) is 0 or 1. Odd is 1, even is 0
$authserver = bcsub($communityid, '76561197960265728') & 1;
//Get the third number of the steamid
$authid = (bcsub($communityid, '76561197960265728')-$authserver)/2;
//Concatenate the STEAM_ prefix and the first number, which is always 0, as well as colons with the other two numbers
$steamid = "STEAM_1:$authserver:$authid";
if(isset($_SESSION['steamid'])) {

// Tokens count
$conn = new mysqli($servername, $username, $password, $dbmix);
$sql1 = "SELECT tokens FROM web_coins WHERE steamid = $communityid";
$result = $conn->query($sql1);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$tokens = $row["tokens"];
		
    }
} else {
    echo "0";
}
// Tokens count end
$conn->close();
$steamidd = $communityid;
$nick = $steamprofile["personaname"];
$registered = '';

// register check
$conn = new mysqli($servername, $username, $password, $dbmix);
$sql1 = "SELECT reg FROM tournament WHERE steamid = $communityid";
$result = $conn->query($sql1);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$registered = $row["reg"];
		
    }
} else {
    $registered = 0;
}
$conn->close();
// register check end
// captain check
$conn = new mysqli($servername, $username, $password, $dbmix);
$sql1 = "SELECT capt FROM tournament WHERE steamid = $communityid";
$result = $conn->query($sql1);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$captain = $row["capt"];
		
    }
} else {
    $captain = 0;
}
$conn->close();

// captain check end
if(isset($_POST['steamidd'])){
	$conn = new mysqli($servername, $username, $password, $dbmix);
	$sql = "INSERT INTO `tournament` (`steamid`, `nick`, `team`, `picked`, `capt`, `timetopick`, `lvl`, `reg`) VALUES ('$steamidd', '$nick', '0', '0', '0' ,'0' ,'0','1' ) 
	ON DUPLICATE KEY UPDATE `steamid`='$steamidd', `nick`='$nick', `team`='0', `picked`='0', `capt`='0', `timetopick`='0', `lvl`='0', `reg`='1'";
	$result = $conn->query($sql);
	$sql2 = "UPDATE web_coins SET tokens = tokens - 1 WHERE steamid = $steamidd";
	$result2 = $conn->query($sql2);
	$conn->close();
	echo '<tr><th>Dear '.$nick.' you have Registered to WWT
	<p><a href="tournament_live">Tournament Page</a></th></tr>';
} elseif(($registered == 0) AND ($tokens > 1)) {
	echo "<tr><th>Hello $nick you have $tokens tokens, and you can join WWT!";
	echo '<br<br><br><br><br>
	<form method="post" action="" name="tournament">
		<input type="hidden" name="steamidd" value="'.$steamidd.'">
		<input type="submit" name="submit" value="REGISTER">
	</form></th></tr>';
} else {
	if ($registered != 0){
		echo '<tr><th>You have already registered!
		<p><a href="/csgo/tournament/index.php">Tournament Page</a></th></tr>';
		
			}
			
			else {
					if ($tokens < 1) {
						echo "<tr><th>Hello $nick you have $tokens tokens you cant join WWT.</th></tr>";
					}
						else {
							
						}
				}
} 
}
else {
	echo '<center><h3>Please login to register</h3></center>
	<p><a href="/csgo/tournament/tournament_live.php">Tournament Page</a></th></tr>';
	
}
if(!isset($_POST['steamidd'])){ 
echo '

<h4>WWT - <font color="#ff6600">W</font>ap <font color="#ff6600">W</font>eekend <font color="#ff6600">T</font>ournament</h4>
  </th></tr>
  <tr><td>
  WWT will start as soon as V1k1R will finish writing automatisation codes for CS:GO servers and WEB-API.
  <p>
  </td></tr>
  <br> <br>';

}
?>

 </table></center>
 <br> <br> <br> <br>
 <center><table style="width:400px;">
 <tr>
	<th>REGISTERED PLAYERS:</th>
 </tr>
 <?php
 $conn = new mysqli($servername, $username, $password, $dbmix);
 $sql1 = "SELECT nick FROM tournament WHERE reg = '1'";
$result = $conn->query($sql1);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		echo '<center><tr><th> '.$row["nick"].'</th></tr></center>';
		
    }
} else {
    echo "";
}
		if ($captain != 0) {
		echo 'You are team captain, please go to team manage - <a href="tournament_pickplayer">HERE</a>';
	}
$conn->close();
 ?>
 
 
 
 </table></center>
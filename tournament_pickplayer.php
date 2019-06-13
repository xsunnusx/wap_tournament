
<center><table style="width:500px;">
<style>
table,th,td {
  border : 1px solid black;
  border-collapse: collapse;
}
th,td {
  padding: 5px;
}
#txtPlayers, txtPicked {
	width: 500px;
	display: block;
}
#txtPicked {
	width: 500px;
	display: block;
}
</style>


<div id="txtPicked">Players will be listed here. Click on player to pick.</div>
<br><br><br>
<div id="txtPlayers">PLAYER: </div>
<br>
<?php

require 'includes/configg123.php';
require 'Examples/Example.php';
include 'includes/steamauth/userInfo.php';

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


function drawTeam($teamnr, $servername, $username, $password, $dbmix) {
	$conn = new mysqli($servername, $username, $password, $dbmix);
	$sql1 = "SELECT nick,capt FROM tournament WHERE picked = 1 AND team = $teamnr";
	$result = $conn->query($sql1);
		if ($result->num_rows > 0) {
				
				while($row = $result->fetch_assoc()) {
					if ($row["capt"] != 0){
						echo '<p>'.$row["nick"].' (capt)</p>';
					}
					else {
						echo '<p>'.$row["nick"].'</p>';
					}
				}
				}
		else {
			echo 'No one In Team Yet';
			}
		$conn->close();
}
echo '<br><div>'.drawTeam("1",$servername, $username, $password, $dbmix).' </div></br>';
echo '<br><div>'.drawTeam("2",$servername, $username, $password, $dbmix).'</div> </br>';



// captain check
$conn = new mysqli($servername, $username, $password, $dbmix);
$sql1 = "SELECT capt,team FROM tournament WHERE steamid = $communityid";
$result = $conn->query($sql1);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$captain = $row["capt"];
		$teamnr = $row["team"];
		$_SESSION["teamnr"] = $row["team"];
		
    }
} else {
    $captain = 0;
	$teamnr = 0;
}
$conn->close();

// captain check end


$conn = new mysqli($servername, $username, $password, $dbmix);
$sql1 = "SELECT teamname FROM tournament_team WHERE id = $teamnr";
$result = $conn->query($sql1);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$teamname = $row["teamname"];
		
    }
} else {
	$teamname = 0;
}
$conn->close();

//timetopick
$conn = new mysqli($servername, $username, $password, $dbmix);
$sql3 = "SELECT steamid FROM tournament WHERE capt = '1' ORDER BY last_update ASC LIMIT 1";
$result = $conn->query($sql3);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		if ($row["steamid"] == $communityid){
			$timetopick = TRUE;
		}
		 else {
			$timetopick = FALSE;
		}
	}
}
$conn->close();
//timetopick
echo '<div id ="pick">';
if ($captain != 0 && $timetopick) {
	// players list
	$conn = new mysqli($servername, $username, $password, $dbmix);
	$sql1 = "SELECT nick,steamid,team FROM tournament WHERE picked = 0";
	$result = $conn->query($sql1);
		if ($result->num_rows > 0) {
				$i = 1;
				$controll = $result->num_rows;
				while($row = $result->fetch_assoc()) {
					if ($i <= $controll) {
					echo '<br><input type="button" onclick="myFunction(this)" id="'.$i.'" data-teamnr="'.$teamnr.'" data-nick="'.$row["nick"].'" data-steamid="'.$row["steamid"].'" value="'.$row["nick"].'"></br>';
					$i++;
					}
				}
		} 
		else {
					echo 'No one listed for tournament';
			}
$conn->close();
// players list end
}
elseif($captain != 0 && !$timetopick){
	echo 'Other captain is picking player';
}
else {
	echo "Not captain";
}
echo '</div>';
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
?>



 </table></center>
 <script>
function myFunction(elem) {
	var buttom = document.getElementById(elem.id);
    var steamid = buttom.getAttribute("data-steamid");
    var team = buttom.getAttribute("data-teamnr");
    var nick1 = buttom.getAttribute("data-nick");
	var capt = "<?php echo $communityid ?>";
    $.ajax({
            type : "POST",  //type of method
            url  : "tournament_pickplayergo.php",  //your page
            data : { steamidpicked : steamid, teamnr : team, nick : nick1, capt : capt },// passing the values
            success: function(data){  
                                    alert(data);
									console.log(data);
									window.location.href = "tournament_pickplayer"; // where to go after getting response
                    },
        });
    }


setInterval(function()
{
  $('#pick').load(document.URL +  ' #pick');
}, 30000);


 </script>
 

<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json');
extract($_REQUEST);
$mysqli = new mysqli('localhost', 'root', 'adminadmin', 'cordenate');
$myArray = array();
if (isset($disponible))
{
	if ($result = $mysqli->query("SELECT * FROM personas where disponible='$disponible'")) {
		$tempArray = array();
		while ($row = $result->fetch_object()) {
			$tempArray = $row;
			array_push($myArray, $tempArray);
		}
		echo json_encode($myArray);
	}
	$result->close();
}
else 
	{
		
		if ($result = $mysqli->query("SELECT * FROM personas")) {
			$tempArray = array();
			while ($row = $result->fetch_object()) {
				$tempArray = $row;
				array_push($myArray, $tempArray);
			}
			echo json_encode($myArray);
		}
		$result->close();
	}


$mysqli->close();
?>
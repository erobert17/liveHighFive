<?php
$servername = "localhost";
$username = "root";
$password = "Leadgen321";
$dbname = "andrewLaravel";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql1 = "SELECT id FROM users";
$result1 = $conn->query($sql1);
$userIds = [];
if ($result1->num_rows > 0) {
    // output data of each row
    while($row = $result1->fetch_assoc()) {
        #echo "id: " . $row["id"]. "<br>";
        array_push($userIds, $row["id"]);
    }
} else {
    #echo "0 results";
}

$sql = "SELECT * FROM landingpagePrefabs";
$result = $conn->query($sql);
$landingPagePrefabs = [];
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        #echo "id: " . $row["id"]. "<br>";
        array_push($landingPagePrefabs, $row);
    }
} else {
    #echo "0 results";
}

$countAllUsers = 0;
$allUsersThatNeededModified = 0;

foreach ($userIds as $userId) {

	
	//$sql = "INSERT INTO `landingPages`(`user_id`, `title`, `secondaryTitle`, disclaimer`) VALUES (102, 'Digital Download', 'Download the file from the button below.', 'eCommerce')";
	$changeHasAlreadyBeenMadeForThisUser = false;#used only for calculating number changed, Not important
		for ($i=0; $i < count($landingPagePrefabs); $i++) { #for each type of landing page, 
			
	
				#$sqlFirst = 'SELECT * FROM landingPages WHERE user_id = "'.$userId.'" AND type = "'.$testTypeName.'" ';
				$sqlFirst = 'SELECT * FROM landingPages WHERE user_id = "'.$userId.'" AND type = "'.$landingPagePrefabs[$i]["typeName"].'" ';

				$sqlFirstResult = $conn->query($sqlFirst);
				$count = $sqlFirstResult->num_rows;
				

				if ($count > 0) {
					    #echo "This user already has this type <br>";
					echo 'DUPLICATE '.$landingPagePrefabs[$i]["typeName"];
				} else {#doesn't have it so create it
					echo $countAllUsers;
					
					if($changeHasAlreadyBeenMadeForThisUser == false ){
						$allUsersThatNeededModified++;
					}
					
					$changeHasAlreadyBeenMadeForThisUser = true;

					echo $landingPagePrefabs[$i]["title"]. "\xA";
					echo $landingPagePrefabs[$i]["secondTitle"]. "\xA";
					echo $landingPagePrefabs[$i]["typeName"]. "\xA";
					
					#not sure why but the string 'Home Valuation' wont insert in variable form so if $testTypeName == Home valuation we'll just use custom sql string
					$title = $landingPagePrefabs[$i]["title"];
					$secondTitle = $landingPagePrefabs[$i]["secondTitle"];
					$type = $landingPagePrefabs[$i]["typeName"];
					
					$title = addslashes($title);
					$secondTitle = addslashes($secondTitle);
					$type = addslashes($type);

					$sqlF = "INSERT INTO `landingPages`(`user_id`, `title`, `secondaryTitle`, `type`) VALUES (".$userId.", '".$title."', '".$secondTitle."', '".$type."')";
					
					
					
					if ($conn->query($sqlF) === TRUE) {
					    echo "New record created successfully";
					} else {
					    echo "Error: " . $sqlF . "<br>" . $conn->error;
					}
					echo "\xA";
					
			}
		

	}#end foreach($landingPagePrefabs as $type){
	$countAllUsers++;#used to count users but allso to iterate landingPagePrefabs
}


$totalUsersChanged = ($allUsersThatNeededModified / $countAllUsers) * 100;
echo '  --------      ';
echo 'total users : '.$countAllUsers;
echo '  --------      ';
echo $totalUsersChanged . '  Users Changed!!!!!!!!!!!!! ';

$conn->close();


?>
<!DOCTYPE html>
<html>
<head>
	<title>Stats Output</title>
</head>
<body>

<a href="/uploads/users/id/<?php echo $user->id; ?>/csvLP4Output.csv">Download Csv</a>
<?php 

$list = array
          (
          "Email",
          );

$vars = [];
for ($i=0; $i < count($leads); $i++) { 
	array_push($vars, $leads[$i]->email);
	$thisLine  = implode(',', $vars);
	$thisLead = $leads[$i]->email.',';
	array_push($list, $thisLead);

}

$path = '/var/www/recoverleads.com/public_html/andrew/public/uploads/users/id/'.$user->id.'/csvLP4Output.csv';

$file = fopen($path,"w");

            foreach ($list as $line)
              {
                //print '<br>'.$line.' list lines ';
              fputcsv($file,explode(',',$line));
              }
		//http://growyourleads.com/uploads/users/id/102/uploadProductCountdownImg.png
        chmod($path, 0777);
        fclose($file); 

?>

</body>
</html>
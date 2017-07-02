<?php

class Repo {

public static $error = [
		401  => "Unauthorized Access not Allowed.",
		403  => "Perhaps, It went missing.",
		404  => "Perhaps, It went missing.",
		904  => "Error Code Not Found.",
		500  => "Server Error, We messed up.",
		900  => "Please Provide Some Input.",
		6174 => "No Error Found.",
		3350 => "Error in Database.",
		3304 => "Could not Connect to Database.",
		393  => "Invalid Character Used.",
		394  => "Member Already Exists.",
	  	396  => "Incorrect Email.",
	  	397  => "Incorrect Password.",
	  	398  => "Member does not exist.",
	  	399  => "Wrong Login Email and Password.",
	  	921  => "Not Logged In.",
	  	922  => "Already Logged Out.",
		923  => "Cannot Log You In.",
		924  => "Cannot Log You Out.",
	  	903  => "Invalid Token. Please Clear Cookies and Cache, Try Again.",
		350  => "Incorrect Input Provided.",
        6175 => "Registraion was succesful.",
        1530 => 'Something Unexpected Occured.',
        950  => 'Error While Sending Mail',
        951	 => 'Successfully Sent Mail to Your Inbox.',
        392  => 'Successfully Password Changed.',
        931  => 'Successfully Activated Account.',
        930  => 'Could Not Activate Account.',
        2048 => 'File Size too Big.',
        1024 => 'File IO Error.',
];


public static function getError($code = "904"){
	if (isset(self::$error[$code])){
		$code = (int) $code;
		return self::$error[$code];
	} else {
		return self::$error["904"];
	}
}

public static function getToken(){
	return password_hash($_SERVER['REMOTE_ADDR'], PASSWORD_BCRYPT);
}

public static function isToken($hash){
	return password_verify($_SERVER['REMOTE_ADDR'], $hash);
}

public static function redirect($path){
	header('Location:'.$path); die();
}

public static function hash($input){
	return password_hash($input, PASSWORD_BCRYPT);
}

public static function curl($url){
	$curl = curl_init();
    $timeout = 3;
    curl_setopt($curl , CURLOPT_URL , $url);
    curl_setopt($curl , CURLOPT_RETURNTRANSFER , 1);
    curl_setopt($curl , CURLOPT_CONNECTTIMEOUT , $timeout);
    $tmp = curl_exec($curl);
    curl_close($curl);
    return $tmp;
}

}

?>
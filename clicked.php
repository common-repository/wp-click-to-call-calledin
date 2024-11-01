<?php
if(isset($_POST['the_url'])){
$the_url = $_POST['the_url'];
$the_caller = $_POST['caller_phone_number'];
$the_callee = $_POST['callee_phone_number'];
$the_caller_isd = $_POST['caller_country_code'];
$the_callee_isd = $_POST['callee_country_code'];
$the_max = $_POST['max_duration']; 
$urltopass = "$the_url&caller_phone_number=$the_caller&caller_country_code=$the_caller_isd&callee_phone_number=$the_callee&callee_country_code=$the_callee_isd&max_duration=$the_max";
function runinbg($url){
// create a new cURL resource
$ch = curl_init();
// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, $url);
// grab URL and pass it to the browser
curl_exec($ch);
// close cURL resource, and free up system resources
curl_close($ch);
//return $ch;
}
runinbg($urltopass);
echo "Thanks, we will call you in few seconds";//$urltopass;
}
?>

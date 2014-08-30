<?php
// Oort Online Forum Role Fetcher
// - Hipolipolopigus
//
// USAGE
// Query parameter 'u' is the user's forum name. Not case-sensitive.
// 		Example: 
//			oortonline.com/forums/users/hipolipolopigus/
//			mysite.com/oort-supporter.php?u=hipolipolopigus
//
// RETURNS
// "No User" if u is not set
// "Invalid user" if the bbp-user-forum-role element isn't found on the page
// The user's rank; Pathfinder, Trailblazer, Explorer, Adventurer, Wayfarer, Pioneer, Master, or Oortian


$profile_URL = @urldecode($_GET['u']) or die ("No User");
$profile_URL = 'http://oortonline.com/forums/users/' . $profile_URL;

header('content-type: plain-text');
function get_data($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
$dom = new DOMDocument();
@$dom->loadHTML(get_data($profile_URL));
$finder = new DomXPath($dom);
$frr = @$finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' bbp-user-forum-role ')]")->item(0)->nodeValue or die("Invalid user");
echo(substr($frr, 11));
?>

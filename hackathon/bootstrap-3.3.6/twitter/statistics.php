<head>
<script src="../products/js/jquery-1.9.1.min.js" type="text/javascript"></script>
</head>

<?php
error_reporting(0);
session_start();
require 'autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

  $consumer_key = 'B8u99qpRC9k1xMQrWCLF8Ix68';
  $consumer_secret = 'Pyg5uKCne9mpZhq7SgnlOPgg8r5x4l1KbmXMBeBFegZCvV2Z4d';


if(isset($_SESSION['oauth_token'])){
try {
  $oauth_token=$_SESSION['oauth_token'];//unset($_SESSION['oauth_token']);
  $connection = new TwitterOAuth($consumer_key, $consumer_secret);
 //necessary to get access token other wise u will not have permision to get user info
  $params=array("oauth_verifier" => $_SESSION['oauth_verifier'],"oauth_token"=>$_SESSION['oauth_token']);
  $access_token = $connection->oauth("oauth/access_token", $params);
  //now again create new instance using updated return oauth_token and oauth_token_secret because old one expired if u dont u this u will also get token expired error
  $connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token['oauth_token'],$access_token['oauth_token_secret']);
  $content = $connection->get("account/verify_credentials");
  print_r($content);
  
  
  echo "<br /><br />Tweets by User : ".$content->name;
  //https://api.twitter.com/1.1/statuses/user_timeline.json
  
  //print_r($connection->get("statuses/user_timeline"));
   
  $get_tweets = $connection->get("statuses/user_timeline");

	foreach($get_tweets as $tweet) { 
		$tweet_desc = $tweet->text;
			echo "<br />".$tweet_desc;  
	}
	
	
	echo "<br /><br />Favorites by User : ".$content->name;
	
	$get_favorites = $connection->get("favorites/list");

	foreach($get_favorites as $tweet) { 
		$tweet_desc = $tweet->text;
			echo "<br />".$tweet_desc;  
			echo "<br />Favorites Count : ".$tweet->favourites_count;
	}
	
	
  }
  catch(Exception $e) {
	echo 'Caught exception: ',  $e, "\n"; 
  }
}
else{
  //this code will return your valid url which u can use in iframe src to popup or can directly view the page as its happening in this example
  $connection = new TwitterOAuth($consumer_key, $consumer_secret);
  $temporary_credentials = $connection->oauth('oauth/request_token', array("oauth_callback" =>'http://localhost:85/hackathon/bootstrap-3.3.6/twitter/index.php'));
  $_SESSION['oauth_token']=$temporary_credentials['oauth_token'];       
  $_SESSION['oauth_token_secret']=$temporary_credentials['oauth_token_secret'];
  $url = $connection->url("oauth/authorize", array("oauth_token" => $temporary_credentials['oauth_token']));

  // REDIRECTING TO THE URL
  //header('Location: ' . $url); 
  //echo "<a href='".$url."'>Login to Twitter</a>";
  
  echo "<a class='popup' href='".$url."'><img src='./images/twitter-logo.png' /></a>";
}

?>

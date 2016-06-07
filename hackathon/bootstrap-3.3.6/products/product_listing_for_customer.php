<html>
<head> 
	<link type = "text/css" rel = "stylesheet" href="../dist/css/bootstrap.css" />
	<script src="./js/jquery-1.9.1.min.js" type="text/javascript"></script>
</head>

<body>

<div class="container">
    
<ul class="nav nav-pills pull-right">
  <li role="presentation" class="active"><a href="#">Home</a></li>
  <li role="presentation"><a href="#">Profile</a></li>
  <li role="presentation"><a href="#">Messages</a></li>
</ul>

<div class="row">
  <div class="col-md-10 col-md-push-2">  	
	<div class="alert alert-info" role="alert">Thanks for using Twitter and sharing your valuable details with us. We are glad to inform you that we have analysed your social profile and we have come up with some exiciting products that you would be interested in.</div>
	<div class="row" id="product_listing_for_customer" name="product_listing_for_customer"></div>
  </div>
  <div class="col-md-2 col-md-pull-10">
	  <ul class="nav nav-pills nav-stacked">
		  <li role="presentation" class="active"><a href="#">Product Catalogue</a></li>
		  <li role="presentation" class="pull-right"><a href="create_product.php">Create a Product</a></li>
		  <li role="presentation" class="pull-right"><a href="all_products.php">All Products</a></li>
	  </ul>
  </div>
    <div class="col-md-2 col-md-pull-10">
	  <ul class="nav nav-pills nav-stacked">
		  <li role="presentation" class="active"><a href="#">Twitter Analytics</a></li>
		  <li role="presentation" class="pull-right"><a href="twitter_pie_chart_for_products.php">Pie Chart</a></li>
		  <li role="presentation" class="pull-right"><a href="bar_analytical_chart.php">Bar Chart</a></li>				  
	  </ul>
  </div>
</div>

<?php
error_reporting(0);
session_start();
require 'autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

  $consumer_key = 'B8u99qpRC9k1xMQrWCLF8Ix68';
  $consumer_secret = 'Pyg5uKCne9mpZhq7SgnlOPgg8r5x4l1KbmXMBeBFegZCvV2Z4d';

  echo '<pre>';
  print_r($_SESSION);
  echo '<pre>';
  

if(isset($_SESSION['access_token_oauth_token'])){
try { 
  $connection = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['access_token_oauth_token'],$_SESSION['access_token_oauth_token_secret']);
  $content = $connection->get("account/verify_credentials");
  print_r($content);
  
  echo "<br /><br />Tweets by User : ".$content->name;
  //https://api.twitter.com/1.1/statuses/user_timeline.json
  
  //print_r($connection->get("statuses/user_timeline"));
   
  $get_tweets = $connection->get("statuses/user_timeline");

  $strParentTweetDescription = '';
  $strParentFavouriteTweets = '';
  $strParentFollowersDescription = '';
  
	foreach($get_tweets as $tweet) { 
		$tweet_desc = $tweet->text;
		$strParentTweetDescription .= $tweet_desc;
			echo "<br />Text : ".$tweet_desc;  
	}
	
	echo "<br /><br />Favorites by User : ".$content->name;
	
	$get_favorites = $connection->get("favorites/list");

	foreach($get_favorites as $tweet) { 
		$tweet_desc = $tweet->text;
		$strParentFavouriteTweets .= $tweet_desc;
			echo "<br />Text : ".$tweet_desc;  
			echo "<br />Favorites Count : ".$tweet->favourites_count;
	}
	
	echo "<br /><br />User Following other profiles: ".$content->name;	
	$get_friends = $connection->get("friends/list");
	$followersIndex1 = 0;	
	for( $followersIndex1 = 0; $followersIndex1 < count($get_friends->users); $followersIndex1 ++ ) {
		echo "<br />description : ".$get_friends->users[$followersIndex1]->description; 
	}  
	
	echo "<br /><br />User Followers: ".$content->name;	
	$get_followers = $connection->get("followers/list"); 
	$followersIndex2 = 0;	
	for( $followersIndex2 = 0; $followersIndex2 < count($get_followers->users); $followersIndex2 ++ ) {
		echo "<br />description : ".$get_followers->users[$followersIndex2]->description; 
	}  
  }
  catch(Exception $e) {
	echo 'Caught exception: ',  $e, "\n"; 
  }
} 
?>

</div>
<div id="show_user_sec" class="user_section">

</div>
<div id="update_user_sec" class="user_section">

</div>

<!-- View Product : Modal -->
<div class="modal fade" id="viewProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">View Product</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>        
      </div>
    </div>
  </div>
</div>


<!-- Update Product : Modal -->
<div class="modal fade" id="updateProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Product</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

</div>
<script type="text/javascript" src="./js/script.js"></script>

<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
	<script src="../dist/js/bootstrap.js" ></script>
</body>
</html>
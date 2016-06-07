<?php
error_reporting(0);
session_start();
require 'autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
?>
<html>
<head> 
	<link type = "text/css" rel = "stylesheet" href="../dist/css/bootstrap.css" />
	<script src="./js/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	$( document ).ready(function() {
		  $('#twitter_logo').click(function(event) {		  
			var width  = 600,
				height = 600,
				left   = ($(window).width()  - width)  / 2,
				top    = ($(window).height() - height) / 2,
				url    = this.href,
				opts   = 'status=1' +
						 ',width='  + width  +
						 ',height=' + height +
						 ',top='    + top    +
						 ',left='   + left;
			
			window.open(url, 'twitter', opts); 
			return false;
		  });
	  });
	</script>
</head>
<body>
<?php

		  $consumer_key = '';
		  $consumer_secret = '';  

  include('db.php');
  
  $sql1 = "SELECT * FROM hackathon.social_application_mst where social_channel = 'twitter'";

  $data = $con->query($sql1);

  if($data->num_rows>0){
	   while( $row = $data->fetch_array(MYSQLI_ASSOC)){      
		  $consumer_key = $row['consumer_key'];
		  $consumer_secret = $row['consumer_secret'];
	   }
   }else{
    echo "No consumer key and consumer secret values found in database";
   }   
   
   //Check if access token exists for logged in customer : BEGIN   
   $customerId = ''; 
   
   if( $_SESSION['customer_id'] != null ) {
		$customerId = $_SESSION['customer_id'];
   }
   	$sql = "SELECT * FROM customer_social_mst where social_channel = 'twitter' and idcustomer_social_mst = '$customerId';";
	$data = $con->query($sql); 	 
	
	echo $sql;
	
	if($data->num_rows>0){
		   while( $row = $data->fetch_array(MYSQLI_ASSOC)){			   
				  $_SESSION['access_token_oauth_token'] = $row['access_token_oauth_token'];
				  $_SESSION['access_token_oauth_token_secret']  = $row['access_token_oauth_token_secret'];
				 
			header('Location: http://localhost.com:85/hackathon/bootstrap-3.3.6/products/product_listing_for_customer.php'); 
			return;
			 }
	}  
	//Check if access token exists for logged in customer : END
		
if(isset($_SESSION['oauth_token']) && (!$_GET['denied'])){
try {
  $oauth_token=$_SESSION['oauth_token'];unset($_SESSION['oauth_token']);
  $connection = new TwitterOAuth($consumer_key, $consumer_secret);
 //necessary to get access token other wise u will not have permision to get user info
  $params=array("oauth_verifier" => $_GET['oauth_verifier'],"oauth_token"=>$_GET['oauth_token']);
  $access_token = $connection->oauth("oauth/access_token", $params);
  $_SESSION['access_token_oauth_token'] = $access_token['oauth_token'];
  $_SESSION['access_token_oauth_token_secret'] = $access_token['oauth_token_secret'];
    
  //now again create new instance using updated return oauth_token and oauth_token_secret because old one expired if u dont u this u will also get token expired error
  $connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token['oauth_token'],$access_token['oauth_token_secret']);
  $content = $connection->get("account/verify_credentials");
  
  //echo "<br /><br />Tweets by User : ".$content->screen_name; 	  
  }
  catch(Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n"; 
  }
}
else{
  //this code will return your valid url which u can use in iframe src to popup or can directly view the page as its happening in this example
  $connection = new TwitterOAuth($consumer_key, $consumer_secret);
  $temporary_credentials = $connection->oauth('oauth/request_token', array("oauth_callback" =>'http://localhost.com:85/hackathon/bootstrap-3.3.6/products/home.php'));
  $_SESSION['oauth_token']=$temporary_credentials['oauth_token'];       
  $_SESSION['oauth_token_secret']=$temporary_credentials['oauth_token_secret'];
  $url = $connection->url("oauth/authorize", array("oauth_token" => $temporary_credentials['oauth_token']));

  // REDIRECTING TO THE URL
  //header('Location: ' . $url); 
  //echo "<a href='".$url."'>Login to Twitter</a>";
  
  //echo "<a class='popup' href='".$url."'><img src='./images/twitter-logo.png' /></a>";
}

  	if( $_SESSION['access_token_oauth_token'] != null || $_SESSION['access_token_oauth_token_secret'] != null ) {
	
	  $connection = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['access_token_oauth_token'], $_SESSION['access_token_oauth_token_secret']);
	  $content = $connection->get("account/verify_credentials");
  
	  $sql2 = "insert into customer_social_mst(`social_channel`,`access_token_oauth_token`,`access_token_oauth_token_secret`,`screen_name`) 
	  values ('twitter','".$_SESSION['access_token_oauth_token']."','".$_SESSION['access_token_oauth_token_secret']."','".$content->screen_name."');";
	     	 
	   if($con->query($sql2)){
			 //echo "Access Token is saved successfully now set the customer id"; 
			  $sql = "update customer_social_mst set idcustomer_social_mst='$customerId' where access_token_oauth_token = '".$_SESSION['access_token_oauth_token']."' and access_token_oauth_token_secret = '".$_SESSION['access_token_oauth_token_secret']."';"; 
			   
			  if($con->query($sql)){
				//echo "updated";
			  } 
	  }
	  else{
		//echo "Error while saving an access token. Please try again...";
	  }  
	  }
?>
<script>
<?php
		unset($_SESSION['oauth_verifier']);
		unset($_SESSION['oauth_token']);
		
	if( $_GET['denied'] != null || $_GET['denied'] != '') {
?>	
			opener.location.href = 'http://localhost.com:85/hackathon/bootstrap-3.3.6/products/home.php';
			window.close();	
<?php
	} 
	if ( $_GET['oauth_token'] != '') {  
?>				
			opener.location.href = 'http://localhost.com:85/hackathon/bootstrap-3.3.6/products/product_listing_for_customer.php';
			window.close();	
<?php
	}
?>
</script>
<div class="container">
    
<ul class="nav nav-pills pull-right">
  <li role="presentation" class="active"><a href="#">Home</a></li>
  <li role="presentation"><a href="#">Profile</a></li>
  <li role="presentation"><a href="#">Messages</a></li>
</ul>

<div class="row">  
  <div class="col-md-10 col-md-push-2">  
    <div class="thumbnail">
	  <h3 class="text-center">Twitter</h3>      
<?php
	  echo "<a class='popup' href='".$url."' id='twitter_logo'><img src='../products/images/twitter_logo.png' /></a>";
?>	  
      <div class="caption">
        <h3 class="text-center">Get Socialize with Twitter</h3>
        <p class="text-center">Please proceed by login to your Twitter account. In order for us to serve you better in future, you have to authorize the application.</p>
		 
      </div>
    </div>
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
</div>
  

</div>
<script type="text/javascript" src="./js/script.js"></script>

<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
	<script src="../dist/js/bootstrap.js" ></script>
</body>
</html>
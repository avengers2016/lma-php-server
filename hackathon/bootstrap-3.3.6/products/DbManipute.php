<?php
include('db.php');
//error_reporting(0);
session_start();
require 'autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

 if(isset($_REQUEST['actionfunction']) && $_REQUEST['actionfunction']!=''){
$actionfunction = $_REQUEST['actionfunction'];
  
   call_user_func($actionfunction,$_REQUEST,$con,$limit,$adjacent);
}

function saveData($data,$con){
  
  $productName = $data['productName'];
  $productCategory = $data['productCategory'];
  $productCostPrice = $data['productCostPrice'];
  $productDescription = $data['productDescription'];
  $countInStock = $data['countInStock'];
  $productImage = $data['productImage'];
  $productMetaKeywords = $data['productMetaKeywords'];
    
  $sql = "insert into product_mst(`product_name`, `product_category`, `product_cost_price`, `product_description`, `product_count_in_stock`, `product_image`, `product_meta_keywords`) values('$productName','$productCategory','$productCostPrice','$productDescription', '$countInStock','$productImage','$productMetaKeywords')";
  if($con->query($sql)){
    echo "Product Saved Successfully !!!";
  }
  else{
	echo "Error while saving a product. Please try again...";
  }  
}

function saveCustomer($data,$con){
  
  $customerFirstName = $data['customerFirstName'];
  $customerLastName = $data['customerLastName'];
  $customerContactNumber = $data['customerContactNumber'];
  $customerEmailAddress = $data['customerEmailAddress'];
  $customerAccountPassword1 = $data['customerAccountPassword1'];
  $customerAccountPassword2 = $data['customerAccountPassword2'];
     
 $sql = "SELECT * FROM customer_mst where customer_firstname = '$customerFirstName' and customer_lastname = '$customerLastName' and customer_contactnumber = '$customerContactNumber' and customer_emailaddress = '$customerEmailAddress';";

  $data = $con->query($sql);
 
  if($data->num_rows>0){
    echo "Account already exists !!!";
	return;
  }
	 
  $sql = "insert into customer_mst (`customer_firstname`, `customer_lastname`, `customer_contactnumber`, `customer_emailaddress`, `customer_password1`, `customer_password2`) values('$customerFirstName','$customerLastName','$customerContactNumber','$customerEmailAddress', MD5('$customerAccountPassword1'),
  MD5('$customerAccountPassword2'));";
  
  if($con->query($sql)){
    echo "Account is created successfully !!!";
  }
  else{
	echo "Error while creating an accout. Please try again...";
  }   
  
  //Get customer id here only.  
  $sql = "SELECT * FROM customer_mst where `customer_emailaddress` = '$customerEmailAddress' and `customer_password1` = MD5('$customerAccountPassword1');";
  $data = $con->query($sql); 
  if($data->num_rows>0){ 
	  //Get customer id here.  
	   while( $row = $data->fetch_array(MYSQLI_ASSOC)){      
		  $_SESSION['customer_id'] = $row['idcustomer_mst']; 
	   }	   
  } else{
	echo "Sorry, account doesn't exist. Please create an account first to begin ...";
  }  
}

function saveProductEnquiryDetails($data,$con){
  
  $customerFullName = $data['customerFullName'];
  $customerContactNumber = $data['customerContactNumber'];
  $productInterestedIn = $data['productInterestedIn'];
  $customerEmailAddress = $data['customerEmailAddress'];
  $suggestionsandcomments = $data['suggestionsandcomments']; 
  $customerID = $data['customerID']; 
    
  $sql = "insert into product_enquiry_details(`customer_full_name`, `contact_number`, `product_interested_in`, `email_address`, `suggestions_and_comments`, `customer_id`) values('$customerFullName','$customerContactNumber','$productInterestedIn','$customerEmailAddress', '$suggestionsandcomments', '$customerID');";
  
  if($con->query($sql)){
    echo "Product Enquiry is Saved Successfully !!!";
  }
  else{
	echo "Error while saving details. Please try again...";
  }  
}

function loginToPortal($data,$con){
  
  $customerEmailAddress = $data['customerEmailAddress'];
  $customerAccountPassword = $data['customerAccountPassword']; 
     
  $sql = "SELECT * FROM customer_mst where `customer_emailaddress` = '$customerEmailAddress' and `customer_password1` = MD5('$customerAccountPassword');";
  $data = $con->query($sql); 
  if($data->num_rows>0){ 
	  //Get customer id here.  
	   while( $row = $data->fetch_array(MYSQLI_ASSOC)){      
		  $_SESSION['customer_id'] = $row['idcustomer_mst']; 
	   }	  
		echo "success";  
  } else{
	echo "Sorry, account doesn't exist. Please create an account first to begin ...";
  }  
}

function uploadProductImage() {
  //echo $productImage;
  var_dump($_FILES["productImage"]["productImage"]);
  
  if(isset($_FILES["productImage"]["type"]))
  {
		$validextensions = array("jpeg", "jpg", "png");
		$temporary = explode(".", $_FILES["productImage"]["name"]);
		$file_extension = end($temporary);
		
		if ((($_FILES["productImage"]["type"] == "image/png") || ($_FILES["productImage"]["type"] == "image/jpg") || ($_FILES["productImage"]["type"] == "image/jpeg")
		) && ($_FILES["productImage"]["size"] < 10000000)//Approx. 1MB files can be uploaded.
		&& in_array($file_extension, $validextensions)) {
		
				if ($_FILES["productImage"]["error"] > 0)
				{
					echo "Return Code: " . $_FILES["productImage"]["error"] . "<br/><br/>";
				}
				else
				{
					if (file_exists("upload/" . $_FILES["productImage"]["name"])) {
						echo $_FILES["productImage"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";
					}
					else
					{
						$sourcePath = $_FILES['productImage']['tmp_name']; // Storing source path of the file in a variable
						$targetPath = "upload/".$_FILES['productImage']['name']; // Target path where file is to be stored
						move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
						echo "<span id='success'>Image Uploaded Successfully...!!</span><br/>";
						echo "<br/><b>File Name:</b> " . $_FILES["productImage"]["name"] . "<br>";
						echo "<b>Type:</b> " . $_FILES["productImage"]["type"] . "<br>";
						echo "<b>Size:</b> " . ($_FILES["productImage"]["size"] / 1024) . " kB<br>";
						echo "<b>Temp file:</b> " . $_FILES["productImage"]["tmp_name"] . "<br>";
					}
				}
		}
		else
		{
			echo "<span id='invalid'>***Invalid file Size or Type***<span>";
		}   
	}
}

function editUser($data,$con){
  $userid = $data['user'];
  $userid = base64_decode($userid);
   $sql = "select * from crudtable where id=$userid";
  $user = $con->query($sql);
    if($user->num_rows>0){
   $user = $user->fetch_array(MYSQLI_ASSOC);
  ?>
  <form name='signup' id='signup'>
      <div class='row'>
	       <p><label for='username'>First name</label>
		    <input type='text' name='firstname' id='firstname' value='<?php echo $user['firstname']?>' placeholder='Enter First name' /></p>
	   </div>
	   <div class='row'>
	       <p><label for='lastname'>Last name</label>
		    <input type='text' name='lastname' id='lastname' value='<?php echo $user['lastname']?>' placeholder='Enter Last name' /></p>
	   </div>
	   <div class='row'>
	       <p><label for='email'>Email</label>
		    <input type='text' name='email' id='email' value='<?php echo $user['email']?>' placeholder='Enter Email' /></p>
	   </div>
	   <div class='row'>
	        <p><label for='favjob'>Favourite Job</label>
			 <input type='text' name='favjob' id='favjob' value='<?php echo $user['favjob']?>' placeholder='Enter Favorite Job' /></p>
	      
	   </div>
	   <input type="hidden" name="actionfunction" value="updateData" />
	   <input type="hidden" name="user" value="<?php echo base64_encode($user['id']) ?>" />
	   <div class='row'>
	       <input type='button' id='updatesubmit' class='submit' value='Update' />
		   
	   </div>
   </form>
  <?php } 
}
function showData($data,$con,$limit,$adjacent){

echo "HERE....";

  $page = $data['page'];
   if($page==1){
   $start = 0;  
  }
  else{
  $start = ($page-1)*$limit;
  }
   
  $sql = "select * from product_mst order by id_product_mst asc";
  $rows  = $con->query($sql);
  echo $rows  = $rows->num_rows;
  
  //$sql = "select * from product_mst order by id_product_mst asc limit $start,$limit";
  $sql = "select * from product_mst order by id_product_mst asc limit 0 ,10";
  
  $data = $con->query($sql);
  $row_counter = 0;
  $strHeader='<thead><tr><th>#</th><th>Product Name</th><th>Category</th><th>Cost Price</th></tr></thead>';
  if($data->num_rows>0){
   while( $row = $data->fetch_array(MYSQLI_ASSOC)){
      $strBody.="<tr id='".$row['id_product_mst']."'><td>".$row['product_name']."</td><td>".$row['product_category']."</td><td>".$row['product_cost_price']."</td><td><a href=product_details.php?id=".$row['id_product_mst']." class=\"btn btn-primary\" role=\"button\" data-toggle=\"modal\" data-target=\"#viewProduct\">View Details</a><a href=product_details.php?id=".$row['id_product_mst']." type=\"button\" class=\"btn btn-warning\" data-toggle=\"modal\" data-target=\"#updateProduct\">Update</a><a href=product_details.php?id=".$row['id_product_mst']." type=\"button\" class=\"btn btn-danger\">Remove</a></td><td><input type=hidden id='hiddenProductID".$row_counter++."' value=".$row['id_product_mst']." /></td></tr>";
   }
   }else{
    $str .= "<td colspan='5'>No Data Available</td>";
   }   
$str = $str."<tr><td colspan='5'>".pagination($limit,$adjacent,$rows,$page)."</tr></tr>";
$str = $strHeader . '<tbody>'. $strBody . '</tbody>';
echo $str;  
}
function updateData($data,$con){
  $fname = $data['firstname'];
  $lname = $data['lastname'];
  $favjob = $data['favjob'];
  $email = $data['email'];
  $user = $data['user'];
  $user = base64_decode($user);
  $sql = "update crudtable set firstname='$fname',lastname='$lname',email='$email',favjob='$favjob' where id=$user";
  if($con->query($sql)){
    echo "updated";
  }
  else{
   echo "error";
  }
  }
  function deleteUser($data,$con,$limit,$adjacent){
    $user = $data['user'];
    $user = base64_decode($user);	
	$sql = "delete from crudtable where id=$user";
	if($con->query($sql)){
	  showData($data,$con,$limit,$adjacent);
	}
	else{
	echo "error";
	}
  }
function pagination($limit,$adjacents,$rows,$page){	
	$pagination='';
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	echo $prev = $page - 1;							//previous page is page - 1
	echo $next = $page + 1;							//next page is page + 1
	
	echo $lastpage = ceil($rows/$limit);	
	
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<a class='page-numbers' href=\"?page=$prev\">previous</a>";
		else{
			//$pagination.= "<span class=\"disabled\">previous</span>";	
			}
		
		//pages	
		if ($lastpage < 5 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a class='page-numbers' href=\"?page=$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 3 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a class='page-numbers' href=\"?page=$counter\">$counter</a>";					
				}
				
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a class='page-numbers' href=\"?page=$counter\">$counter</a>";					
				}
				
			}
			//close to end; only hide early pages
			else
			{
			
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a class='page-numbers' href=\"$?page=$counter\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a class='page-numbers' href=\"?page=$next\">next</a>";
		else{
			//$pagination.= "<span class=\"disabled\">next</span>";
			}
		$pagination.= "</div>\n";		
	}

	return $pagination;  
}

function showProductListingForCustomer($data,$con,$limit,$adjacent){ 

	/****** User's Twitter Account Data Analytics : BEGIN *******/
	//Get the list of products. 
	 
	$sql = "SELECT product_name FROM product_mst;";
	$data = $con->query($sql);
		
	$arrayProductNames = array();
	  
	  $i=0;  
	   if($data->num_rows>0){
	   while( $row = $data->fetch_array(MYSQLI_ASSOC)){
		  $arrayProductNames[$i++] = $row['product_name'];
	   }
	   }else{
		$strResult .= "No data available...";
	   }     
	   
	$consumer_key = '';
	$consumer_secret = '';  
	$access_token_oauth_token = '';
	$access_token_oauth_token_secret = '';

	$sql = "SELECT * FROM social_application_mst where social_channel = 'twitter'";
	$data = $con->query($sql);

	if($data->num_rows>0){
		   while( $row = $data->fetch_array(MYSQLI_ASSOC)){      
			  $consumer_key = $row['consumer_key'];
			  $consumer_secret = $row['consumer_secret'];
		   }
	}else{
		echo "No consumer key and consumer secret values found in database";
	}  

	$customerID = '';
	if( $_SESSION['customer_id'] != null ) {
		$customerID = $_SESSION['customer_id'];
	}
	
	try { 	
		$sql = "SELECT * FROM customer_social_mst where social_channel = 'twitter' and idcustomer_social_mst = '$customerID';";
		$data = $con->query($sql); 

		if($data->num_rows>0){
			   while( $row = $data->fetch_array(MYSQLI_ASSOC)){
			   
				  $access_token_oauth_token = $row['access_token_oauth_token'];
				  $access_token_oauth_token_secret = $row['access_token_oauth_token_secret'];
			    
		  $strParentTweetDescription = '';
		  $strParentFavouriteTweets = '';
		  $strParentUserFollowsDescription = '';
		  $strParentUserFollowersDescription = '';
		  
		  $connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token_oauth_token, $access_token_oauth_token_secret);
		  $content = $connection->get("account/verify_credentials");
		  
			$get_tweets = $connection->get("statuses/user_timeline"); 
			foreach($get_tweets as $tweet) { 
				$tweet_desc = $tweet->text;
				$strParentTweetDescription .= $tweet_desc;	 
			}	
			
			$get_favorites = $connection->get("favorites/list");
			foreach($get_favorites as $tweet) { 
				$fav_tweet_desc = $tweet->text;
				$strParentFavouriteTweets .= $fav_tweet_desc; 
			}		
						
			$get_friends = $connection->get("friends/list");
			$followersIndex1 = 0;	
			for( $followersIndex1 = 0; $followersIndex1 < count($get_friends->users); $followersIndex1 ++ ) {
				 $strParentUserFollowsDescription .= $get_friends->users[$followersIndex1]->description; 
			}  
				
			$get_followers = $connection->get("followers/list"); 
			$followersIndex = 0;			
			for( $followersIndex = 0; $followersIndex < count($get_followers->users); $followersIndex ++ ) {
				$strParentUserFollowersDescription .= $get_followers->users[$followersIndex]->description; 
			}

			$arrayProductNamesToCount = array();
			$productNameOccurrenceCount = 0;
			$productNameExistsInTweets = false;
			$productNameExistsInFavTweets = false;
			$productNameExistsInFollowsTweets = false;
			$productNameExistsInFollowersTweets = false;
			$strFinalProductList = '';
			
			//Determine whether the product name exists in the tweets or not.
			
			foreach ($arrayProductNames as $arrayKey => $productName) {	 
			
			$strProductNameToken = strtok($productName, " "); 
			 
			while ($strProductNameToken !== false) {				 
				$strProductNameToken = strtok(" "); 
			
				if (stristr($strParentTweetDescription, $strProductNameToken) !== false) {
					//Productname exists in tweets.			
						$productNameExistsInTweets = true;	
				}

				if (stristr($strParentFavouriteTweets, $strProductNameToken) !== false) {
					//Productname exists in Favourites.			
						$productNameExistsInFavTweets = true;			
				}

				if (stristr($strParentUserFollowsDescription, $strProductNameToken) !== false) {
					//Productname exists in Follows Description.			
						$productNameExistsInFollowsTweets = true;			
				}	
				
				if (stristr($strParentUserFollowersDescription, $strProductNameToken) !== false) {
					//Productname exists in Followers Description.			
						$productNameExistsInFollowersTweets = true;			
				}					
			} 				
				if( $productNameExistsInTweets == true || $productNameExistsInFavTweets == true || $productNameExistsInFollowsTweets == true || $productNameExistsInFollowersTweets == true ) {			
					$arrayProductNamesToCount[$arrayKey] = ++$productNameOccurrenceCount;			
					$productNameOccurrenceCount = 0;
					$strFinalProductList .= "'".$productName ."'".', ';
				}else {
					$arrayProductNamesToCount[$arrayKey] = 0;	 
				}

				//If user has tweets or likes for the product then update the details from 'product_preference_from_social_profile'
				if( $productNameExistsInTweets == true || $productNameExistsInFavTweets == true ) {					
					$sql = "update product_preference_from_social_profile set val=$arrayProductNamesToCount[$arrayKey] where product_name='$productName';";
					
					if($con->query($sql)){
						//echo "updated";
					}
					else{
						echo "Error while updating product_preference_from_social_profile";
					}
				}
				 	
				$productNameExistsInTweets = false;
				$productNameExistsInFavTweets = false;		
				$productNameExistsInFollowsTweets = false;
				$productNameExistsInFollowersTweets = false;	
 
				} 	
 			  }
			}else{
					echo "No oauth token and oauth token secret exists in customer_social_mst";
			}   
		  }
		  catch(Exception $e) {
			echo 'Caught exception: ',  $e, "\n"; 
		  }
		   
	/****** User's Twitter Account Data Analytics : END *******/

	//Get rid of last extra , from end.
	
  $strFinalProductList = substr($strFinalProductList, 0, -2);	
  $sql = "select * from product_mst where product_name IN (".$strFinalProductList.") order by id_product_mst asc limit 0 ,10";
    
		$data = $con->query($sql);   
		if($data->num_rows>0){
				   while( $row = $data->fetch_array(MYSQLI_ASSOC)){
				   
					  $strBody.='<div class="col-sm-6 col-md-4"><div class="thumbnail">';
					  $strBody.='<img src='.$row['product_image'].' /><div class="caption"><h3>'.$row['product_name'].'</h3><p>'.$row['product_description'].'</p>';
					  $strBody.='<p><a href=product_details.php?id='.$row['id_product_mst'].' class=\'btn btn-primary\' role=\"button\">View Details</a></p></div></div></div>';
				   }
		} else {
					$str .= "No Data Available";
		}   		   
		$str = $strBody ;
		
		echo $str;  
}

function viewSelectedProductDetails($data,$con){ 

		$productID = $data['productID'];
		$sql = "select * from product_mst where id_product_mst = '$productID'";

		echo $sql;
		return;
		$strBody = '';
		$data = $con->query($sql);   
		if($data->num_rows>0){
				   while( $row = $data->fetch_array(MYSQLI_ASSOC)){
				   
					  $strBody.='<p>';
					  $strBody.='<img src='.$row['product_image'].' />'.$row['product_name'].''.$row['product_description'].''.
					  $row['product_count_in_stock'].$row['product_cost_price'].'</p>';					  
				   }
		} else {
					$str .= "No Data Available";
		}   		   
		$str = $strBody ;		
		echo $str;  
}

function showProductDetailsToCustomer($data,$con,$limit,$adjacent){

  $page = $data['page'];
   if($page==1){
   $start = 0;  
  }
  else{
  $start = ($page-1)*$limit;
  }
   
  $sql = "select * from product_mst order by id_product_mst asc";
  $rows  = $con->query($sql);
  //echo $rows  = $rows->num_rows;
   
  $product_id = $data['product_id'];
  $sql = "select * from product_mst where id_product_mst = ".$product_id." order by id_product_mst asc limit 0 ,10";

  $data = $con->query($sql);
  $strHeader='';
  if($data->num_rows>0){
   while( $row = $data->fetch_array(MYSQLI_ASSOC)){
      $strBody.='<div class="col-sm-6 col-md-12"><div class="thumbnail">';
	  $strBody.='<img src='.$row['product_image'].' /><div class="caption"><h3>'.$row['product_name'].'</h3><p>'.$row['product_description'].'</p>';
	  $strBody.='<p><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#enquirewithus" id="enquiry_form" name="enquiry_form">Enquiry</button> <a href="#" class="btn btn-default" role="button">Back</a><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#enquirewithus" id="enquiry_form" name="enquiry_form">Share on Twitter</button><input type="hidden" id="product_name_hidden" value="'.$row['product_name'].'"/></p>
	  </div></div></div>';
   }
   }else{
    $str .= "No Data Available";
   }    

  $sql = "select * from product_mst where id_product_mst != ".$product_id." order by id_product_mst asc";
  $data = $con->query($sql);
  $strHeader='';
  $strBody.='<h4>Product Cross Sell Strategy : </h4>';
  if($data->num_rows>0){
   while( $row = $data->fetch_array(MYSQLI_ASSOC)){
      $strBody.='<div class="col-sm-6 col-md-4"><div class="thumbnail">';
	  $strBody.='<img src='.$row['product_image'].' /><div class="caption"><h3>'.$row['product_name'].'</h3><p>'.$row['product_description'].'</p>';
	  $strBody.='<p><a href=product_details.php?id='.$row['id_product_mst'].' class=\'btn btn-primary\' role=\"button\">View Details</a></p></div></div></div>';
   }
   }else{
    $str .= "No Data Available";
   }   
$str = $strBody ;
echo $str; 
 
}


function generateProductStatisticsFromTwitterForCustomer($data,$con,$limit,$adjacent){

	//Get the list of products.

  $sql = "SELECT product_name FROM product_mst;";
  $data = $con->query($sql);
    
  $arrayProductNames = array();
  
  $i=0;  
   if($data->num_rows>0){
   while( $row = $data->fetch_array(MYSQLI_ASSOC)){
      $arrayProductNames[$i++] = $row['product_name'];
   }
   }else{
    $strResult .= "No data available...";
   }    

	/****** User's Twitter Account Data Analytics : BEGIN *******/

	$consumer_key = '';
	$consumer_secret = '';  
	$access_token_oauth_token = '';
	$access_token_oauth_token_secret = '';

	$sql = "SELECT * FROM social_application_mst where social_channel = 'twitter'";
	$data = $con->query($sql);

	if($data->num_rows>0){
		   while( $row = $data->fetch_array(MYSQLI_ASSOC)){      
			  $consumer_key = $row['consumer_key'];
			  $consumer_secret = $row['consumer_secret'];
		   }
	}else{
		echo "No consumer key and consumer secret values found in database";
	}  

	try { 	
		$sql = "SELECT * FROM customer_social_mst where social_channel = 'twitter'";
		$data = $con->query($sql);

		if($data->num_rows>0){
			   while( $row = $data->fetch_array(MYSQLI_ASSOC)){
			   
				  $access_token_oauth_token = $row['access_token_oauth_token'];
				  $access_token_oauth_token_secret = $row['access_token_oauth_token_secret'];
			    
		  $strParentTweetDescription = '';
		  $strParentFavouriteTweets = '';
		  $strParentUserFollowsDescription = '';
		  $strParentUserFollowersDescription = '';
		  
		  $connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token_oauth_token, $access_token_oauth_token_secret);
		  $content = $connection->get("account/verify_credentials");
		  
			$get_tweets = $connection->get("statuses/user_timeline"); 
			foreach($get_tweets as $tweet) { 
				$tweet_desc = $tweet->text;
				$strParentTweetDescription .= $tweet_desc;	 
			}	
			
			$get_favorites = $connection->get("favorites/list");
			foreach($get_favorites as $tweet) { 
				$fav_tweet_desc = $tweet->text;
				$strParentFavouriteTweets .= $fav_tweet_desc; 
			}		
			
			$get_friends = $connection->get("friends/list");
			$followersIndex1 = 0;	
			for( $followersIndex1 = 0; $followersIndex1 < count($get_friends->users); $followersIndex1 ++ ) {
				 $strParentUserFollowsDescription .= $get_friends->users[$followersIndex1]->description; 
			}  
				
			$get_followers = $connection->get("followers/list"); 
			$followersIndex = 0;			
			for( $followersIndex = 0; $followersIndex < count($get_followers->users); $followersIndex ++ ) {
				$strParentUserFollowersDescription .= $get_followers->users[$followersIndex]->description; 
			}
			
			$arrayProductNamesToCount = array();
			$productNameOccurrenceCount = 0;
			$productNameExistsInTweets = false;
			$productNameExistsInFavTweets = false;
			$productNameExistsInFollowsTweets = false;
			$productNameExistsInFollowersTweets = false;
			
			//Determine whether the product name exists in the tweets or not.
			
			foreach ($arrayProductNames as $arrayKey => $productName) {	 
			
			$strProductNameToken = strtok($productName, " "); 
			 
			while ($strProductNameToken !== false) {				 
				$strProductNameToken = strtok(" "); 
			
				if (stristr($strParentTweetDescription, $strProductNameToken) !== false) {
					//Productname exists in tweets.			
						$productNameExistsInTweets = true;	
				}

				if (stristr($strParentFavouriteTweets, $strProductNameToken) !== false) {
					//Productname exists in Favourites.			
						$productNameExistsInFavTweets = true;			
				}

				if (stristr($strParentUserFollowsDescription, $strProductNameToken) !== false) {
					//Productname exists in Follows Description.			
						$productNameExistsInFollowsTweets = true;			
				}	
				
				if (stristr($strParentUserFollowersDescription, $strProductNameToken) !== false) {
					//Productname exists in Followers Description.			
						$productNameExistsInFollowersTweets = true;			
				}	
			} 				
				if( $productNameExistsInTweets == true || $productNameExistsInFavTweets == true || $productNameExistsInFollowsTweets == true || $productNameExistsInFollowersTweets == true ) {	
					$arrayProductNamesToCount[$arrayKey] = ++$productNameOccurrenceCount;			
					$productNameOccurrenceCount = 0;
				}else {
					$arrayProductNamesToCount[$arrayKey] = 0;	 
				}
				
				$productNameExistsInTweets = false;
				$productNameExistsInFavTweets = false;		  	
				$productNameExistsInFollowsTweets = false;
				$productNameExistsInFollowersTweets = false;					
								
				//Update the details from 'product_and_social_networking_mapping_status'
				$sql = "update product_and_social_networking_mapping_status set val=$arrayProductNamesToCount[$arrayKey] 
				where product_name='$productName';";
					 
				  if($con->query($sql)){
					//echo "updated successfully";
				  }  else{
					//echo "<br />"."Error while updating product_and_social_networking_mapping_status table.";					
				  }				
				} 	
			  }
			}else{
					echo "No oauth token and oauth token secret exists in customer_social_mst";
			}   
		  }
		  catch(Exception $e) {
			echo 'Caught exception: ',  $e, "\n"; 
		  }
	/****** User's Twitter Account Data Analytics : END *******/
}
?>
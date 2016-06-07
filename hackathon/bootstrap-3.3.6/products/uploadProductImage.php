<?php
include('db.php');

 if(isset($_REQUEST['actionfunction']) && $_REQUEST['actionfunction']!=''){
$actionfunction = $_REQUEST['actionfunction'];
  
   call_user_func($actionfunction,$_REQUEST,$con,$limit,$adjacent);
}

function uploadProductImage() {
  //echo $productImage;
  var_dump($_FILES);
  
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
?>
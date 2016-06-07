<html>
<head> 
	<link type = "text/css" rel = "stylesheet" href="../dist/css/bootstrap.css" />
	<script src="./js/jquery-1.9.1.min.js" type="text/javascript"></script>	
</head>

<body>

<div class="container">
    


<div class="row">
<ul class="nav nav-pills pull-right">
  <li role="presentation" class="active"><a href="#">Home</a></li>
  <li role="presentation"><a href="#">Profile</a></li>
  <li role="presentation"><a href="#">Messages</a></li>
  <li role="presentation"><a href="#">Login</a></li>
</ul>
</div>
<div class="row"><div style="padding-bottom: 80px;"></div></div>
<div class="row">
  <div class="col-md-5 col-md-push-7">
		<form class="form-horizontal" name="login" id="login">
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-10">
			  <input type="email" class="form-control" id="customerEmailAddressLogin" placeholder="Email">
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
			<div class="col-sm-10">
			  <input type="password" class="form-control" id="customerPassword" placeholder="Password">
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <div class="checkbox">
				<label>
				  <input type="checkbox"> Remember me
				</label>
			  </div>
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <button type="submit" class="btn btn-default" id="sign_in">Sign in</button>
			  <button type="button" id="upload_product_image" class="btn btn-primary" data-toggle="modal" data-target="#uploadProductImage">New User?? Sign up</button>			  
			</div>
		  </div>
		  <div id="responseMessage"></div>
		</form>
  </div>
    <div class="col-md-4 col-md-pull-4">
		<img src="./images/hackathon_sample.png" />
	</div>
  <div> 
	
   </div>
</div>
</div>
 
<div class="modal fade" id="uploadProductImage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Create New Account</h4>
      </div>
      <div class="modal-body">
        <div class="row">
  <div class="col-md-12">
   <form name="customer_enquiry_form" id="customer_enquiry_form">
	<div id="resultMessage"></div>
			  <div class="form-group">
				<label for="productName">First Name</label>
				<input type="text" class="form-control" id="customerFirstName" placeholder="First Name" width="50%">
			  </div>
			  <div class="form-group">
				<label for="productCostPrice">Last Name</label>
				<input type="text" class="form-control" id="customerLastName" placeholder="Last Name">
			  </div>
			  <div class="form-group">
				<label for="productDescription">Contact Number</label>
				<input type="number" class="form-control" id="customerContactNumber" placeholder="Contact Number">
			  </div>
			  <div class="form-group">				
				<label for="exampleInputEmail1">Email address</label>
				<input type="email" class="form-control" id="customerEmailAddressCreate" placeholder="Email address">
				<small class="text-muted">We'll never share your email with anyone else.</small>
			  </div>
			  <div class="form-group">
				<label for="exampleInputEmail1">Password</label>
				<input type="password" class="form-control" id="customerAccountPassword1" placeholder="Password"> 
			  </div>
			  <div class="form-group">
				<label for="exampleInputEmail1">Confirm Password</label>
				<input type="password" class="form-control" id="customerAccountPassword2" placeholder="Password">	
			  </div>		
			  <div class="form-group">
				<div id="resultMessage"></div>		
			  </div>
		</form>  
  </div>
</div>
      </div>
      <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="create_account_button">Create Account</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="./js/script.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
	<script src="../dist/js/bootstrap.js" ></script>

</body>
</html>
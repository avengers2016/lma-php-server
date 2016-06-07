<?php
session_start();
?>
<html>
<head> 
	<link type = "text/css" rel = "stylesheet" href="../dist/css/bootstrap.css" />
	<script src="./js/jquery-1.9.1.min.js" type="text/javascript"></script>
	
	<script>

$(function() {

	$('#enquiry_form').on('shown.bs.modal', function () {
			$('#productDescription').val('textjdsjdjs');
   });
});

</script>	
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
	<h4>Product Details</p></h4>
<div class="row" id="show_product_details_to_customer"></div>

<input type="hidden" id="product_id" value="<?php echo $_GET['id']; ?>" />
<!-- Enquiry Form : Modal -->
<div class="modal" id="enquirewithus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Enquire With Us...</h4>
      </div>
      <div class="modal-body">
        <div class="row">
  <div class="col-md-12">
  	<div class="alert alert-info" role="alert">Please help us to know more. We will schedule an appointment with you soon.</div>
   <form name="customer_enquiry_form" id="customer_enquiry_form">
	<div id="resultMessage"></div>
			  <div class="form-group">
				<label for="productName">Full Name</label>
				<input type="text" class="form-control" id="customerFullName" placeholder="Full Name" width="50%">
				<input type="hidden" id="customerID" value="<?php echo $_SESSION['customer_id']; ?>">
			  </div>
			  <div class="form-group">
				<label for="productCostPrice">Contact Number</label>
				<input type="number" class="form-control" id="customerContactNumber" placeholder="Contact Number">
			  </div>
			  <div class="form-group">
				<label for="productDescription">Product interested in</label>
				<input type="text" class="form-control disabled" rows="5" id="productInterestedIn" readonly>
			  </div>
			  <div class="form-group">				
				<label for="exampleInputEmail1">Email address</label>
				<input type="email" class="form-control" id="customerEmailAddress" placeholder="Email address">
				<small class="text-muted">We'll never share your email with anyone else.</small>
			  </div>
			  <div class="form-group">
				<label for="availableInStock">Suggestions / Comments (if any)</label>
				<textarea class="form-control" rows="3" id="suggestionsandcomments" placeholder="Suggestions / Comments (if any)"></textarea>
			  </div>	 			  
		</form>  
  </div>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="product_enquiry_details">Save changes</button>
      </div>
    </div>
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
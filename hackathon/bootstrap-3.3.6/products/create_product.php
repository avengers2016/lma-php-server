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
   <form name="create_product" id="create_product" enctype="multipart/form-data">
	<div id="resultMessage"></div>
			  <div class="form-group">
				<label for="productName">Product Name</label>
				<input type="text" class="form-control" id="productName" placeholder="Product Name" width="50%">
			  </div>
			  <div class="form-group">
				<label for="productCategory">Category</label>
				<div class="dropdown">
					  <button class="btn btn-default dropdown-toggle" type="button" id="productCategory" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						Default
						<span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						<li><a href="#">Category A</a></li>
						<li><a href="#">Category B</a></li>
						<li><a href="#">Category C</a></li>
						<li><a href="#">Category D</a></li>
						<li><a href="#">Category E</a></li>
					  </ul>
				 </div>
			  </div>
			  <div class="form-group">
				<label for="productCostPrice">Cost Price</label>
				<input type="number" class="form-control" id="productCostPrice" placeholder="Cost Price">
			  </div>
			  <div class="form-group">
				<label for="productDescription">Product Description</label>
				<textarea class="form-control" rows="5" id="productDescription" placeholder="Product Description...."></textarea>
			  </div>
			  <div class="form-group">
				<label for="availableInStock">Count in Stock</label>
				<input type="number" class="form-control" id="countInStock" placeholder="Count in Stock" width="20%">
			  </div>
			  <div class="form-group">
				<label for="availableInStock">Meta Keywords</label>
				<input type="text" class="form-control" id="productMetaKeywords" placeholder="Meta Keywords" width="20%">
			  </div>			  
			  <div class="form-group">
				<label for="exampleInputFile">Product Image</label>
				<button type="button" id="upload_product_image" class="btn btn-primary" data-toggle="modal" data-target="#uploadProductImage">Click Here to Upload Product Image</button>
			  </div>
			  <button type="button" class="btn btn-success" id="save_product">Save Changes</button>
		</form>  
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

<!-- Upload Product Image : Modal -->
<div class="modal fade" id="uploadProductImage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<form name="upload_product_image" id="upload_product_image" enctype="multipart/form-data" method="post" >
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Upload Product Image</h4>
			  </div>
			  <div class="modal-body">
					<label for="exampleInputFile">Product Image</label>				
						<input type="file" name="productImage" id="productImage" placeholder="Product Image">				
						<p class="help-block">Image should not be more than 2 MB</p>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="product_image_upload">Upload</button>
				<div id="resultMessageForProductImageUpload"></div>				
			  </div>
			</div>
		  </div>
	</form>
</div>

<script type="text/javascript" src="./js/script.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
	<script src="../dist/js/bootstrap.js" ></script>

</body>
</html>
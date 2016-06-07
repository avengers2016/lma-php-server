<?php
include('db.php');
include_once "./Highchart.php";

$chart = new Highchart();
 
	$sql = "SELECT product_name FROM product_mst ORDER BY product_name ASC;";
	$data = $con->query($sql);
		
	$arrayProductNames = array();
	$arrayProductTweetsOrLikesByCustomers = array();
	$strFinalProductList = '';
	  
	$i=0;  
	if($data->num_rows>0){
		   while( $row = $data->fetch_array(MYSQLI_ASSOC)){
			  $arrayProductNames[$i++] = $row['product_name'];
			  $strFinalProductList .= "'".$row['product_name']."'".', ';
		   }
	}else{
		$strResult .= "No data available...";
	}    
	
	//Get the count for Products.	
	$strFinalProductList = substr($strFinalProductList, 0, -2);	 
	$sql = "SELECT val FROM product_preference_from_social_profile where product_name IN (".$strFinalProductList.") ORDER BY product_name ASC;"; 
	$data = $con->query($sql); 
	
	$i=0;  
	if($data->num_rows>0){
		   while( $row = $data->fetch_array(MYSQLI_ASSOC)){
			  $arrayProductTweetsOrLikesByCustomers[$i++] = intval($row['val']);
		   }
	}else{
		$strResult .= "No data available...";
	}      

$chart->chart->renderTo = "container";
$chart->chart->type = "column";
$chart->title->text = "Product Statistics - Current Status";
$chart->xAxis->categories = $arrayProductNames;
$chart->yAxis->title->text = 'Social Traffic';

$chart->tooltip->formatter = new HighchartJsExpr("function() {
    return '' + this.series.name +': '+ this.y +'';}");

$chart->credits->enabled = false;

$chart->series[] = array('name' => "Barclaycard Series",
                         'data' => $arrayProductTweetsOrLikesByCustomers);
?>
<html>
<head> 
	<link type = "text/css" rel = "stylesheet" href="../dist/css/bootstrap.css" />
	<script src="./js/jquery-1.9.1.min.js" type="text/javascript"></script>
	 <?php
      foreach ($chart->getScripts() as $script) {
          echo '<script type="text/javascript" src="' . $script . '"></script>';
      }
    ?>
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

    <div id="container"></div>	  
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

</div>

    <script type="text/javascript">
    <?php
      echo $chart->render("chart1");
    ?>
    </script>

<script type="text/javascript" src="./js/script.js"></script>

<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
	<script src="../dist/js/bootstrap.js" ></script>
</body>
</html>
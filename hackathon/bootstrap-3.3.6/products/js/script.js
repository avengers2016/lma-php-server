 jQuery(document).ready(function(){
 
var left, opacity, scale; 
var animating; 
  			   
			jQuery.ajax({
							url:"../products/DbManipute.php",
							type:"POST",
							data:"actionfunction=showData",
							cache: false,
							success: function(response){								   
								  jQuery('#userists').html(response);								 
							}		
						});
/* Show all products from db table */

jQuery('#show_products').click(function(){
			   
			   jQuerypage = jQuery(this).attr('href');
			   jQuerypageind = jQuerypage.indexOf('page=');
			   jQuerypage = jQuerypage.substring((jQuerypageind+5));
			   
			   console.log('jQuerypage : '+jQuerypage);
			   
			   jQuery.ajax({
				 url:"../products/DbManipute.php",
						  type:"POST",
						  data:"actionfunction=showData&page="+jQuerypage,
				cache: false,
				success: function(response){
				   
				  jQuery('#userists').html(response);
				 
				}		
			   });
			return false;
			});
			
jQuery('#save_product').click(function(){
			 				 
				//var formdata = jQuery("#create_product").serialize();
												
				var productName = jQuery("#productName").val();  
				var productCategory = jQuery("#productCategory").val();
				var productCostPrice = jQuery("#productCostPrice").val();
				var productDescription = jQuery("#productDescription").val();
				var countInStock = jQuery("#countInStock").val();
				var productImage = jQuery("#productImage").val();
				var productMetaKeywords = jQuery("#productMetaKeywords").val();
				
				var formdata = 'productName='+productName+'&'+'productCategory='+productCategory+'&'+'productCostPrice='+productCostPrice+'&'+
				'productDescription='+productDescription+'&'+'countInStock='+countInStock+'&'+'productImage='+productImage+'&'+'productMetaKeywords='+productMetaKeywords+'&';
				
				formdata += "actionfunction=saveData";
				
				console.log('formdata : ' + formdata);
				
				jQuery.ajax({
					url:"../products/DbManipute.php",
					type:"POST",
					data:formdata,
						cache: false,
					success: function(response){					     
						jQuery('#resultMessage').html(response);
					}					
				});			
				 
			return false;
			});			
			
			
jQuery('#product_image_upload').click(function(){
			 	
				 				
				var formdata = 'productImage='+jQuery("#upload_product_image")+'&';				
				formdata += "actionfunction=uploadProductImage";
				
				console.log("formdata : "+formdata);
				
				
				jQuery.ajax({
					url:"../products/uploadProductImage.php",
					type:"POST",
					data: formdata,
						cache: false,
					success: function(response){					     
						jQuery('#resultMessageForProductImageUpload').html(response);
					}					
				});			
				 
			return false;
			});			
			
/* Show all products from db table for customer in which customer is interested in ... */
 
			   jQuery.ajax({
				 url:"../products/DbManipute.php",
						  type:"POST",
						  data:"actionfunction=showProductListingForCustomer",
				cache: false,
				success: function(response){
				   
				  jQuery('#product_listing_for_customer').html(response);
				 
				}		
			   });
			 	  
/* Show product from db table for customer in which customer is interested in ... */
			
				var product_id = jQuery("#product_id").val();  
				
				console.log('product_id = ' + product_id);
				
			   jQuery.ajax({
				 url:"../products/DbManipute.php",
						  type:"POST",
						  data:"actionfunction=showProductDetailsToCustomer&product_id="+product_id,
				cache: false,
				success: function(response){
				   
				  jQuery('#show_product_details_to_customer').html(response);
				 
				}		
			   }); 
			   
			   
/* Create New Customer Account  */

jQuery('#create_account_button').click(function(){
			 				 
				//var formdata = jQuery("#create_product").serialize();
												
				var customerFirstName = jQuery("#customerFirstName").val();  
				var customerLastName = jQuery("#customerLastName").val();
				var customerContactNumber = jQuery("#customerContactNumber").val();
				var customerEmailAddress = jQuery("#customerEmailAddressCreate").val();
				var customerAccountPassword1 = jQuery("#customerAccountPassword1").val();
				var customerAccountPassword2 = jQuery("#customerAccountPassword2").val();
 				
				var formdata = 'customerFirstName='+customerFirstName+'&'+'customerLastName='+customerLastName+'&'+'customerContactNumber='+customerContactNumber+'&'+'customerEmailAddress='+customerEmailAddress+'&'+'customerAccountPassword1='+customerAccountPassword1+'&'+'customerAccountPassword2='+customerAccountPassword2+'&';
				
				formdata += "actionfunction=saveCustomer";
				
				console.log('formdata : ' + formdata);
				
				jQuery.ajax({
					url:"../products/DbManipute.php",
					type:"POST",
					data:formdata,
						cache: false,
					success: function(response){					     
						jQuery('#resultMessage').html(response);
						jQuery("#customerFirstName").val('');  
						jQuery("#customerLastName").val('');
						jQuery("#customerContactNumber").val('');
						jQuery("#customerEmailAddressCreate").val('');
						jQuery("#customerAccountPassword1").val('');
						jQuery("#customerAccountPassword2").val('');						
					}					
				});			
				 
			return false;
			});	


jQuery('#sign_in').click(function(){			 	
				 				
				var customerEmailAddress = jQuery("#customerEmailAddressLogin").val();
				var customerAccountPassword = jQuery("#customerPassword").val();
 				
				var formdata = 'customerEmailAddress='+customerEmailAddress+'&'+'customerAccountPassword='+customerAccountPassword+'&';
				
				formdata += "actionfunction=loginToPortal";
				
				console.log('formdata : ' + formdata);
				
				jQuery.ajax({
					url:"../products/DbManipute.php",
					type:"POST",
					data:formdata,
						cache: false,
					success: function(response){					     
						jQuery('#responseMessage').html(response); 
						jQuery("#customerEmailAddressLogin").val('');
						jQuery("#customerPassword").val(''); 	

						if( response == "success" ) {
							window.location.href = "/hackathon/bootstrap-3.3.6/products/home.php";
						}
					}					
				});					
				 
			return false;
			});		


/* Generate Product Statistics From Twitter For Customer ... */
			
			   jQuery.ajax({
				 url:"../products/DbManipute.php",
						  type:"POST",
						  data:"actionfunction=generateProductStatisticsFromTwitterForCustomer",
				cache: false,
				success: function(response){				   
				  jQuery('#showStatistics').html(response);				 
				}		
			   }); 	


/* Save product enquiry details */			   

jQuery('#product_enquiry_details').click(function(){
			 				 
				//var formdata = jQuery("#create_product").serialize();
												
				var customerFullName = jQuery("#customerFullName").val();  
				var customerContactNumber = jQuery("#customerContactNumber").val();
				var productInterestedIn = jQuery("#productInterestedIn").val();
				var customerEmailAddress = jQuery("#customerEmailAddress").val();
				var suggestionsandcomments = jQuery("#suggestionsandcomments").val(); 
				var customerID = jQuery("#customerID").val(); 
				
				var formdata = 'customerFullName='+customerFullName+'&'+'customerContactNumber='+customerContactNumber+'&'+'productInterestedIn='+productInterestedIn+'&'+'customerEmailAddress='+customerEmailAddress+'&'+'suggestionsandcomments='+suggestionsandcomments+'&'+'customerID='+customerID+'&';
				
				formdata += "actionfunction=saveProductEnquiryDetails";
				
				console.log('formdata : ' + formdata);
				
				jQuery.ajax({
					url:"../products/DbManipute.php",
					type:"POST",
					data:formdata,
						cache: false,
					success: function(response){					     
						jQuery('#resultMessage').html(response);
					}					
				});			
				 
			return false;
			});	

/* Show selected product details from db table ... */
 /*
				var productID = jQuery(this).closest('tr').text();
 
				var formdata = 'productID='+productID+'&';				
				formdata += "actionfunction=viewSelectedProductDetails";				
				console.log('formdata : ' + formdata);
				
				jQuery.ajax({
					url:"../products/DbManipute.php",
					type:"POST",
					data:formdata,
						cache: false,
						success: function(response){					     
							jQuery('#viewProductDetails').html(response);
						}					
				});
*/				
});	
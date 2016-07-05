<!url : http://omega.uta.edu/ !-->

<?php
session_start();
$categoryxml = file_get_contents('$url : http://test.localfeedbackloop.com/api?apiKey=61067f81f8cf7e4a1f673cd230216112&noOfReviews=10&internal=1&yelp=1&google=1&offset=50&threshold=1');
$obj = json_decode($categoryxml);
echo $obj;
$Category = new SimpleXMLElement($categoryxml);
?>
<html>
<head><title>Buy Products</title>
<style type="text/css">
    table,th,td{
	    border:1px solid white;
		background-color:#505050;
    }
    html {
    background-color:#888888;
    }	
	fieldset {
	background-color:#505050;
	}
	a {
	color :#F00000 ;
	}
</style>
</head>
<body>
<b>Shopping Basket:</b>

<?php 

//remove one item from basket
if(isset($_GET['delete'])){
$id = $_GET['delete'];

//re index array 
$_SESSION['cart'] = array_values($_SESSION['cart']);
$count = count($_SESSION['cart']);
	for ($i=0;$i<$count;$i++){
		if($id==$_SESSION['cart'][$i]['id']){
		unset($_SESSION['cart'][$i]);
		break;
		}
	}
}

// empty the basket 
if(isset($_GET['clear'])){
	unset($_SESSION['cart']);
	unset($_SESSION['products']);
}

//add item to cart
if(isset($_GET['buy'])){
$selectedItem =  $_GET['buy'];
	foreach($_SESSION['products'] as $item){
		if($selectedItem == $item['id']){			
			$_SESSION['cart'][] = array('id' => $item['id'],'name' => $item['name'],'price' => $item['price'],'image' => $item['image'],'offers' => $item['offers']);
		}
	}
	
}
//to display the cart 
if(isset($_SESSION['cart'])){
    $price = 0;
	echo '<table border="1">';
	foreach($_SESSION['cart'] as $item){
	  echo '<tr>';
	  echo '<td><a href=buy.php?buy='.$item['id'].'><img src='.$item['image'].'/></a></td>';
	  echo '<td>'.$item['name'].'</td>';
	  echo '<td>'.$item['price'].'</td>';
	  echo '<td><a href='.$item['offers'].'>Offers</a></td>';
	  echo '<td><a href=buy.php?delete='.$item['id'].'>Delete</a></td>';
	  echo '</tr>';
	  $price += $item['price'];
	}
	echo '</table>';
	echo 'Total Price: '.$price.' $'; 
}

?>
<form method="GET" action="buy.php">
   <input type="hidden" value="1" name="clear"></input> 
   <input type="submit" value="Empty Basket"></input>
</form> 
<form method="GET" action="buy.php">
	<fieldset>
		<legend><b>Find Products:</b></legend>
		<label>Category:</label>
		<select name="category">
		<optgroup label="Computers:">
		<option value="<?php echo $Category->category['id'] ?>"><?php echo $Category->category->name ?></option> 
            <?php
            	foreach($Category->category->categories->category as $mainCategories){
         	?>
       		<optgroup label="<?php echo $mainCategories->name ?>">
            <option value="<?php echo $mainCategories['id'] ?>"><?php echo $mainCategories->name ?></option>
	        <?php
             	foreach($mainCategories->categories->category as $subCategories){
            ?>
            <option value="<?php echo $subCategories['id'] ?>"><?php echo $subCategories->name ?></option>
            <?php } } ?>
		</select>

		<label>
		Search keywords:
		<input type="text" name="search"/>
                </label>
		<label>
		<input type="submit" value="search"/>
		</label>
	</fieldset>
</form>
<?php

error_reporting(E_ALL);
ini_set('display_errors','On');

if(isset($_GET['search'])){
	if(isset($_SESSION['products'])){
	unset($_SESSION['products']);
	}
	$category = $_GET['category'];
	$keyword = urlencode($_GET['search']);
	$uri= "http://sandbox.api.ebaycommercenetwork.com/publisher/3.0/rest/GeneralSearch?apiKey=78b0db8a-0ee1-4939-a2f9-d3cd95ec0fcc&trackingId=7000610&categoryId=$category&keyword=$keyword&numItems=20";
	$searchResults = file_get_contents($uri);
	$search = new SimpleXMLElement($searchResults);
	foreach($search->categories->category->items->product as $results){
		$_SESSION['products'][]= array('id' => (string)$results['id'],'name' => (string)$results->name,'price' => (string)$results->minPrice,'image' => (string)$results->images->image[0]->sourceURL,'offers' => (string)$results->productOffersURL);
	}
	//check if null and create table
	if(!empty($_SESSION['products'])){
	echo '<table border="1">'; 
	echo '<tr><th>Product</th><th>Product Name</th><th>Best Price</th><th>Offers</th></tr>';
	foreach($search->categories->category->items->product as $item){
	  echo '<tr>';
	  echo '<td><a href=buy.php?buy='.$item['id'].'><img src='.$item->images->image[0]->sourceURL.'/></a></td>';
	  echo '<td>'.$item->name.'</td>';
	  echo '<td>'.$item->minPrice.'</td>';
	  echo '<td><a href='.$item->productOffersURL.',target="_blank">Offers</a></td>';
	  echo '</tr>';
	}
	echo '</table>';
	}else{
	echo "No Products Found, Please Select another search criteria.";
	}
}


?>
</body>
</html>

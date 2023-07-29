<?php
require "process_form.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Including the main php that
include_once 'productClasses/MProductList.php'; // Where my main class is that the below php files are extending
include_once 'productClasses/Book.php';
include_once 'productClasses/DVD.php';
include_once 'productClasses/Furniture.php';

$children = array();

foreach (get_declared_classes() as $class) {
	if (is_subclass_of($class, 'MProductList')) {
		$children[] = $class;
	}
}

// Parse form Data and add inventory to database
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sku'])) {
	// ... your existing code for adding inventory ...
}

// Perform Mass Delete
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
	if (isset($_POST['delete'])) {
		$deleteSkus = $_POST['delete'];
		$deleteSkus = array_unique($deleteSkus); // Remove duplicate SKUs
		$deleteSkus = array_map('mysqli_real_escape_string', array_fill(0, count($deleteSkus), $con), $deleteSkus);
		$deleteSkusString = implode("', '", $deleteSkus);

		$deleteQuery = "DELETE FROM products WHERE sku IN ('$deleteSkusString')";
		if (!mysqli_query($con, $deleteQuery)) {
			error_log("Error deleting products: " . mysqli_error($con));
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
     <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Products List</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"  integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
    crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>

</head>

<body>
   <div class="margin-for-page" id="pageContent">
    <form method="post" action="process_form.php">
        <!-- Buttons: Add + MASS DELETE -->
         <div class='row g-0'>
                <div class="header">
                    <h2>Products List</h2>
<div style="margin-top: 35px; margin-bottom: 40px;">
    <a href="add-product.php" class="btn btn-success" style="padding-right: 10px;">ADD</a>
<input id="mass-delete-btn" type="submit" value="MASS DELETE" name="please_delete" class="btn btn-danger">

                    </div>
                </div>
                <hr>
            </div>

<div class="d-flex flex-row bd-highlight mb-3 flex-wrap">
    <?php
// To now go through the array
$ascorder = "SELECT * FROM products ORDER BY name ASC";
$sql = mysqli_query($con, $ascorder);
$productCount = mysqli_num_rows($sql);

if ($productCount > 0) {
	$productsHTML = ''; // Variable to store the HTML for all products

	while ($row = mysqli_fetch_object($sql)) {
		$key = array_search($row->productType, $children);
		$ourNewProduct = new $children[$key]();
		$ourNewProduct->setValues($row->sku, $row->name, $row->price != '' ? $row->price : 'N/A',
			$row->size, $row->height, $row->width, $row->length, $row->weight);
		$productsHTML .= $ourNewProduct->getInfo(); // Append product's HTML to the variable
	}

	// Display the products in a horizontal layout
	echo '<div class="product-container d-flex flex-wrap">' . $productsHTML . '</div>';
}
?>
</div>
    <!-- Including Scandiweb Test Footer -->
    <?php include_once "template-footer.php";?>
    </div>

<script type="text/javascript">
    // Function to handle the Mass Delete functionality
    function performMassDelete(event) {
        event.preventDefault(); // Prevent the default form submission

        const checkboxes = document.querySelectorAll('.delete-checkbox:checked');
        if (checkboxes.length > 0) {
            const deleteSkus = Array.from(checkboxes).map(checkbox => checkbox.value);

            // Send an AJAX request to the server-side script for deletion
            const xhr = new XMLHttpRequest();
           xhr.open('POST', 'process_form.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Handle the success response
                    // Optionally, you can perform any other action after deletion, such as updating the UI or refreshing the product list.
                    location.reload(); // Example: Refresh the page after deletion
                } else {
                    // Handle the error response
                    console.log('Error deleting items: ' + xhr.statusText);
                }
            };
            xhr.send('delete=' + encodeURIComponent(JSON.stringify(deleteSkus)));
        }
    }

    // Attach the performMassDelete function to the Mass Delete button
    document.addEventListener('DOMContentLoaded', function() {
        const massDeleteBtn = document.getElementById('mass-delete-btn');
        massDeleteBtn.addEventListener('click', performMassDelete);
    });
</script>


</body>
</html>

<?php
$db_host = "localhost";
$db_username = "root";
$db_pass = "";
$db_name = "scandi_db";

$con = mysqli_connect($db_host, $db_username, $db_pass) or die("Could not connect to MySQL");
mysqli_select_db($con, $db_name) or die("Could not select database");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['delete'])) {
		$deleteSkus = json_decode($_POST['delete'], true);
		$deleteSkus = array_map('mysqli_real_escape_string', array_fill(0, count($deleteSkus), $con), $deleteSkus);
		$deleteSkusString = implode("', '", $deleteSkus);

		// Delete selected SKUs
		$query = "DELETE FROM products WHERE sku IN ('$deleteSkusString')";
		if (!mysqli_query($con, $query)) {
			error_log("Error deleting products: " . mysqli_error($con));
		}
	} else {
		// Retrieve form data and sanitize
		$sku = mysqli_real_escape_string($con, $_POST['sku'] ?? '');
		$name = mysqli_real_escape_string($con, $_POST['name'] ?? '');
		$price = mysqli_real_escape_string($con, $_POST['price'] ?? '');
		$type = mysqli_real_escape_string($con, $_POST['productType'] ?? '');
		$size = !empty($_POST['size']) ? mysqli_real_escape_string($con, $_POST["size"]) : null;
		$height = mysqli_real_escape_string($con, $_POST['height'] ?? '');
		$width = mysqli_real_escape_string($con, $_POST['width'] ?? '');
		$length = mysqli_real_escape_string($con, $_POST['length'] ?? '');
		$weight = mysqli_real_escape_string($con, $_POST['weight'] ?? '');

		// Prepare the query using placeholders
		$query = "INSERT INTO products (sku, name, price, productType, size, height, width, length, weight) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

		// Prepare the statement
		$stmt = mysqli_prepare($con, $query);

		// Bind parameters to the prepared statement
		mysqli_stmt_bind_param($stmt, "ssissiiii", $sku, $name, $price, $type, $size, $height, $width, $length, $weight);

		// Execute the statement
		mysqli_stmt_execute($stmt);

		// Check for errors during execution
		if (mysqli_stmt_errno($stmt)) {
			die("Query failed: " . mysqli_stmt_error($stmt));
		}

		mysqli_stmt_close($stmt);
	}

	mysqli_close($con);

	// Redirect to index.php
	header("Location: index.php");
	exit();
}
?>

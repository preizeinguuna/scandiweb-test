
<!DOCTYPE html>
<html lang="en">
<head>
     <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Product Add</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
          crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body>
    <div class="margin-for-page" id="pageContent">
        <form name="product_form" action="process_form.php" method="post" id="product_form" onsubmit="return validateForm()">
            <!-- Buttons: Save + Cancel -->
            <div class='row g-0'>
                        <div class="header">
                                <h2>Product Add</h2>
                               <div style="margin-top: 40px; margin-bottom: 30px;">
                         <button type="submit" class="btn btn-success me-2" onclick="saveAndRedirect()">Save</button>
                            <button type="button" class="btn btn-danger" onclick="window.location.href='index.php'">Cancel</button>
                                </div>
                            </div>
                        <hr style="margin-bottom: 60px;">
                </div>

          <!-- Form Content - SKU, Name, Price, Type Switcher, Disk Attributes, Furniture Attributes, Book Attributes -->
                <div class="form-width-mine">
                    <div class="margin-top-bottom form-group row">
                        <label class="col-sm-2 col-form-label">SKU</label>
                        <div class="col-sm-10">
                            <input name="sku" type="text" class="form-control" id="sku" required>
                        </div>
                    </div>
                    <div class="margin-top-bottom form-group row">
                        <label class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input name="name" type="text" class="form-control" id="name" required>
                        </div>
                    </div>
                    <div class="margin-top-bottom form-group row">
                        <label class="col-sm-2 col-form-label">Price($)</label>
                        <div class="col-sm-10">
                            <input name="price" type="number" class="form-control" id="price" required>
                        </div>
                    </div>
                   <div class="margin-top-bottom form-group row">
                <label class="col-sm-6 col-form-label">Type Switcher:</label>
                <div class="col-sm-6">
                    <select name="productType" class="form-control" id="productType" required onchange="toggleAttributes()" style="width: 140px;">
                        <option value="">Type Switcher</option>
                        <option value="DVD">DVD-disk</option>
                        <option value="Furniture">Furniture</option>
                        <option value="Book">Book</option>
                    </select>
                </div>
                  </div>


                    <div id="DVD" class="not-here form-group">
                <div class="row mb-3 mt-4">
                    <div class="col-sm-6 text-end">
                        <label for="size" class="form-label">Size (MB)</label>
                    </div>
                    <div class="col-sm-6">
                        <input name="size" type="number" class="form-control" id="size" style="width: 180px;">
                    </div>
                </div>
                <br />
                <p class='hint' style='margin-top: 5px;'></p>
            </div>



        <div id="Furniture" class="not-here form-group">
            <div class="row mb-3 mt-4">
                <div class="col-sm-6 text-end">
                    <label for="height" class="form-label">Height(CM)</label>
                </div>
                <div class="col-sm-6">
                    <input name="height" type="number" class="form-control" id="height" style="width :230px;">
                </div>
            </div>
            <div class="row mb-3 mt-4">
                <div class="col-sm-6 text-end">
                    <label for="width" class="form-label">Width(CM)</label>
                </div>
                <div class="col-sm-6">
                    <input name="width" type="number" class="form-control" id="width" style="width: 230px;">
                </div>
            </div>
            <div class="row mb-3 mt-4">
                <div class="col-sm-6 text-end">
                    <label for="length" class="form-label">Length(CM)</label>
                </div>
                <div class="col-sm-6">
                    <input name="length" type="number" class="form-control" id="length" style="width: 230px;">
                </div>
            </div>
            <br />
            <p class='hint' style='margin-top: 5px;'></p>
        </div>

        <div id="Book" class="not-here form-group">
            <div class="row mb-3 mt-4">
                <div class="col-sm-6 text-end">
                    <label for="weight" class="form-label">Weight(KG)</label>
                </div>
                <div class="col-sm-6">
                    <input name="weight" type="number" class="form-control" id="weight" style="width: 230px;">
                </div>
            </div>
            <br />
            <p class='hint' style='margin-top: 5px;'></p>
        </div>
        </form>
    </div>


<script>
     function toggleAttributes() {
    var productType = document.getElementById("productType").value;
    var dvdDiv = document.getElementById("DVD");
    var furnitureDiv = document.getElementById("Furniture");
    var bookDiv = document.getElementById("Book");

    // Hide all attribute fields and descriptions
    dvdDiv.style.display = "none";
    furnitureDiv.style.display = "none";
    bookDiv.style.display = "none";

    // Show the attribute fields based on the selected product type
    if (productType === "DVD") {
        dvdDiv.style.display = "block";
        showNotification("Please provide size", "DVD");
    } else if (productType === "Furniture") {
        furnitureDiv.style.display = "block";
        showNotification("Please provide dimensions", "Furniture");
    } else if (productType === "Book") {
        bookDiv.style.display = "block";
        showNotification("Please provide weight", "Book");
    }
}




        function validateForm() {
            var productType = document.getElementById("productType").value;
            var isValid = true;

            if (productType === "DVD") {
                var size = document.getElementById("size").value;
                if (!size) {
                    isValid = false;
                    showNotification("Please provide size", "DVD");
                }
            } else if (productType === "Furniture") {
                var height = document.getElementById("height").value;
                var width = document.getElementById("width").value;
                var length = document.getElementById("length").value;
                if (!height || !width || !length) {
                    isValid = false;
                    showNotification("Please provide dimensions", "Furniture");
                }
            } else if (productType === "Book") {
                var weight = document.getElementById("weight").value;
                if (!weight) {
                    isValid = false;
                    showNotification("Please provide weight", "Book");
                }
            }

            if (!isValid) {
                return false;
            }

            // Other form validation logic

            return true;
        }

        function showNotification(message, productType) {
    var hintElements = document.getElementsByClassName("hint");

    for (var i = 0; i < hintElements.length; i++) {
        var hintElement = hintElements[i];
        if (hintElement.parentNode.id === productType) {
            hintElement.innerHTML = "<strong>" + message + "</strong>";
            hintElement.style.display = "block"; // Show the error message
        }
    }
}


        // Redirect function for the "SAVE" button
        function cancelForm() {
            // Redirect to index.php or any other desired page
            window.location.href = "index.php";
        }
    </script>

    <!-- Including Scandiweb Test Footer -->
    <?php include_once "template-footer.php";?>
</body>
</html>

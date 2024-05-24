<?php include 'partials/head.php'; ?>
<?php include 'config.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $image = '';

    // Handling image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = basename($_FILES["image"]["name"]);
        $target_dir = "uploads/";
        $target_file = $target_dir . $imageName;

        // Save the file to the server
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $target_file;
        }
    }

    // Insert into the database
    $sql = "INSERT INTO items (name, description, category, image, quantity) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $description, $category, $image, $quantity);

    if ($stmt->execute()) {
        $success_message = "Item saved successfully.";
    } else {
        $error_message = "Error saving item: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include 'partials/navbar.php'; ?>
        <?php include 'partials/sidebar.php'; ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper mi-bg">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">New Item</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <form action="new-item.php" method="post" enctype="multipart/form-data">
                                <div class="card">
                                    <div class="card-body">
                                        <?php
                                        if (!empty($success_message)) {
                                            echo '<div class="alert alert-success">' . $success_message . '</div>';
                                        }
                                        if (!empty($error_message)) {
                                            echo '<div class="alert alert-danger">' . $error_message . '</div>';
                                        }
                                        ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="font-weight: normal;" for="name">Name</label>
                                                    <input name="name" type="text" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="font-weight: normal;" for="category">Category</label>
                                                    <select name="category" class="form-control" required>
                                                        <option value="returnable">Returnable</option>
                                                        <option value="nonreturnable">Non-Returnable</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="font-weight: normal;" for="description">Description</label>
                                                    <input name="description" type="text" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="font-weight: normal;" for="quantity">Quantity in stock</label>
                                                    <input name="quantity" type="number" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="font-weight: normal;" for="image">Image</label><br/>
                                                    <input type="file" name="image" id="imageInput" accept="image/*" class="form-control">
                                                    <div class="image-preview" id="imagePreview">
                                                        <p>No image selected</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <div class="card-tools text-right">
                                            <button name="submit" type="submit" class="btn btn-success">Save item</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <script>
                                document.getElementById('imageInput').addEventListener('change', function(event) {
                                    const file = event.target.files[0];
                                    if (file) {
                                        const reader = new FileReader();
                                        reader.onload = function(e) {
                                            const imagePreview = document.getElementById('imagePreview');
                                            imagePreview.innerHTML = `<img src="${e.target.result}" alt="Selected Image" class="img-fluid">`;
                                        }
                                        reader.readAsDataURL(file);
                                    } else {
                                        document.getElementById('imagePreview').innerHTML = '<p>No image selected</p>';
                                    }
                                });
                            </script>
                        </div>
                    </div><!-- /.main-row -->
                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include 'partials/footer.php'; ?>
    </div>
    <!-- ./wrapper -->
    <?php include 'partials/foot.php'; ?>
</body>
</html>

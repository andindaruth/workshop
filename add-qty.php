<?php
// Include the database connection
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the item ID and the quantity to add from the form submission
    $itemId = $_POST['item_id'];
    $quantityToAdd = $_POST['quantity'];

    // Retrieve the current quantity and category of the item from the database
    $sql = "SELECT quantity, category FROM items WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $itemId);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();

    if ($item) {
        // Calculate the new quantity
        $newQuantity = $item['quantity'] + $quantityToAdd;

        // Update the quantity in the database
        $updateSql = "UPDATE items SET quantity = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ii", $newQuantity, $itemId);
        $updateStmt->execute();

        // Redirect to the appropriate page based on the category
        if ($item['category'] == 'returnable') {
            header("Location: returnable.php");
        } else {
            header("Location: non-returnable.php");
        }
        exit();
    } else {
        echo "Item not found.";
    }
} else {
    // Retrieve the item ID from the query string
    if (isset($_GET['id'])) {
        $itemId = $_GET['id'];

        // Retrieve the item details from the database
        $sql = "SELECT * FROM items WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $itemId);
        $stmt->execute();
        $result = $stmt->get_result();
        $item = $result->fetch_assoc();
    }
}
?>

<?php include 'partials/head.php'; ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include 'partials/navbar.php'; ?>
        <?php include 'partials/sidebar.php'; ?>
        <div class="content-wrapper mi-bg">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Add Quantity</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <?php if ($item): ?>
                                        <form action="add-qty.php" method="POST">
                                            <div class="form-group">
                                                <label for="name">Item Name</label>
                                                <input type="text" class="form-control" id="name" value="<?php echo htmlspecialchars($item['name']); ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="quantity">Current Quantity</label>
                                                <input type="text" class="form-control" id="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="quantityToAdd">Quantity to Add</label>
                                                <input type="number" class="form-control" id="quantityToAdd" name="quantity" required>
                                            </div>
                                            <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                                            <button type="submit" class="btn btn-success">Add Quantity</button>
                                        </form>
                                    <?php else: ?>
                                        <p>Item not found.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include 'partials/footer.php'; ?>
    </div>
    <?php include 'partials/foot.php'; ?>
</body>
</html>

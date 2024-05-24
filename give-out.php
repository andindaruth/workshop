<?php
// Include the database connection
include 'config.php';

// Fetch people for the dropdown
$people_result = $conn->query("SELECT id, name FROM people");

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $person_id = $_POST['person_id'];
    $item_id = $_POST['item_id'];
    $reason = $_POST['reason'];
    $qty_taken = $_POST['qty_taken'];

    // Retrieve the current quantity and category of the item from the database
    $sql = "SELECT quantity, category FROM items WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();

    if ($item && $qty_taken > 0 && $qty_taken <= $item['quantity']) {
        $qty_unreturned = $qty_taken;  // Initially, all taken items are unreturned
        $taken_at = date('Y-m-d H:i:s');

        // Insert into transactions table
        $stmt = $conn->prepare("INSERT INTO transactions (person_id, item_id, reason, qty_taken, qty_unreturned, taken_at) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisiii", $person_id, $item_id, $reason, $qty_taken, $qty_unreturned, $taken_at);
        $stmt->execute();
        $stmt->close();

        // Update the quantity in stock in the items table
        $new_quantity = $item['quantity'] - $qty_taken;
        $conn->query("UPDATE items SET quantity = $new_quantity WHERE id = $item_id");

        // Redirect based on the item category
        if ($item['category'] == 'returnable') {
            header("Location: taken-returnable.php");
        } else {
            header("Location: taken-non-returnable.php");
        }
        exit();
    } else {
        $error = "Invalid quantity.";
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
                            <h1 class="m-0">Give Out Item</h1>
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
                                        <form action="give-out.php?id=<?php echo htmlspecialchars($item['id']); ?>" method="POST">
                                            <div class="form-group">
                                                <label for="name">Item Name</label>
                                                <input type="text" class="form-control" id="name" value="<?php echo htmlspecialchars($item['name']); ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="person_id">Person</label>
                                                <select name="person_id" class="form-control" required>
                                                    <option value="">Select Person</option>
                                                    <?php while ($person = $people_result->fetch_assoc()): ?>
                                                        <option value="<?php echo $person['id']; ?>"><?php echo $person['name']; ?></option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="reason">Reason</label>
                                                <textarea name="reason" class="form-control" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="qty_taken">Quantity Taken</label>
                                                <input type="number" class="form-control" id="qty_taken" name="qty_taken" required>
                                            </div>
                                            <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </form>
                                    <?php else: ?>
                                        <p>Item not found.</p>
                                    <?php endif; ?>
                                    <?php if (isset($error)): ?>
                                        <div class="alert alert-danger mt-3">
                                            <?php echo $error; ?>
                                        </div>
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

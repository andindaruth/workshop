<?php
// Include the database connection
include 'config.php';

// Check if a transaction ID is provided
if (isset($_GET['id'])) {
    $transactionId = $_GET['id'];

    // Fetch the transaction details
    $sql = "
        SELECT 
            t.id, 
            t.qty_taken, 
            t.qty_returned, 
            t.qty_unreturned, 
            t.item_id, 
            i.name AS item_name, 
            i.quantity AS item_stock 
        FROM 
            transactions t
        JOIN 
            items i ON t.item_id = i.id
        WHERE 
            t.id = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $transactionId);
    $stmt->execute();
    $result = $stmt->get_result();
    $transaction = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $quantityReturned = $_POST['quantity_returned'];

        // Check if the quantity returned is valid
        if ($quantityReturned > 0 && $quantityReturned <= $transaction['qty_unreturned']) {
            // Update the quantities in the transactions table
            $newQtyReturned = $transaction['qty_returned'] + $quantityReturned;
            $newQtyUnreturned = $transaction['qty_unreturned'] - $quantityReturned;

            $updateTransactionSql = "
                UPDATE transactions 
                SET qty_returned = ?, qty_unreturned = ? 
                WHERE id = ?
            ";
            $updateTransactionStmt = $conn->prepare($updateTransactionSql);
            $updateTransactionStmt->bind_param("iii", $newQtyReturned, $newQtyUnreturned, $transactionId);
            $updateTransactionStmt->execute();

            // Update the quantity in stock in the items table
            $newItemStock = $transaction['item_stock'] + $quantityReturned;

            $updateItemSql = "
                UPDATE items 
                SET quantity = ? 
                WHERE id = ?
            ";
            $updateItemStmt = $conn->prepare($updateItemSql);
            $updateItemStmt->bind_param("ii", $newItemStock, $transaction['item_id']);
            $updateItemStmt->execute();

            // Redirect to the taken-returnable.php page
            header("Location: taken-returnable.php");
            exit();
        } else {
            $error = "Invalid quantity returned.";
        }
    }
} else {
    echo "Transaction ID not provided.";
    exit();
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
                            <h1 class="m-0">Return</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                       <div class="col-sm-12">
                            <form action="return.php?id=<?php echo $transactionId; ?>" method="POST">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="item_name">Item</label>
                                                    <input type="text" class="form-control" id="item_name" value="<?php echo htmlspecialchars($transaction['item_name']); ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="qty_taken">Quantity Taken</label>
                                                    <input type="text" class="form-control" id="qty_taken" value="<?php echo htmlspecialchars($transaction['qty_taken']); ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="qty_unreturned">Quantity Unreturned</label>
                                                    <input type="text" class="form-control" id="qty_unreturned" value="<?php echo htmlspecialchars($transaction['qty_unreturned']); ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="quantity_returned">Quantity Returned</label>
                                                    <input name="quantity_returned" type="number" class="form-control" id="quantity_returned" required>
                                                </div>
                                                <?php if (isset($error)): ?>
                                                    <div class="alert alert-danger mt-3">
                                                        <?php echo $error; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="card-tools text-right">
                                            <button type="submit" class="btn btn-success">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'partials/footer.php'; ?>
    </div>
    <?php include 'partials/foot.php'; ?>
</body>
</html>

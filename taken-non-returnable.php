<?php
// Include the database connection
include 'config.php';

// Fetch returnable transactions
$sql = "
    SELECT 
        t.id, 
        p.name AS person_name, 
        p.department, 
        i.name AS item_name, 
        t.reason, 
        t.qty_taken, 
        t.qty_returned, 
        t.qty_unreturned, 
        t.taken_at
    FROM 
        transactions t
    JOIN 
        people p ON t.person_id = p.id
    JOIN 
        items i ON t.item_id = i.id
    WHERE 
        i.category != 'returnable'
";
$result = $conn->query($sql);
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
                            <h1 class="m-0">Non Returnable Items Taken</h1>
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
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Item</th>
                                                <th>Person</th>
                                                
                                                <th>Reason</th>
                                                <th>Quantity Taken</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($row = $result->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($row['taken_at']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['person_name']); ?></td>
                                                   
                                                    <td><?php echo htmlspecialchars($row['reason']); ?></td>
                                                    <td><b><?php echo htmlspecialchars($row['qty_taken']); ?></b></td>
                                                    
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
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

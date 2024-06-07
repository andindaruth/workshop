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
                            <h1 class="m-0">Non-Returnable items</h1>
                        </div>
                        <div class="col-sm-6">
                            <a href="taken-non-returnable.php" class="btn float-right bg-success">Taken items</a>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body pb-1">
                                    <form action="non-returnable.php" method="GET">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="search" class="form-control form-control-md" name="search" placeholder="Enter Name" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn bg-success" value="Search">Search</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover table-head-fixed">
                                        <thead>
                                            <tr class="text-nowrap">
                                            <th>ID</th>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Quantity</th>
                                                <th>Action</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Database connection
                                            $conn = new mysqli('localhost', 'root', '', 'workshop');

                                            if ($conn->connect_error) {
                                                die('Connection failed: ' . $conn->connect_error);
                                            }

                                            $sql = "SELECT * FROM items WHERE category != 'returnable'";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row['id'] . "</td>";
                                                    echo "<td><img src='" . $row['image'] . "' alt='Image' style='width:50px; height:50px;'></td>";
                                                    echo "<td>" . $row['name'] . "</td>";
                                                    echo "<td>" . $row['description'] . "</td>";
                                                    echo "<td><b>" . $row['quantity'] . "</b></td>";
                                                    echo "<td><a href ='give-out.php?id=" . $row['id'] . "'>Give out</a></td>";
                                                    echo "<td><a href ='add-qty.php?id=" . $row['id'] . "'>Add quantity</a></td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='6'>No non-returnable items found</td></tr>";
                                            }

                                            $conn->close();
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="pb-2">
                                <nav aria-label="Contacts Page Navigation">
                                    <ul class="pagination m-0">
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                                        <li class="page-item"><a class="page-link" href="#">6</a></li>
                                        <li class="page-item"><a class="page-link" href="#">7</a></li>
                                        <li class="page-item"><a class="page-link" href="#">8</a></li>
                                    </ul>
                                </nav>
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

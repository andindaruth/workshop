<?php include 'partials/head.php'; ?>

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
                            <h1 class="m-0">Add new Person</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <a href="people.php" class="btn float-right bg-success"></i> People
                            </a>
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
                            <form action="loan_appraisal.php" enctype="multipart/form-data">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="font-weight: normal;" for="amount">Name</label>
                                                    <input name="amount" type="text" class="form-control" value="">
                                                </div>
                                            </div>
                                        </div>
                            
                                          <div class="row">

                                           <div class="col-md-6">
                                           <div class="form-group">
                                                    <label style="font-weight: normal;" for="amount">Department</label>
                                                    <input name="amount" type="text" class="form-control" value="">
                                                </div>
                                            </div>
                                          </div>

                                            <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="font-weight: normal;" for="amount">Postion</label>
                                                    <input name="amount" type="text" class="form-control" value="">
                                                </div>
                                            </div>
                                           </div>

                                           
</div>
                                        
                                        </div>
                                        
                                        
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <div class="card-tools text-right">
                                            <button name="submit" type="submit" class="btn btn-success">Save person</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
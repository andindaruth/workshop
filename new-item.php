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
                                                    <label style="font-weight: normal;" for="amount">Category</label>
                                                   <br/> <select>
                                            <option selected>Returnable </option> 
                                            <option>Non returnable</option> 
                                            
                                                
                                            </select>
                                                </div>

                                            </div>
                                           </div>
                                          <div class="row">

                                           <div class="col-md-6">
                                           <div class="form-group">
                                                    <label style="font-weight: normal;" for="amount">Description</label>
                                                    <input name="amount" type="text" class="form-control" value="">
                                                </div>
                                            </div>
                                          </div>

                                            <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="font-weight: normal;" for="amount">Quantity in stock</label>
                                                    <input name="amount" type="text" class="form-control" value="">
                                                </div>
                                            </div>
                                           </div>

                                            <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="font-weight: normal;" for="amount">Image</label><br/>
                                                    <input type="file" id="imageInput" accept="image/*">
                                                     <div class="image-preview" id="imagePreview">
                                                      <p>No image selected</p> 
                                                    </div>
                                                    <script>
        document.getElementById('imageInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imagePreview = document.getElementById('imagePreview');
                    imagePreview.innerHTML = `<img src="${e.target.result}" alt="Selected Image">`;
                }
                reader.readAsDataURL(file);
            } else {
                document.getElementById('imagePreview').innerHTML = '<p>No image selected</p>';
            }
        });
    </script>
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
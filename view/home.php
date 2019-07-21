<!--
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

-->

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>SB Admin - Tables</title>

    <!-- Custom fonts for this template-->
    <link href="../public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="../public/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../public/css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

<nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="index.html">Admin Panel</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge badge-danger">9+</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
            </div>
        </li>
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <span class="badge badge-danger">7</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
            </div>
        </li>
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <!--
                <i class="fas fa-user-circle fa-fw"></i>
              -->
                <img src="public/photos/0" style="height: 24px;  border-radius: 50%;margin-right: 100px">
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">Settings</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
            </div>
        </li>
    </ul>

</nav>

<div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="index.html">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-folder"></i>
                <span>Pages</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <h6 class="dropdown-header">Login Screens:</h6>
                <a class="dropdown-item" href="login.html">Login</a>
                <a class="dropdown-item" href="register.html">Register</a>
                <a class="dropdown-item" href="forgot-password.html">Forgot Password</a>
                <div class="dropdown-divider"></div>
                <h6 class="dropdown-header">Other Pages:</h6>
                <a class="dropdown-item" href="404.html">404 Page</a>
                <a class="dropdown-item" href="blank.html">Blank Page</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="charts.html">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Charts</span></a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="tables.html">
                <i class="fas fa-fw fa-table"></i>
                <span>Tables</span></a>
        </li>
    </ul>

    <div id="content-wrapper">

        <div class="container-fluid">

            <?php

            if (!empty($userRoles) && $userRoles[0]->auth == 0
                &&$userRoles[1]->auth == 0
                &&$userRoles[2]->auth == 0
                &&$userRoles[3]->auth == 0
            ){
                echo 'U have no permission call the admin to give u permissions';
            }
            ?>

            <?php if(!empty($userRoles) && $userRoles[1]->auth == 1) : ?>

            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Add Users</div>
                <div class="card mb-3">
                    <div class="card-body">

                        <input type="text" id="addname" name="addname" placeholder="Name" />
                        <input type="email" id="addemail" name="addemail" placeholder="Email" />
                        <input type="password" id="addpassword" name="addpassword" placeholder="Password" />
                        <input type="password" id="addconfirmpassword" name="addconfirmpassword" placeholder="Confirm password">
                        select <input type="checkbox" id="addselect" name="select" value="1">
                        create <input type="checkbox" id="addcreate" name="create" value="2">
                        update <input type="checkbox" id="addupdate" name="update" value="3">
                        delete <input type="checkbox" id="adddelete" name="delete" value="4">

                        <input type="button" id="addbutton" name="addbutton" value="Add" />
                    </div>
                </div>

                <?php endif; ?>
                <?php if(!empty($userRoles) &&$userRoles[0]->auth == 1) : ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <form  action="index.php?controller=UserController&method=filter" method="post" class="right_table">
                            <input  type="text" name="name" placeholder="Name" value="<?=$name?>">
                            <input  type="text" name="email" placeholder="Email" value="<?=$email?>">

                            <input type="submit" name="submit" value="Filter">

                            <input  type="submit" name="Recent" value="Recent">
                            <input  type="submit" name="Older" value="Older">
                            <input  type="submit" name="A-Z" value="A-Z">
                            <input  type="submit" name="Z-A" value="Z-A">
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered"  width="100%" cellspacing="0">
                            <thead>

                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Permitions</th>
                                <?php endif; ?>
                                <?php if(!empty($userRoles) &&$userRoles[2]->auth == 1) : ?>
                                    <th></th>
                                <?php endif; ?>
                                <?php if(!empty($userRoles) &&$userRoles[3]->auth == 1) : ?>
                                    <th></th>
                                <?php endif; ?>
                            </tr>

                            </thead>
                            <tbody>


                            <?php if(!empty($userRoles) &&$userRoles[0]->auth == 1) : ?>
                                <div id="demo"></div>
                            <?php endif; ?>

                            </tbody>

                        </table>

                    </div>
                </div>
            </div>


        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright © Intcore 2019</span>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?php echo BASEURL.'User/logout'; ?>">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="../public/vendor/jquery/jquery.min.js"></script>
<script src="../public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../public/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Page level plugin JavaScript-->
<script src="../public/vendor/datatables/jquery.dataTables.js"></script>
<script src="../public/vendor/datatables/dataTables.bootstrap4.js"></script>

<!-- Custom scripts for all pages-->
<script src="../public/js/sb-admin.min.js"></script>

<!-- Demo scripts for this page-->
<script src="../public/js/demo/datatables-demo.js"></script>

<script>

    function loadDoc() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("demo").innerHTML = this.responseText;
                $("a").click(function(event) {
                    var href = $(this).prop('href');
                    if(href.includes('delete')){
                        event.preventDefault();
                        var id = href.substring(href.indexOf('delete=')+7, href.length);
                        $.ajax({
                            type: 'GET',
                            url: 'index.php?controller=UserController&method=delete',
                            data: 'delete=' + id ,
                            success: function(){
                                loadDoc();
                            }
                        });
                    }else if(href.includes('edit')){
                        event.preventDefault();
                        var id = href.substring(href.indexOf('edit=')+5, href.length);
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo BASEURL.'User/edit?'?>edit='+id,
                            data: 'name=' + $('#n'+id).val()
                                + '&email=' + $('#e'+id).val()
                                + '&select=' + $('#s'+id).prop("checked")
                                + '&create=' + $('#c'+id).prop("checked")
                                + '&update=' + $('#u'+id).prop("checked")
                                + '&delete=' + $('#d'+id).prop("checked"),
                            success: function(){
                                loadDoc();
                            }
                        });
                    }
                });
            }
        };
        xhttp.open("GET", "<?php echo BASEURL.'User/show';?>", true);
        xhttp.send();
    }

    $(document).ready(function(){
        loadDoc();
        $('#addbutton').click(function(){

            $.ajax({
                type: 'POST',
                url: 'index.php?controller=UserController&method=add',
                data: 'name=' + $('#addname').val()
                    + '&inputEmail=' + $('#addemail').val()
                    + '&inputPassword=' + $('#addpassword').val()
                    + '&confirmPassword=' + $('#addconfirmpassword').val()
                    + '&select=' + $('#addselect').prop("checked")
                    + '&create=' + $('#addcreate').prop("checked")
                    + '&update=' + $('#addupdate').prop("checked")
                    + '&delete=' + $('#adddelete').prop("checked"),
                success: function(){
                    $('#addname').val('');
                    $('#addemail').val('');
                    $('#addpassword').val('');
                    $('#addconfirmpassword').val('');
                    $('#addselect').prop("checked", false);
                    $('#addcreate').prop("checked", false);
                    $('#addupdate').prop("checked", false);
                    $('#adddelete').prop("checked", false);
                    loadDoc();
                }
            });
        });
    });

</script>
</body>
</html>

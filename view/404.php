<!DOCTYPE html>
<html>
    <head>
        <title>File Not Found</title>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="public/css/style.css">
        <script type="text/javascript"  src="public/js/script.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-3">
                    <br><br><br><br><br><br><br>
                    <div class="error-template" style="margin-left: 350px">
                        <h1>
                            Oops!</h1>
                        <h2>
                            404 Not Found</h2>
                        <div class="error-details">
                            Sorry, an error has occured, Requested page not found!
                        </div>
                        <div class="error-actions">
                            <a href="<?php echo BASEURL.'User/home'; ?>" class="btn btn-primary btn-lg">
                                <span class="glyphicon glyphicon-home"></span>
                                Take Me Home 
                            </a>
                            <a href="<?php echo BASEURL.'User/contact'; ?>" class="btn btn-default btn-lg">
                                <span class="glyphicon glyphicon-envelope"></span> 
                                Contact Support 
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
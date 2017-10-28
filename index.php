<?php

if(isset($_GET['success'])){$notification='<div class="alert alert-success">Record saved...</div>';}
if(isset($_GET['deleted'])){$notification='<div class="alert alert-danger">Record deleted...</div>';}

?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Basic CRUD</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="plugins/bootstrap-table/bootstrap-table.css">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/modernizr-2.8.3-respond-1.4.2.min.js"></script>
        
        <link rel="apple-touch-icon" sizes="180x180" href="img/icons/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="img/icons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="img/icons/favicon-16x16.png">
        <link rel="manifest" href="img/icons/manifest.json">
        <link rel="mask-icon" href="img/icons/safari-pinned-tab.svg" color="#5bbad5">
        <link rel="shortcut icon" href="img/icons/favicon.ico">
        <meta name="msapplication-config" content="img/icons/browserconfig.xml">
        <meta name="theme-color" content="#525252">
        
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <nav class="navbar navbar-default navbar-inverse navbar-fixed-top">
			<div class="navbar-header">					
				<button type="button" class="navbar-toggle " data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" >
                    <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
				</button> 
                <a class="navbar-brand" href="index.php"><img src="img/logo.png" style="display:inline; width:20px;" /> Basic CRUD</a>
			</div>
			
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				
                <ul class="nav navbar-nav">
                    <li>
                        <a href="new.php">New record</a>
					</li>
			</div>
			
		</nav>
    
    <div class="jumbotron">
      <div class="container"><div style="margin-top:-40px;height:60px;"><?= $notification ?></div>
        <div class="loading_table" style="width: 100%; margin:auto;"><div style="text-align: center; "><img src="img/loading.gif" />Loading...</div></div>
        <table id="table"></table>
      </div>
    </div>

    <div class="container">
      <footer>
        <p> &copy; <a href="https://forrust.com">forrust.com</a> <?= date('Y')?></p>
      </footer>
    </div> <!-- /container -->        
        <script>window.jQuery || document.write('<script src="js/jquery-1.11.2.min.js"><\/script>')</script>
        <script src="js/bootstrap.min.js"></script>
        <script src="plugins/bootstrap-table/bootstrap-table.js"></script>
        <script>
        $(document).ready(function(){
            $('.alert').fadeOut(3000);
            var $table = $('#table')
            $.ajax({
                type: "POST",
                url: "php/ajax.php",
                dataType: 'json',
                data: {'get_records':true },
                success: function(result){
                    $('.loading_table').hide();
                    $table.bootstrapTable({
                        data: result,
                        uniqueId: 'id',
                        mobileResponsive: true,
                        toolbar: '#toolbar',  
                        search: true,
                        searchTimeOut: 1,
                        searchAlign:"left",
                        trimOnSearch:false,
                        pageSize:"10",
                        classes:"table table-hover table-striped",
                        pagination: true,
                        sortOrder: 'asc',
                        columns: [
                        {
                            field: 'name',
                            title: 'Name',
                            searchable: true,
                            sortable: true        
                        }, {
                            field: 'email',
                            title: 'Email',
                            searchable: true,
                            sortable: true
                        }, {
                            field: 'field1',
                            title: 'Field1',
                            searchable: true,
                            sortable: true
                        }, {
                            field: 'field2',
                            title: 'Field2',
                            searchable: true,
                            sortable: true
                        }]
                    });                 
                }
            });
            $(document).on('click', 'tbody>tr', function(){
                window.location='new.php?rec='+$(this).data('uniqueid'); 
            })
        });
                   
        </script>
    </body>
</html>

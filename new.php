<?php 
$rec = filter_input(INPUT_GET, 'rec', FILTER_SANITIZE_NUMBER_INT);
if(!empty($rec)){
    require_once('php/functions_db.php');
    $data = db_get("SELECT * FROM records WHERE id=?", $rec);
    $record=$data[0];
    $id=$record['id'];
    if(empty($id)){$id='new';}
}else{
    $id='new';
}

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
                        <div style="float: left; margin-top: -4px; margin-right: 4px;"><span class="label label-danger menu_count hideme general" ></span></div>
                        <div style="float: right;"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></div>
					</button> 
                    <a class="navbar-brand" href="index.php"><img src="img/logo.png" style="display:inline; width:20px;" /> Basic CRUD</a>
				</div>
				
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="index.php">Index</a>
    					</li>
				</div>
				
			</nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <div class="bootstrap-iso">
         <div class="container-fluid">
          <div class="row">
           <div class="col-md-6 col-sm-6 col-xs-12">
            <form id="record" data-id="<?= $id ?>" method="post">
            <div class="row">
              <div class="col-xs-12 col-sm-6">
                <div class="form-group ">
                  <label class="control-label requiredField" for="firstname">
                   First name
                   <span class="asteriskField">
                    *
                   </span>
                  </label>
                  <input class="form-control" id="firstname" name="firstname" type="text" value="<?= $record['firstname'] ?>" maxlength="255"/>
                 </div>
              </div>
              <div class="col-xs-12 col-sm-6">
                <div class="form-group ">
                  <label class="control-label requiredField" for="lastname">
                   Last name
                   <span class="asteriskField">
                    *
                   </span>
                  </label>
                  <input class="form-control" id="lastname" name="lastname" type="text" value="<?= $record['lastname'] ?>" maxlength="255"/>
                 </div>
              </div>
            </div>
             <div class="form-group ">
              <label class="control-label requiredField" for="email">
               Email
               <span class="asteriskField">
                *
               </span>
              </label>
              <input class="form-control" id="email" name="email" type="text" value="<?= $record['email'] ?>" maxlength="255"/>
             </div>
             <div class="form-group ">
              <label class="control-label" for="field1">
               Field 1
              </label>
              <textarea class="form-control"  cols="40" id="field1" name="field1" rows="3" maxlength="1024"><?= $record['field1'] ?></textarea>
              <span class="help-block" id="hint_field1">
               max 1024 characters
              </span>
             </div>
             <div class="form-group ">
              <label class="control-label" for="field2">
               Field 2
              </label>
              <textarea class="form-control" cols="40" id="field2" name="field2" rows="3" maxlength="1024"><?= $record['field2'] ?></textarea>
              <span class="help-block" id="hint_field2">
               max 1024 characters
              </span>
             </div>
             <div class="form-group">
              <div>
               <button id="save" class="btn btn-success" name="submit" type="submit">
                <i class="glyphicon glyphicon-ok"></i> Submit
               </button>
               <?php if($id!='new'){
                print '
                   <button id="delete" class="btn btn-danger" name="delete">
                    <i class="glyphicon glyphicon-remove"></i> Delete
                   </button>
                   ';
               }?>
              </div>
             </div>
            </form>
           </div>
          </div>
         </div>
        </div>
      </div>
    </div>

    <div class="container">
      <footer>
        <p> &copy; <a href="https://forrust.com">forrust.com</a> <?= date('Y')?></p>
      </footer>
    </div> <!-- /container -->        
        <script>window.jQuery || document.write('<script src="js/jquery-1.11.2.min.js"><\/script>')</script>
        <script src="js/bootstrap.min.js"></script>
        <script>
        function validEmail(v) {
            var r = new RegExp("[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?");
            return (v.match(r) == null) ? false : true;
        }
        $(document).ready(function(){
            $('#save').click(function(e){
                e.preventDefault();
                if($('#record').data('id')==''){ alert('Error');}
                else if($('#firstname').val()==''){ alert('First name is required'); }
                else if($('#lastname').val()==''){ alert('Last name is required'); }
                else if($('#email').val()==''){ alert('Email is required');}
                else if(!validEmail($('#email').val())){ alert('Email is not valid'); }
                else{
                    $.ajax({
                        type: "POST",
                        url: "php/ajax.php",
                        dataType: 'json',
                        data: {
                            rec_id: $('#record').data('id'),
                            rec_email: $('#email').val(), 
                            rec_firstname: $('#firstname').val(),
                            rec_lastname: $('#lastname').val(),
                            rec_field1: $('#field1').val(),
                            rec_field2: $('#field2').val(),
                            },
                        success: function(data){
                            if (data.status=='success'){
                                window.location.href = 'index.php?success';
                            }else{
                                alert(data.status);
                            }
                        }
                    })   
                }
            });
            $('#delete').click(function(e){
                e.preventDefault();
                if(confirm("Are you sure you want to delete this record?")) {
                    $.ajax({
                        type: "POST",
                        url: "php/ajax.php",
                        dataType: 'json',
                        data: { delete_id: $('#record').data('id')},
                        success: function(data){
                            if (data.status=='success'){
                                window.location.href = 'index.php?deleted';
                            }else{
                                alert(data.status);
                            }
                        }
                    });
                }
                
            });
            
        });
                   
        </script>
    </body>
</html>

<!DOCTYPE html>
<html lang="en">
<head><title>Entrar</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="Thu, 19 Nov 1900 08:52:00 GMT">
    <!--Loading bootstrap css-->
    <link type="text/css"
          href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,800italic,400,700,800">
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700,300">
    <link type="text/css" rel="stylesheet"
          href="<?php echo _TEMPLATE_SCRIPTS?>vendors/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.css">
    <link type="text/css" rel="stylesheet" href="<?php echo _TEMPLATE_SCRIPTS?>vendors/font-awesome/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo _APPLICACION_URL?>template/app/vendors/bootstrap/css/bootstrap.min.css">
    <!--Loading style vendors-->
    <link type="text/css" rel="stylesheet" href="<?php echo _TEMPLATE_SCRIPTS?>vendors/animate.css/animate.css">
    <link type="text/css" rel="stylesheet" href="<?php echo _APPLICACION_URL?>template/app/vendors/iCheck/skins/all.css">
    <!--Loading style-->
    <link type="text/css" rel="stylesheet" href="<?php echo _TEMPLATE_SCRIPTS?>css/themes/style1/pink-blue.css" class="default-style">
    <link type="text/css" rel="stylesheet" href="<?php echo _TEMPLATE_SCRIPTS?>css/themes/style1/pink-blue.css" id="theme-change"
          class="style-change color-change">
    <link type="text/css" rel="stylesheet" href="<?php echo _TEMPLATE_SCRIPTS?>css/style-responsive.css">
    <link rel="shortcut icon" href="<?php echo _TEMPLATE_SCRIPTS?>images/favicon.ico">
</head>
<body id="signin-page">
<div class="page-form">
    <form action="<?php echo _APPLICACION_URL?>login/initSession.html" id="login" class="form-validate-signin" novalidate="novalidate" method="POST">
        <div class="header-content"><h1>Ingreso</h1></div>
        <div class="body-content"><p>Por favor ingrese sus credenciales para ingresa al sistema:</p>

            <div class="form-group">
                <div class="input-icon right"><i class="fa fa-user"></i><input type="text" placeholder="Correo"
                                                                               name="mail_user" class="form-control required email">
                </div>
            </div>
            <div class="form-group">
                <div class="input-icon right"><i class="fa fa-key"></i><input type="password" placeholder="Contraseña"
                                                                              name="pass_user" class="form-control required">
                </div>
            </div>
            
            <div id="pageloader-img" class="form-group pull-right">
                <button id="sudmit_boton_ajax" type="submit" class="btn btn-success">Ingrese
                    &nbsp;<i class="fa fa-chevron-circle-right"></i></button>
                    
            </div>
            <div class="clearfix"></div>
            <!--sdiv class="forget-password"><h4>Forgotten your Password?</h4>

                <p>no worries, click <a href='#' class='btn-forgot-pwd'>here</a> to reset your password.</p></div>
            <hr>
            <p>Don't have an account? <a id="btn-register" href="extra-signup.html">Register Now</a></p-->
        
        </div>
    </form>
    <div id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default-label"
                     aria-hidden="true" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <!--button type="button" data-dismiss="modal" aria-hidden="true"
                                        class="close">&times;</button-->
                                <!--h4 id="modal-default-label" class="modal-title"><div id="modal-tit">si</div></h4></div-->
                            <div class="modal-body">
                                <div id="modal_aler" class="note note-success">
                                    <button type="button" data-dismiss="modal" aria-hidden="true"
                                        class="close">&times;</button>  
                                    <h3 id="modal_tit">qwqwqw</h3>
                                    <p id="modal_content">qwqwqw</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>
                                <!--button type="button" class="btn btn-primary">Save changes</button-->
                            </div>
                        </div>
                    </div>
                </div>
        </div>
<script src="<?php echo _TEMPLATE_SCRIPTS?>js/jquery-1.10.2.min.js"></script>
<script src="<?php echo _TEMPLATE_SCRIPTS?>js/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo _TEMPLATE_SCRIPTS?>js/jquery-ui.js"></script>
<!--loading bootstrap js-->
<script src="<?php echo _TEMPLATE_SCRIPTS?>vendors/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo _TEMPLATE_SCRIPTS?>vendors/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js"></script>
<script src="<?php echo _TEMPLATE_SCRIPTS?>js/html5shiv.js"></script>
<script src="<?php echo _TEMPLATE_SCRIPTS?>js/respond.min.js"></script>
<script src="<?php echo _TEMPLATE_SCRIPTS?>vendors/iCheck/icheck.min.js"></script>
<script src="<?php echo _TEMPLATE_SCRIPTS?>vendors/iCheck/custom.min.js"></script>
<script src="<?php echo _TEMPLATE_SCRIPTS?>vendors/jquery-validate/jquery.validate.min.js"></script>
<script src="<?php echo _TEMPLATE_SCRIPTS?>js/form-validation.js"></script>

<script>
    

function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}


    $("#login").submit(function () {
        var form = $(this);
        
        var html = 'Comprobando identidad,<br>espere un momento...  <img src="<?php echo _TEMPLATE_SCRIPTS?>/vendors/pageloader/images/loader11.GIF">';
        $('#sudmit_boton_ajax').html(html);
        $('#sudmit_boton_ajax').attr('disabled', true);
        
        html = 'Ingrese &nbsp;<i class="fa fa-chevron-circle-right">';
        
        if (!form.valid()){
            $('#sudmit_boton_ajax').html(html);
            $('#sudmit_boton_ajax').attr('disabled', false);
            return false;  
        }
       
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                var fixedResponse = response.replace(/\\'/g, "'");
                var jsonObj = JSON.parse(fixedResponse);
                
                if(jsonObj.respuesta == 'Si'){
                    var modal_aler = 'note note-success';
                    var modal_tit = 'Exitoso!';
                    var modal_content = 'Login realizado exitosamente, espere un momento.';

                    $('#modal_aler').attr("class",modal_aler);;
                    $('#modal_tit').html(modal_tit);
                    $('#modal_content').html(modal_content);
                    $('#modal-default').modal('show'); 

                    sleep(2000);
                    location.reload(true);
                }else{
                    var modal_aler = 'note note-warning';
                    var modal_tit = 'Atencion!';
                    var modal_content = 'El correo y/o contraseña se encuentran mal, por favor revise la informacion ingresada y vuelva a intentarlo.';
                    
                    $('#modal_aler').attr("class",modal_aler);;
                    $('#modal_tit').html(modal_tit);
                    $('#modal_content').html(modal_content);
                    $('#modal-default').modal('show'); 
                    
                    $('#sudmit_boton_ajax').html(html);
                    $('#sudmit_boton_ajax').attr('disabled', false);
                    
                }
                
            },
            error: function() {
                var modal_aler = 'note note-danger';
                var modal_tit = 'Error!';
                var modal_content = 'Hay un problema con su conexion de red, por favor revise su conexion de red y vuelva a intentar.';

                $('#modal_aler').attr("class",modal_aler);;
                $('#modal_tit').html(modal_tit);
                $('#modal_content').html(modal_content);
                $('#modal-default').modal('show'); 
            }
        });
        
        //$('#sudmit_boton_ajax').html(html);
        //$('#sudmit_boton_ajax').attr('disabled', false);
        
        return false;
    });
</script>
</body>
</html>
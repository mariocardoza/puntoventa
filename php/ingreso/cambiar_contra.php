<?php include '../../inc/config.php'; ?>
<?php include '../../inc/template_start.php'; ?>

<!-- Login Alternative Row -->
<div class="container">
    <div class="row">
        <div class="col-md-5 col-md-offset-1">
            <div id="login-alt-container">
                <!-- Title -->
                <h1 class="push-top-bottom">
                    <i class="gi gi-flash"></i> <strong><?php echo $template['name']; ?></strong><br>
                    <small>Bienvenido su contraseña fue actualizada automaticamente, por favor ingrese una nueva contraseña!</small>
                </h1>
                <!-- END Title -->

                <!-- Key Features -->
                <ul class="fa-ul text-muted">
                    <li><i class="fa fa-check fa-li text-success"></i>Ingrese una contraseña unica</li>
                    <li><i class="fa fa-check fa-li text-success"></i>Puede ingresar números, letras y caracteres especiales($%&/()@)</li>
                    <li><i class="fa fa-check fa-li text-success"></i>La contraseña debe contener entre 5 y 15 catacteres</li>
                    <li><i class="fa fa-check fa-li text-success"></i>Esta contraseña le servira para ingresar al sistema y a la app</li>
                     
                </ul>
                <!-- END Key Features -->

                <!-- Footer -->
                <footer class="text-muted push-top-bottom">
                    <small> <?php echo date("Y"); ?> &copy; <a href=nutriconsultores.com" target="_blank"><?php echo $template['name']; ?></a></small>
                </footer>
                <!-- END Footer -->
            </div>
        </div>
        <div class="col-md-5">
            <!-- Login Container -->
            <div id="login-container">
                <!-- Login Title -->
                <div class="login-title text-center">
                    <h1><strong>Actualizar Contraseña</strong></h1>
                </div>
                <!-- END Login Title -->

                <!-- Login Block -->
                <div class="block push-bit">
                    <!-- Login Form -->
                    <form action="" method="post" id="actualizarcontra" class="form-horizontal">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                                    <input type="hidden" name="data_id" value="cambiar_pass">
                                    <input type="password" id="contra1" name="contra1" class="form-control input-lg" placeholder="Contraseña">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                                    <input type="password" id="recontra1" name="recontra1" class="form-control input-lg" placeholder="Repita la contraseña">
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-actions">
                             
                            <div class="col-xs-12 text-right">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Actualizar</button>
                            </div>
                        </div>
                         
                    </form>
                    <!-- END Login Form -->

                     
                </div>
                <!-- END Login Block -->
            </div>
            <!-- END Login Container -->
        </div>
    </div>
</div>
<!-- END Login Alternative Row -->

 

<?php include '../../inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="../../js/pages/login.js"></script>
<script>
    $(function(){ Login.init(); 
        $(document).on("submit", "#actualizarcontra", function (e) {
            e.preventDefault();
            NProgress.start();
            var get = { usuario:'<?php echo $_GET[id];?>',contra:$("#contra1").val(),id:"1" };
            console.log(get);
            $.ajax({
                dataType: "json",
                method: "POST",
                url:'../json/json_generico.php',
                data : get,
            }).done(function(msg) {
                console.log("esto trae",msg);
                
                if(msg.exito[0]=='1'){
                         

                     iziToast.success({
                        title: 'Excelente!',
                        timeout: 5000,
                        position: 'topRight',
                        message: '</h4> Su contraseña ha sido actualizada, se cerrará sesión para que ingrese con la nueva contraseña!',
                    });


                    NProgress.done();
                    var timer=setInterval(function(){
                        $(location).attr('href','destruir.php');
                        clearTimeout(timer);
                    },5500);
                }
                else {
                    NProgress.done();

                    iziToast.warning({
                        title: 'Error',
                        timeout: 3000,
                        position: 'topRight',
                        message: 'la contraseña no se ha podido actualizar, intentelo nuevamente',
                    });

 
                }

            });
        
        });



    });
</script>

<?php include '../inc/template_end.php'; ?>
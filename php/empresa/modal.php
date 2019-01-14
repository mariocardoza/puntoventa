<div class="modal fade modal-side-fall" id="md_cambiar_imagen" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Cambiar imagen</h4>
      </div>
      <div class="modal-body">
        <form method="POST" id="form-producto" action="#" class="form-horizontal form-bordered">
            <div class="row">
            <div class="col-md-12">
                <div class="col-md-6 col-xs-6">
                 <div class="form-group eleimagen" >
                  <?php if($empresa[imagen]): ?>
                    <img src="../../img/empresa/<?php echo $empresa[imagen] ?>" style="width: 200px;height: 202px;" id="img_file">
                  <?php else: ?>
                    <img src="../../img/imagenes_subidas/image.svg" style="width: 200px;height: 202px;" id="img_file">
                  <?php endif ?>
                    
                    <input type="file" class="archivos hidden" id="file_1" name="file_1" />
                    <input type="hidden" id="codiguito">
                 </div>
              </div>
              <div class="col-md-6 col-xs-6 ele_div_imagen">
                  <div class="form-group">
                        <h5>La imagen debe de ser formato png o jpg con un peso máximo de 3 MB</h5>
                  </div><br><br>
                  <div class="form-group">
                    <button type="button" class="btn btn-sm btn-mio" id="btn_subir_img"><i class="icon md-upload" aria-hidden="true"></i> Seleccione Imagen</button>
                  </div>
                  <div class="form-group">
                    <div id="error_formato1" class="hidden"><span style="color: red;">Formato de archivo invalido. Solo se permiten los formatos JPG y PNG.</span>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Cerrar</button>
        <button type="button" id="subir_imagen" class="btn btn-mio btn-pure">Guardar</button>
      </div>  
    </div>
  </div>
</div>


<div class="modal fade depa" id="md_nueva_sucur" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Registrar sucursal</h4>
            </div>
            <div class="modal-body">
                    <form action="#" method="post" name="fm_sucursal" id="fm_sucursal" class="form-horizontal">
            
                        <div class="form-group">
                            <label class="control-label" for="nombre">Nombre</label>
                                <input type="hidden" name="data_id" value="nueva_sucursal">
                                <input type="hidden" name="codigo_oculto" value="<?php echo date('Yidisus') ?>">   
                                <input type="hidden" name="empresa" id="empresa">   
                                <input required type="text" id="" name="nombre" class="form-control limpiar" placeholder="Digite el nombre del departamento">
                        </div>
                    
                        <div class="form-group">
                            <label class="control-label" for="nombre">Dirección</label>
                                <textarea required name="direccion" id="" class="form-control limpiar" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                          <label for="" class="control-label">Teléfono</label>
                          <input type="text" name="telefono" class="form-control limpiar telefono">
                        </div>
                        <div class="form-group">
                            <center>
                                <button type="button" id="btn_guardar_sucur" class="btn btn-sm btn-mio">Guardar</button>
                                <button type="reset" data-dismiss="modal" class="btn btn-sm btn-defaul"> Cerrar</button>
                            </center>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="md_editar_perfil" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Editar perfil</h4>
          </div>
          <div class="modal-body">
            <form method="post" accept-charset="utf-8" name="fm_editar_perfil" id="fm_editar_perfil">
            <input type="hidden" name="data_id" value="editar_perfil">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Nombre(*)</label>
                      <input type="text" class="form-control" id="nombre" name="nombre" required="" placeholder="Ingrese el nombre" >
                      <input type="hidden" class="form-control" id="id_perfil" name="id" placeholder="Ingrese el nombre" >
                    </div>
                    <div class="form-group">
                      <label for="n_precio">Email(*)</label>
                      <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese el email" required="">
                    </div>
                    <div class="form-group">
                      <label for="np_nombre">Teléfono(*)</label>
                      <input type="text" required class="form-control telefono" id="telefono" name="telefono" aria-describedby="nombrelHelp" placeholder="Ingrese el teléfono">
                      <!--small id="nombrelHelp" class="form-text text-muted">Este campo es requerido no olvide completarlo</small-->
                    </div>
                    <div class="form-group"> 
                        <label class="control-label" for="rol">Dirección(*):</label>
                        <textarea name="direccion" required class="form-control" id="direccion" cols="30" rows="4"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group"> 
                        <label class="control-label" for="rol">DUI(*):</label>
                        <input type="text" required name="dui" id="dui" class="form-control dui">
                    </div>
                    <div class="form-group"> 
                        <label class="control-label" for="rol">NIT(*):</label>
                        <input type="text" required name="nit" id="nit" class="form-control nit">
                    </div>
                    <div class="form-group"> 
                        <label class="control-label" for="rol">Fecha de nacimiento(*):</label>
                        <input type="text" required name="fecha_nacimiento" id="fecha_nacimiento" autocomplete="off" class="form-control nacimiento">
                    </div>
                    <div class="form-group"> 
                        <label class="control-label" for="rol">Género(*):</label>
                        <select id="genero" required name="genero" class="form-control select_piker2" data-plugin="selectpicker" data-live-search="true" data-placeholder="Seleccione el Municipio" readonly="" style="width: 250px;">
                            <option value="" disabled="" selected="">seleccione..</option>
                            <option id="fem" value="Femenino">Femenino</option>
                            <option id="masc" value="Másculino">Másculino</option>
                            <!--option value="2">Cliente</option--> 
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <center>
                    <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" id="btn_guardar">Guardar</button>
                </center>
            </div>
          </form>
          </div>
          <div class="modal-footer"></div>
        </div>
      </div>
</div>
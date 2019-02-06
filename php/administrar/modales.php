<div class="modal fade modal-side-fall" id="md_nuevo" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Agregar empleado</h4>
          </div>
          <div class="modal-body">
          <form method="post" accept-charset="utf-8" name="fm_nuevo_empleado" id="fm_nuevo_empleado">
            <input type="hidden" name="data_id" value="nuevo_empleado">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Nombre(*)</label>
                      <input type="text" class="form-control" id="n_nombre" name="nombre" required="" placeholder="Ingrese el nombre" >
                    </div>
                    <div class="form-group">
                      <label for="n_precio">Email(*)</label>
                      <input type="email" class="form-control" id="n_email" name="email" placeholder="Ingrese el email" required="">
                    </div>
                    <div class="form-group">
                      <label for="np_nombre">Teléfono(*)</label>
                      <input type="text" required class="form-control telefono" id="n_telefono" name="telefono" aria-describedby="nombrelHelp" placeholder="Ingrese el teléfono">
                      <!--small id="nombrelHelp" class="form-text text-muted">Este campo es requerido no olvide completarlo</small-->
                    </div>
                    <div class="form-group"> 
                        <label class="control-label" for="rol">Dirección(*):</label>
                        <textarea name="direccion" required class="form-control" id="n_direccion" cols="30" rows="4"></textarea>
                    </div>
                    <div class="form-group"> 
                        <label class="control-label" for="rol">DUI(*):</label>
                        <input type="text" required name="dui" id="n_dui" class="form-control dui">
                    </div>
                    <div class="form-group"> 
                        <label class="control-label" for="rol">NIT(*):</label>
                        <input type="text" required name="nit" id="n_nit" class="form-control nit">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="" class="control-label">¿Usuario del sistema?</label>
                      <div class="icheck-turquoise icheck-inline">
                          <input type="radio" value="no" name="es_usuario" checked id="no" />
                          <label for="no">No</label>
                      </div>
                      <div class="icheck-turquoise icheck-inline">
                          <input type="radio" value="si" name="es_usuario" id="si" />
                          <label for="si">Si</label>
                      </div>
                    </div>
                    <div class="form-group" id="leveles" style="display: none;">
                      <label for="" class="control-label">¿Nivel de usuario?</label>
                      <div class="icheck-turquoise icheck-inline">
                          <input type="radio" value="0" name="nivel" checked id="admin" />
                          <label for="admin">Administrador</label>
                      </div>
                      <div class="icheck-turquoise icheck-inline">
                          <input type="radio" value="1" name="nivel" id="mesero" />
                          <label for="mesero">Cajero</label>
                      </div>
                      <div class="icheck-turquoise icheck-inline">
                          <input type="radio" value="2" name="nivel" id="cajero" />
                          <label for="cajero">Mesero</label>
                      </div>
                    </div>
                    <div class="form-group"> 
                        <label class="control-label" for="rol">Fecha de nacimiento(*):</label>
                        <input type="text" required name="fecha_nacimiento" id="n_fecha_nacimiento" class="form-control nacimiento">
                    </div>
                    <div class="form-group"> 
                        <label class="control-label" for="rol">Género(*):</label>
                        <select id="genero" required name="genero" class="form-control select_piker2" data-plugin="selectpicker" data-live-search="true" data-placeholder="Seleccione el Municipio" readonly="" style="width: 250px;">
                            <option value="" disabled="" selected="">seleccione..</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Másculino">Másculino</option>
                            <!--option value="2">Cliente</option--> 
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                           <!--label for="firma1">Imagen(*):</label-->
                           <div class="form-group eleimagen" >
                              <img src="../../img/imagenes_subidas/image.svg" style="width: 200px;height: 202px;" id="img_file">
                              <input type="file" class="archivos hidden" id="file_1" name="file_1" />
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
            </div>
          </form>
          </div>
          <div class="modal-footer"><!-- margin-0 -->
            <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-mio" id="btn_guardar">Guardar</button>
            <!--button type="button" data-formulario="fm_nuevo" class="btn btn-primary valida1">Validar</button-->
          </div>
        </div>
      </div>
    </div>

    <div class="modal" id="md_cambiar_pass" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Cambiar contraseña a <b><span id="nombre_pass"></span></b></h4>
          </div>
          <div class="modal-body">
          <form method="post" accept-charset="utf-8" id="fm_cambiar_pass">
            <input type="hidden" name="data_id" value="cambiar_pass">
            <div class="row">
                
                    <div class="form-group">
                      <label for="pass">Contraseña(*)</label>
                      <input type="hidden" name="email_pass" id="email_pass">
                      <input type="password" class="form-control" id="pass" name="pass" placeholder="Ingrese la contraseña">
                    </div>
          
                    <div class="form-group"> 
                        <label class="control-label" for="repass">Repetir contraseña(*):</label>
                        <input type="password" name="repass" id="repass" placeholder="Repetir contraseña" class="form-control">
                    </div> 
              </div>
            <div class="col-xs-12">
                <center>
                    <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Cancelar</button>
                    <button type="sutmit" class="btn btn-mio" id="btn_cambiar_pass">Guardar</button>
                </center>
            </div> 
          </form>
          </div>
          <div class="modal-footer"></div>
        </div>
      </div>
</div>
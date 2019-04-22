<div class="modal fade modal-side-fall" id="md_guardar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Registras producto del menú</h4>
          </div>
          <div class="modal-body">
            <form action="#" method="post" name="form_receta" id="form_receta" class="">
              <div class="row" id="receta">
                <div class="col-xs-12 col-lg-12">
                  <div class="form-group">
                    <div class="icheck-turquoise icheck-inline">
                      <input type="radio" value="1" name="tipo_producto"  id="predefinido" />
                      <label for="predefinido">Producto predefinido</label>
                    </div>
                    <div class="icheck-turquoise icheck-inline">
                      <input type="radio" value="2" name="tipo_producto" id="compuesto">
                      <label for="compuesto">Producto editable</label>
                    </div>
                    <label for="tipo_producto" class="error" style="display:none;"></label>
                  </div>
                </div>
                <div class="col-xs-8 col-lg-8">
                  <div class="row">
                    <div class="col-xs-6 col-lg-6">
                      <div class="form-group">
                        <input type="hidden" id="data_id" value="nueva_receta">
                        <label class="control-label" for="nombre">Nombre</label>
                        <input type="text" autocomplete="off" id="nombre" name="nombre" class="form-control" placeholder="Digite el nombre del nombre">
                      </div>
                    </div>
                    <div class="col-xs-6 col-lg-6">
                      <div class="form-group">
                        <label class="control-label" for="">Descripción</label>
                        <textarea name="descripcion"  id="descripcion" rows="2" class="form-control"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-6 col-lg-6">
                      <div class="form-group">
                        <label class="control-label" for="tipo">Categoría</label>
                        <select name="tipo" id="tipo" class="select-chosen">
                          <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo $categoria[codigo_oculto] ?>"><?php echo $categoria[nombre] ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-xs-6 col-lg-6">
                      <div class="form-group">
                          <label class="control-label" for="precio">Precio</label>
                          <input type="text" id="precio" name="precio" class="form-control" placeholder="Precio de venta">
                      </div>
                    </div>  
                  </div>                 
                </div>
                <div class="col-xs-4 col-lg-4" style="padding-left: 30px; padding-right: 16px;">
                  <div class="row">
                    <div class="col-xs-6 col-lg-6">
                       <div class="form-group " >
                          <img src="../../img/imagenes_subidas/image.svg" style="width: 100px;height: 102px;" id="img_file">
                          <input type="file" class="archivos hidden" id="file_1" name="file_1" />
                       </div>
                    </div>
                    <div class="col-xs-6 col-lg-6 ele_div_imagen">
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
                <div class="col-xs-12 col-lg-12">
                  <div class="form-group">
                    <center>
                      <button type="button" class="btn btn-mio" id="btn_guardar">Guardar</button>
                    </center>
                  </div>
                </div>
              </div>      
            </form>
          </div>
        </div>
      </div>
</div>
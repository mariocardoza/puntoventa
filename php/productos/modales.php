<!-- MODAL PARA ASIGNAR MAS INVENTARIO A UN PRODUCTO -->
<div class="modal fade modal-side-fall" id="md_agregar_mercaderia" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Agregar mercadería</h4>
          </div>
          <div class="modal-body">
            <form method="POST" action="#" class="form-horizontal form-bordered">
                <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="" class="col-md-4 col-md-offset-2">Producto</label>
                        <div class="col-md-6">
                            <b><span id="md_titulo"></span></b>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-4 col-md-offset-2">Cantidad a agregar</label>
                        <div class="col-md-6">
                            <input type="hidden" id="id_producto">
                            <input type="number" id="canti" name="canti" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-4 col-md-offset-2">Precio</label>
                        <div class="col-md-6">
                            <input type="number" id="precio" name="precio" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-3">
                            <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Cerrar</button>
                            <button type="button" id="agregar_existencia" class="btn btn-mio btn-pure">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
          </div>
          <!--div class="modal-footer">
            <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-default btn-pure">Guardar</button>
          </div-->
          
        </div>
      </div>
</div>

<!-- modal para cambiar la imagen -->
<!-- MODAL PARA ASIGNAR MAS INVENTARIO A UN PRODUCTO -->
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
                    <img src="../../img/imagenes_subidas/image.svg" style="width: 200px;height: 202px;" id="img_file">
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

<!-- Guardar producto modal -->
<div class="modal fade modal-side-fall" id="md_guardar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Registrar producto</h4>
      </div>
      <div class="modal-body">
        <form action="#" method="post" name="form-producto" id="form-producto" class="form-horizontal">
            <!-- Product Edit Content -->
            <div class="row">
                <div class="col-sm-6 col-lg-6" style="padding-left: 30px; padding-right: 16px;">
                    <div class="form-group">
                        <label class="control-label" for="nombre">Nombre</label>
                        <input type="hidden" name="data_id" value="nuevo_producto">
                            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Digite el nombre del nombre">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="descripcion">Descripción</label>
                        <textarea  id="descripcion" placeholder="Descripción" name="descripcion" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="row">
                      <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                          <label class="control-label" for="departamento">Departamento</label>
                          <select id="departamento" name="departamento" class="select-chosen" data-placeholder="Seleccione un departamento" style="width: 250px;">
                              <option></option>
                              <?php foreach ($departamentos[1] as $departamento): ?>
                              <option value="<?php echo $departamento[id] ?>"><?php echo $departamento[nombre] ?></option>
                              <?php endforeach ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                          <label class="control-label" for="categoria">Categoría</label>
                          <select id="categoria" name="categoria" class="select-chosen" data-placeholder="Seleccione un categoría" style="width: 250px;">
                              <option></option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                          <label class="control-label" for="subcategoria">Subcategoría</label>
                          <select name="subcategoria" id="subcategoria" class="select-chosen" data-placeholder="Seleccione un departamento" style="width: 250px;">
                              <option></option>
                          </select>
                        </div> 
                      </div>
                      <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                          <label for="" class="control-label">Unidad de medida</label>
                          <select name="medida" id="medida" class="select-chosen" data-placeholder="Seleccione una unidad de medida">
                              <option></option>
                              <?php foreach ($unidades as $unidad): ?>
                                  <option data-equivalencia="<?php echo $unidad[equivalencia] ?>" value="<?php echo $unidad[id] ?>"><?php echo $unidad[nombre]?>
                                  </option>
                              <?php endforeach ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                          <label class="control-label" for="cantidad">Cantidad</label>
                          <input type="number" id="cantidad_a" name="cantidad_a" class="form-control" placeholder="Cantidad a adquirir">
                        </div>
                      </div>
                      <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                          <label class="control-label" for="cantidad">Cantidad por unidad de medida</label>
                          <input type="number" id="cantidad" name="cantidad" class="form-control" placeholder="Cantidad a adquirir">
                        </div>
                      </div>
                    </div>
                    
                    
                    
                    
                    
                    <div class="form-group">
                        <label class="control-label" for="precio">Precio</label>
                        <input type="number" id="precio" name="precio" class="form-control" placeholder="Precio por unidad de medida">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="precio_u">Precio unitario</label>
                        <input type="number" id="precio_u" name="precio_u" class="form-control" placeholder="Precio unitario de venta">
                    </div>
                </div>
                <div class="col-lg-6" style="padding-left: 30px; padding-right: 16px;">
                    <div class="form-group">
                        <label class="control-label" for="">¿Producto perecedero?</label>
                            No
                        <label class="switch switch-success">
                        <input name="perecedero" id="perecedero" value="si" type="checkbox"><span></span></label>
                            Si
                    </div>
                
                    <div class="form-group" style="display: none;" id="venci">
                        <label for="" class="control-label">Fecha de vencimiento</label>
                        <input type="text" required disabled name="fecha_vencimiento" id="vencimiento" class="form-control vecimi">
                    </div>
                    <div class="form-group" style="display: none;" id="lotito">
                        <label for="" class="control-label">Lote N°</label>
                        <input type="text" id="lote" disabled name="lote" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="">Proveedor</label>
                        <select name="proveedor" id="proveedor" class="select-chosen" data-placeholder="Seleccione un proveedor" style="width: 100%;">
                            <option></option>
                            <?php foreach ($proveedores[2] as $proveedor): ?>
                                <option value="<?php echo $proveedor[id] ?>"><?php echo $proveedor[nombre] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Porcentaje de ganancia</label>
                        <input type="number" placeholder="Porcentaje de ganancia" id="ganancia" name="ganancia" class="form-control">
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
    </div>
  </div>
</div>

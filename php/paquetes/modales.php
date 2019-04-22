<div class="modal fade modal-side-fall" id="md_guardar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"><b>Registrar paquete</b></h4>
            </div>
            <div class="modal-body">
                <form action="#" method="post" name="fm_paquete" id="fm_paquete" class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label" for="nombre">Nombre</label>
                        <input type="hidden" name="data_id" value="nuevo_paquete">
                        <input autocomplete="off" type="text" id="nombre" name="nombre" class="form-control" placeholder="Digite el nombre del paquete">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="nombre">Descripción</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="2" placeholder="Digite una descripción"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Precio</label>
                        <input type="number" name="precio" id="precio" class="form-control">
                    </div>
                    <div class="form-group">
                        <center>
                            <button type="submit" id="" class="btn btn-mio">Guardar</button>
                        <button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>  
                        </center>
                    </div>
                </form>
		    </div>
        </div>
    </div>
</div>

<div class="modal fade modal-side-fall" id="md_agregar_productos" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"><b>Agregar productos al paquete</b></h4>
            </div>
            <div class="modal-body">
                <form action="#" method="post" name="" class="">
                    <div class="form-group">
                        <label class="control-label" id="n_ver_paquete" for="nombre">Nombre</label>
                        <input type="hidden" id="elpaquete">
                    </div>
                    <div class="row">
                        <div class="col-xs-10">
                            <div class="form-group">
                                <label for="" class="control-label">Producto</label>
                                <select name="" id="elproducto" class="select-chosen">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <button class="btn btn-info" style="margin-top: 19px;
"                                    type="button" id="agregar_p">Agregar</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <table class="table" id="losproductos">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="cuerpo"></tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <center>
                            <!--button type="button" id="agregar_losproductos" class="btn btn-mio">Guardar</button-->
                            <button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>  
                        </center>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
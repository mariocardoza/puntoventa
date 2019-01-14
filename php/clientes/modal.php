<div class="modal fade modal-side-fall" id="md_guardar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Registrar cliente</h4>
            </div>
            <div class="modal-body">   
            <form action="#" method="post" name="fm_cliente" id="fm_cliente" class="form-horizontal">
            <div class="row">
        <div class="col-lg-12">
            <div class="">
                <div class="form-group">
                <div class="col-md-3">
                    <label class="control-label" for="">Tipo de cliente</label>
                </div>
                <div class="col-md-9">
                    Persona natural
                <label class="switch switch-success">
                <input name="tipocliente" id="tipocliente" value="juridica" type="checkbox"><span></span></label>
                Persona jurídica
                </div>
            </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="control-label" for="nombre">Nombre</label>
                        
                            <input type="hidden" id="data_id" name="data_id" value="nuevo_cliente">
                            <input required type="text" id="nombre" name="nombre" class="form-control" placeholder="Digite el nombre del cliente">
                        
                        </div>
                        
                        <div class="form-group" id="fdui">
                            <label class="control-label" for="departamento">DUI</label>
                            
                                <input type="text" name="dui"id="dui" class="form-control dui">
                            
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="categoria">NIT</label>
                            <input type="text" name="nit" id="nit" class="form-control nit">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="direccion">Dirección</label>
                                <textarea required id="direccion" name="direccion" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="control-label" for="telefono">Número de teléfono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control telefono">
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" >
                        </div>

                        <div class="form-group" id="nacimiento">
                            <label for="" class="control-label">Fecha de nacimiento</label>
                                <input type="text" class="form-control nacimiento" name="fecha_nacimiento" id="fecha_nacimiento">
                        </div>
                    </div>
            </div>
        </div>
        
        <div class="col-lg-12" id="contri" style="display: none;">
            <div class="row">
                <div class="col-lg-6">
                        <div class="form-group">
                            <label for="" class="control-label">Número de registro</label>
                            
                                <input type="text" name="nrc" id="nrc" class="form-control">
                           
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Giro</label>
                           
                                <input type="text" name="giro" id="giro" class="form-control">
                           
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Razón social</label>
                            
                            <input type="text" id="razon_social" name="razon_social" class="form-control">
                            
                        </div>
                        
                        <div class="form-group">
                        <label for="" class="control-label">Dirección del representante legal</label>
                        
                            <textarea name="direccion_r" id="direccion_r" rows="2" class="form-control"></textarea>
                        
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="" class="control-label">Nombre del representante legal</label>
                        
                        <input type="text" id="nombre_r" name="nombre_r" class="form-control">
                        
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Teléfono del representante legal</label>
                        
                            <input type="text" id="telefono_r" name="telefono_r" class="form-control telefono">
                        
                    </div>
                    <div class="form-group">
                            <label for="" class="control-label">Tipo contribuyente</label>
                            
                                <select name="tipocontribuyente" id="tipocontribuyente" class="select-chosen">
                                    <option value="">Seleccione...</option>
                                    <option value="1">Pequeño</option>
                                    <option value="2">Mediano</option>
                                    <option value="3">Grande</option>
                                </select>
                            
                        </div>
                    
                    <div class="form-group">
                        <label for="" class="control-label">Retiene 1%</label>
                        
                            <input type="radio" checked name="retiene" value="0">No
                            <input type="radio" name="retiene" value="1">Si
                        
                    </div>

                </div>
            </div>
            
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                    <center>
                        <button type="button" id="btn_guardar" class="btn btn-mio">Guardar</button>
                    <button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>  
                    </center>
                
            </div>
            
        </div>
        </div>
    </form>           
    		</div>
        </div>
    </div>
</div>
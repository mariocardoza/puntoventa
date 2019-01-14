<div class="modal fade modal-side-fall" id="md_guardar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Registrar proveedor</h4>
            </div>
            <div class="modal-body">
			     <form action="#" method="post" name="fm_proveedor" id="fm_proveedor" class="form-horizontal">
                    <fieldset>
                        <legend>Datos del proveedor</legend>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label" for="nombre">Nombre</label>
                                    <input type="hidden" name="data_id" value="nuevo_proveedor">
                                    <input type="hidden" name="codigo_oculto" value="<?php echo date("Yidisus") ?>">
                                    <input required type="text" id="nombre" name="nombre" class="form-control" placeholder="Digite el nombre del proveedor">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="categoria">NIT</label>
                                    
                                    <input type="text" required name="nit" id="nit" class="form-control nit">  
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="telefono">Número de teléfono</label>
                                    <input type="text" required name="telefono" id="telefono" class="form-control telefono"> 
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="direccion">Dirección</label>
                                    
                                    <textarea required id="direccion" name="direccion" class="form-control" rows="2"></textarea>  
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label" for="email">Email</label>
                                    <input type="email" required id="email" name="email" class="form-control" >  
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label">Número de registro</label>
                                    <input type="text" required name="nrc" id="nrc" class="form-control">  
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label">Giro</label>
                                    <input type="text" name="giro" id="giro" class="form-control">  
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Datos del representante legal</legend>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="control-label">Nombre</label>
                                    
                                    <input type="text" id="nombre_r" name="nombre_r" class="form-control">
                                   
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label">Teléfono</label>
                                        <input type="text" id="telefono_r" name="telefono_r" class="form-control telefono">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="control-label">DUI</label>
                                    <input name="dui_r" id="dui_r" rows="2" class="form-control dui">  
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label">Dirección</label>
                                    <textarea name="direccion_r" id="direccion_r"  rows="2" class="form-control"></textarea> 
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <center>
                                    <button type="button" id="btn_guardar" class="btn btn-mio"> Guardar</button>
                                <button type="button" data-dismiss="modal" class="btn btn-default"> Cerrar</button>  
                                </center>
                            </div>
                        </div>
                    </div>
                </form>        
		    </div>
        </div>
    </div>
</div>
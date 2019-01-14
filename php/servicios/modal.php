<div class="modal fade modal-side-fall" id="md_guardar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title"><b>Editar servicio</b></h4>
          </div>
          <div class="modal-body">
            <form action="#" method="post" name="fm_servicios" id="fm_servicios" class="form-horizontal form-bordered">
        <div class="row">
            <div class="col-lg-12">
                <div class="">
                    
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label" for="nombre">Nombre del servicio</label>
                                
                                    <input type="hidden" name="data_id" id="data_id" value="nuevo_servicio">
                                    <input type="text" autocomplete="off" id="nombre" name="nombre" class="form-control" placeholder="Digite el nombre del servicio">
                               
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label">Descripción</label>
                                
                                    <textarea name="descripcion" id="descripcion"  rows="2" class="form-control">'.$row[descripcion].'</textarea>
                                
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="direccion">Precio</label>
                                
                                    <input type="number" class="form-control" name="precio" value="'.$row[precio].'" id="precio">
                                
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label" for="categoria">Tiempo estimado de duración</label>
                                
                                    <input type="text" name="duracion" id="duracion" value="'.$row[duracion].'" class="form-control">
                                
                            </div>
                             <div class="form-group">
                                <label class="control-label" for="email">Empleado</label>
                                
                                    <select class="select-chosen" name="empleado" id="empleado">
                                    <option value="0">Ninguno</option>
                                    <?php foreach($empleados[1] as $empleado): ?>
                                    
										<option value="<?php echo $empleado[id] ?>"><?php echo $empleado[nombre] ?></option>';
                                    <?php endforeach; ?>
                                    </select>
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                        <div class="form-group">
                            
                                <center>
                                    <button type="button" id="btn_guardar_n" class="btn btn-mio"> Guardar</button>
                                    <button type="button" data-dismiss="modal" class="btn btn-default"> Cerrar</button>
                                </center>
                            
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
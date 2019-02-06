<div class="modal fade depa" id="md_guardar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Registrar reserva</h4>
            </div>
            <div class="modal-body">
                    <form action="#" method="post" name="fm_turno" id="fm_turno" class="form-horizontal">
            
                        <div class="form-group">
                            <label class="control-label" for="nombre">Servicio</label>
                                <input type="hidden" name="data_id" value="nueva_reserva">
                                <input type="hidden" name="codigo_oculto" value="<?php echo date('Yidisus') ?>">   
                                <select name="servicio" id="servicio" class="select-chosen">
                                    <option value="">Seleccione..</option>
                                    <?php foreach ($servicios as $servicio): ?>
                                        <option value="<?php echo $servicio[codigo_oculto] ?>"><?php echo $servicio[nombre] ?></option>
                                    <?php endforeach ?>
                                </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Cliente</label>
                            <select name="cliente" id="cliente" class="select-chosen">
                                <option value="">Seleccione..</option>
                                <?php foreach ($clientes[1] as $cliente): ?>
                                    <option value="<?php echo $cliente[codigo_oculto] ?>"><?php echo $cliente[nombre] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Empleado</label>
                            <select name="empleado" id="empleado" class="select-chosen">
                                <option value="">Seleccione...</option>
                                <option value="">Cualquier empleado</option>
                            </select>
                        </div>
                    
                        <div class="form-group">
                            <label class="control-label" for="nombre">Día</label>
                                <input type="text" name="dia" required class="form-control vecimi" id="dia">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="nombre">Hora</label>
                                <input type="time" name="hora" required class="form-control " id="hora">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="nombre">Teléfono</label>
                                <input type="text" name="fin" required class="telefono form-control" id="fin">
                        </div>
                        <div class="form-group">
                            <center>
                                <button type="button" id="btn_guardar" class="btn btn-mio">Guardar</button>
                                <button type="reset" data-dismiss="modal" class="btn btn-defaul"> Cerrar</button>
                            </center>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
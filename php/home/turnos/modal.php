<div class="modal fade" id="md_guardar_turno" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Inicar turno</h4>
            </div>
            <div class="modal-body">
                    <form action="#" method="post" name="fm_turno" id="fm_turno" class="form-horizontal">
            
                        <div class="form-group">
                            <label class="control-label" for="nombre">Nombre de la caja</label>
                                <input type="hidden" name="data_id" value="nuevo_turno">
                                <input type="hidden" name="codigo_oculto" value="<?php echo date('Yidisus') ?>">   
                                <select name="caja" id="caja" class="select-chosen">
                                    <?php foreach ($cajas as $caja): ?>
                                        <option value="<?php echo $caja[codigo_oculto] ?>"><?php echo $caja[nombre] ?></option>
                                    <?php endforeach ?>
                                </select>
                        </div>
                    
                        <div class="form-group">
                            <center>
                                <button type="button" id="btn_marcar" class="btn btn-mio">Marcar</button>
                                <button type="reset" data-dismiss="modal" class="btn btn-defaul"> Cerrar</button>
                            </center>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="md_cerrar_turno" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Cerrar turno</h4>
            </div>
            <div class="modal-body">
                    <form action="#" method="post" name="fm_turno2" id="fm_turno2" class="form-horizontal">
            
                    
                    
                        <div class="form-group">
                            <input type="hidden" name="data_id" value="nuevo_turno">

                            <center>
                                <button type="button" id="btn_terminar" class="btn btn-mio">Terminar</button>
                                <button type="reset" data-dismiss="modal" class="btn btn-defaul"> Cerrar</button>
                            </center>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
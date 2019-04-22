<div class="modal fade depa" id="md_guardar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Registrar política</h4>
            </div>
            <div class="modal-body">
                    <form action="#" method="post" name="fm_politicas" id="fm_politicas" class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label" for="nombre">Tipo: stock de inventario</label>
                                <input type="hidden" name="data_id" value="nueva_politica">  
                                <input id="tipo2" type="hidden" name="tipo" checked value="stock">
                                <input type="hidden" name="codigo_oculto" value="<?php echo date("Yidisus") ?>">
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Descripción</label>
                            <textarea required name="descripcion" id="descripcion" rows="3" class="form-control"></textarea>        
                        </div>
                        <div class="form-group" id="minimo_fm_group">
                            <label class="control-label" for="nombre">¿Cúanto es el mínimo?</label>                           
                            <input name="minimo" id="minimo" class="form-control" placeholder="digite cuanto el mínimo de inventario permitido">
                        </div>
                        <div class="form-group">
                            <center>
                                <button type="button" id="btn_guardar" class="btn btn-mio">Guardar</button>
                                <button type="button" data-dismiss="modal" class="btn btn-sm btn-defaul"> Cerrar</button>
                            </center>
                        </div>
                    </form>
            </div>
        </div>
    </div>
<div class="modal fade depa" id="md_guardar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Caja registradora</h4>
            </div>
            <div class="modal-body">
                <form action="#" method="post" name="fm_caja" id="fm_caja" class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label" for="nombre">Nombre</label>
                        <input type="hidden" name="data_id" value="nueva_caja">
                        <input type="hidden" name="codigo_oculto" value="<?php echo date('Yidisus') ?>">   
                        <input required type="text" id="nombre" name="nombre" class="form-control" placeholder="Digite el nombre de la caja">
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
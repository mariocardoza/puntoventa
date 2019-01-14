<div class="modal fade modal-side-fall" id="md_guardar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title"><b>Registrar categoría</b></h4>
          </div>
          <div class="modal-body">
                    <form action="#" method="post" name="fm_categoria" id="fm_categoria" class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label" for="nombre">Nombre</label>
                            <input type="hidden" name="data_id" value="nueva_categoria">
                            <input type="hidden" name="codigo_oculto" value="<?php echo date('Yidisus') ?>">
                            <input required type="text" id="nombre" name="nombre" class="form-control" placeholder="Digite el nombre del departamento">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="nombre">Descripción</label>
                            <textarea required name="descripcion" id="descripcion" class="form-control" rows="2" placeholder="Digite una descripción"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Departamento</label>
                                 <select required name="departamento" id="departamento" class="select-chosen" data-placeholder="Seleccione un departamento" style="width: 100%;">
                                    <?php foreach ($departamentos[1] as $departamento): ?>
                                        <option value="<?php echo $departamento[id] ?>"><?php echo $departamento[nombre] ?></option>
                                    <?php endforeach ?>
                                </select>
                        </div>
                        <div class="form-group">
                            <center>
                                <button type="button" id="btn_guardar" class="btn btn-sm btn-mio">Guardar</button>
                            <button type="button" data-dismiss="modal" class="btn btn-sm btn-default">Cerrar</button>  
                            </center>
                        </div>
                    </form>
		        </div>
            </div>
        </div>
    </div>
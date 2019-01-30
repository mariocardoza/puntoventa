<div class="modal fade modal-side-fall" id="md_agregar_productos" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Elementos de la receta</h4>
          </div>
          <div class="modal-body">
            <form method="POST" action="#" id="form_mas" class="form-horizontal">
                <div class="row">
                <div class="col-md-12"> 
                    <div class="form-group">
                        <label for="" class="control-label">Categoría</label>
                        <select name="" id="cate" class="select-chosen">
                          <?php foreach ($categorias[2] as $categoria): ?>
                            <option value="<?php echo $categoria[id] ?>"><?php echo $categoria[nombre] ?></option>
                          <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                      <div class="icheck-turquoise icheck-inline">
                        <input type="radio" value="1" name="tipo" checked id="obligatorio" />
                        <label for="obligatorio">Obligatorio</label>
                      </div>
                      <div class="icheck-turquoise icheck-inline">
                          <input type="radio" value="2" name="tipo" id="Opcional" />
                          <label for="Opcional">Opcional</label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="">Cantidad</label>
                      <input type="number" id="canti" class="form-control" placeholder="cantidad">
                    </div>
                    <div class="form-group">
                      <center>
                        <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Cerrar</button>
                        <button type="button" id="agregar" class="btn btn-mio btn-pure">Guardar</button>
                      </center>
                    </div>
                </div>
            </div>
            </form>
          </div>
        </div>
      </div>
</div>
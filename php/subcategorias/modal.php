<div class="modal fade modal-side-fall" id="md_guardar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title"><b>Registrar subcategoría</b></h4>
          </div>
          <div class="modal-body">
                    <form action="#" method="post" name="fm_subcategoria" id="fm_subcategoria" class="form-horizontal">
                    <div class="form-group">
                            <label class="control-label" for="nombre">Nombre</label>
                            
                                <input type="hidden" name="data_id" value="nueva_subcategoria">
                                
                                <input type="hidden" name="codigo_oculto" value="<?php echo date('Yidisus') ?>">
                                <input required type="text" id="nombre" name="nombre" class="form-control" placeholder="Digite el nombre de la subcategoría">
                            
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="nombre">Descripción</label>
                            
                                <textarea required name="descripcion" id="descripcion" class="form-control" rows="2" placeholder="Disite la descripción"></textarea>
                           
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Categoría</label>
                                 <select required name="categoria" id="categoria" class="select-chosen" data-placeholder="Seleccione una categoría" style="width: 100%;">
                                    <?php foreach ($categorias[2] as $categoria): ?>
                                        <option value="<?php echo $categoria[id] ?>"><?php echo $categoria[nombre] ?></option>
                                    <?php endforeach ?>
                                </select> 
                        </div>
                        <div class="form-group">
                            <center>
                                <button type="button" id="btn_guardar" class="btn btn btn-mio">Guardar</button>
                            <button type="button" data-dismiss="modal" class="btn btn btn-default">Cerrar</button>  
                            </center>
                        </div>
                    </form>
		        </div>
            </div>
        </div>
    </div>
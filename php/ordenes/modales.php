<div class="modal fade modal-side-fall" id="md_seleccionar_mesa" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Seleccionar mesa</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <?php foreach ($mesas as $mesa): ?>
                <div class="col-sm-6 col-lg-3">
                  <div class="widget">
                      <div class="widget-simple <?php echo ($mesa[ocupado] == 0) ? 'themed-background-dark' : 'themed-background-dark-fire' ?>">
                          <a data-codigo="<?php echo $mesa[codigo_oculto] ?>" data-nombre="<?php echo $mesa[nombre] ?>" href="#" id="<?php echo ($mesa[ocupado]==0)? 'libre' : 'ocupado' ?>" >
                              <img src="../../img/placeholders/mesa.png" alt="avatar" class="widget-image img-circle pull-left">
                          </a>
                          <h4 class="widget-content">
                              <a data-nombre="<?php echo $mesa[nombre] ?>" data-codigo="<?php echo $mesa[codigo_oculto] ?>" href="#" id="<?php echo ($mesa[ocupado]==0)? 'libre1' : 'ocupado1' ?>">
                                  <strong><?php echo $mesa[nombre] ?></strong>
                              </a>
                          </h4>
                      </div>
                  </div>
              </div> 
              <?php endforeach ?>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-default btn-pure" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
</div>

<div class="modal fade modal-side-fall" id="md_digitar_cantidad" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Digite la cantidad</h4>
          </div>
          <div class="modal-body">
              <div class="form-group">
                <label for="" class="col-lg-4 control-label">Digite la cantidad</label>
                <div class="col-lg-9">
                  <input type="number" id="cuantos" value="1" class="form-control">
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Cerrar</button>
            <button id="agregar_a_tabla" class="btn btn-pure btn-primary"><i">agregar</button>
          </div>
        </div>
      </div>
</div>



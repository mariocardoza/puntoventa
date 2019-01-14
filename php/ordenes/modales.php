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

<div class="modal fade modal-side-fall" id="md_tipofactura" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">
          <span style="margin-right: -61px;" aria-hidden="true">×</span>
        </button>
        <div class="form-group">
          <h2>
            <div class="icheck-turquoise ">
                <input type="radio" value="1" name="tipo_factura" checked id="sala_belleza" />
                <label for="sala_belleza">Crédito fiscal</label>
            </div>
          </h2>
          <h2>
            <div class="icheck-turquoise ">
                <input type="radio" value="2" name="tipo_factura" id="mini_super" />
                <label for="mini_super">Consumidor final</label>
            </div>
          </h2>
          <h2>
            <div class="icheck-turquoise ">
                <input type="radio" value="3" name="tipo_factura" id="tienda" />
                <label for="tienda">Ticket</label>
            </div>
          </h2>         
        </div>
        <div class="form-group">
          <center>
            <button id="btn_cobrar_antes" class="btn btn-mio"><i">Aceptar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </center>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modal-side-fall" id="md_credito" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <center><h1>Crédito fiscal</h1></center>
        <form>
          <div class="row">
            <div class="col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Nombre" id="nombre_fac">         
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Dirección" id="direccion_fac">         
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-6"><input type="text" class="form-control" placeholder="NIT" id="nit_fac"></div>
            <div class="col-xs-6"><input type="text" class="form-control" placeholder="NRC" id="nrc_fac"></div>
          </div>
          <br><br>
          <div class="row">
            <div class="form-group">
              <center>
                <button id="btn_cobrar" type="button" class="btn btn-mio"><i">Aceptar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              </center>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modal-side-fall" id="md_consumidor" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <center><h1>Consumidor Final</h1></center>
        <form>
          <div class="row">
            <div class="col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Nombre" id="nombre_fac">         
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Dirección" id="direccion_fac">         
              </div>
            </div>
          </div>
          <br><br>
          <div class="row">
            <div class="form-group">
              <center>
                <button id="btn_cobrar" type="button" class="btn btn-mio"><i">Aceptar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              </center>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>


 <!-- MODAL PARA CARGAR LA VISTA PREVIA ANTES DE IMPRIMIR -->
    <div class="modal fade modal-side-fall" id="md_imprimir" aria-hidden="true"     aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
              
            </div>
            <div class="modal-footer">
          <a href="javascript:void(0)" class="btn btn-primary" id="btn_imprimir2" onclick="document.getElementById('PDF_doc').focus(); document.getElementById('PDF_doc').contentWindow.print();"> Imprimir</a>
              <a href="javascript:void(0)" class="btn btn-default btn-pure" id="btn_cancelar_nc" data-dismiss="modal" aria-label="Close">Cancelar</a>
            </div>
          </div>
        </div>
    </div>



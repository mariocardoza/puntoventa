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
            <button type="button" data-dismiss="modal" class="btn btn-default btn-pure">Cerrar</button>
          </div>
        </div>
      </div>
</div>

<div class="modal fade modal-side-fall" id="md_cuantos_mesa" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="nume_mesa"></h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <form action="">
                <div class="form-group">
                  <label for="">Cuantos clientes</label>
                  <input type="hidden" id="cod_mesa">
                  <input type="number" id="cuantos" class="form-control" placeholder="Numero de clientes">
                </div>
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-default btn-pure">Cerrar</button>
            <button class="btn btn-mio" type="button" id="btn_clientes">Aceptar</button>
          </div>
        </div>
      </div>
</div>

<div class="modal fade modal-side-fall" id="md_nombre_cliente" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" ></h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <form action="">
                <div class="form-group">
                  <label for="">Nombre del cliente</label>
                  <input type="text" id="elnombre" class="form-control" placeholder="Nombre del clientes">
                </div>
                <div class="form-group" id="domicilios" style="display: none;">
                  <label for="">Dirección de envío</label>
                  <textarea class="form-control" id="direcc" rows="2"></textarea>
                </div>
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-default btn-pure">Cerrar</button>
            <button class="btn btn-mio" type="button" id="btn_elcliente">Aceptar</button>
          </div>
        </div>
      </div>
</div>

<div class="modal fade modal-side-fall" id="md_add_nota" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Digite los comentarios </h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <form action="">
                <div class="form-group">
                  <label for="">Nota</label>
                  <input type="hidden" id="lafila">
                  <textarea name="" id="notita" rows="2" class="form-control"></textarea>
                </div>
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-default btn-pure">Cerrar</button>
            <button class="btn btn-mio" id="add_nota">Aceptar</button>
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
                <input type="radio" value="1" name="tipo_factura" checked id="credito_fiscal" />
                <label for="credito_fiscal">Crédito fiscal</label>
            </div>
          </h2>
          <h2>
            <div class="icheck-turquoise ">
                <input type="radio" value="2" name="tipo_factura" id="consumidor_final" />
                <label for="consumidor_final">Consumidor final</label>
            </div>
          </h2>
          <h2>
            <div class="icheck-turquoise ">
                <input type="radio" value="3" name="tipo_factura" id="ticket" />
                <label for="ticket">Ticket</label>
            </div>
          </h2>         
        </div>
        <div class="form-group">
          <center>
            <button id="btn_cobrar_antes" class="btn btn-mio">Aceptar</button>
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
                <input type="text" class="form-control" placeholder="Nombre" list="juridicos" id="nombre_fac">
                <datalist id="juridicos">
                  <?php foreach ($juridicos[1] as $juridico): ?>
                    <option value="<?php echo $juridico[nombre] ?>"></option>
                  <?php endforeach ?>
                </datalist>       
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Dirección" id="direccion_fac">
                <input type="hidden" id="id_juridicos">        
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-6"><input type="text" class="form-control nit" placeholder="NIT" id="nit_fac"></div>
            <div class="col-xs-6"><input type="text" class="form-control" placeholder="NRC" id="nrc_fac"></div>
          </div>
          <br><br>
          <div class="row">
            <div class="form-group">
              <center>
                <button id="btn_cobrar" style="display: none;" type="button" class="btn btn-mio acepta2">Aceptar</button>
                <button id="btn_guardar_juridico" type="button" class="btn btn-mio guarda2">Guardar</button>
                <button type="button" class="btn btn-default" id="btn_cerrar_fiscal">Cerrar</button>
              </center>
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
                <input type="hidden" id="id_natural">
                <input type="text" class="form-control" placeholder="Nombre" list="naturales" id="nombre_fac_final"> 
                <datalist id="naturales">
                  <?php foreach ($naturales[1] as $natural): ?>
                    <option value="<?php echo $natural[nombre] ?>"></option>
                  <?php endforeach ?>
                </datalist>        
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Dirección" id="direccion_fac_final">         
              </div>
            </div>
          </div>
          <br><br>
          <div class="row">
            <div class="form-group">
              <center>
                <button id="btn_cobrar" type="button" class="btn btn-mio acepta" style="display: none;">Aceptar</button>
                <button id="btn_guardar_natural" type="button" class="btn btn-mio guarda">Guardar</button>
                <button type="button" class="btn btn-default" id="btn_cerrar_consumidor">Cerrar</button>
              </center>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- modal antes de imprimir el ticket -->
<div class="modal fade modal-side-fall" id="md_formapago" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <center><h1>Forma de pago</h1></center>
        <form id="pagoo">
          <div class="row">
            <div class="col-xs-12">
              <div class="form-group">
                <h2 id="poner_totala"></h2>
                <h2 id="poner_propina"></h2>
                <h2 id="poner_total"></h2>
                <input type="hidden" readonly class="form-control" placeholder="Nombre" name="total_venta" id="total_venta">
                <input type="hidden" id="total_real">
                <input type="hidden" readonly class="form-control" placeholder="Nombre" id="id_venta">
                <input type="hidden" name="tipo_fac" id="tipo_fac"><input type="hidden" id="propi">
                <input type="hidden" id="mesita">;         
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="form-group">
                <div class="icheck-turquoise icheck-inline">
                    <input type="radio" value="1" name="tipo_pago" checked id="efectivo" />
                    <label for="efectivo">Efectivo</label>
                </div>
                <div class="icheck-turquoise icheck-inline">
                    <input type="radio" value="2" name="tipo_pago" id="credito" />
                    <label for="credito">Crédito</label>
                </div>
                <div class="icheck-turquoise icheck-inline">
                    <input type="radio" value="3" name="tipo_pago" id="tarjeta" />
                    <label for="tarjeta">Tarjeta</label>
                </div>
                <!--div class="icheck-turquoise icheck-inline">
                    <input type="radio" value="4" name="tipo_pago" id="cupon" />
                    <label for="cupon">Cupón</label>
                </div-->        
              </div>
            </div>
            <div class="col-xs-12" id="efec">
              <div class="form-group">
                <label for="">Efectivo recibido</label>
                <input type="text" name="efectivo_recibido" class="form-control" id="efectivo_recibido">
              </div>
              <div class="form-group">
                <label for="">Cambio</label>
                <input type="text" readonly class="form-control" id="efectivo_vuelto">
              </div>
            </div>
            <div class="col-xs-12" id="credit" style="display: none;">
              <div class="form-group">
                <label for="">Cliente</label>
                <select disabled name="cliente_debe" id="cliente_debe" class="select-chosen">
                </select>
              </div>
              <div class="form-group">
                <label for="">Fecha de pago</label>
                <input type="text" disabled name="fecha_pago" id="fecha_pago" class="form-control vecimi">
              </div>
              <div class="form-group">
                <label for="">Descripción</label>
                <textarea disabled name="descripcion_debe" class="form-control" id="descripcion_debe" cols="3"></textarea>
              </div>
            </div>
          </div>
          <br><br>
          <div class="row">
            <div class="form-group">
              <center>
                <button id="btn_imprimir_ticket" type="button" class="btn btn-mio">Aceptar</button>
                <button type="button" class="btn btn-default" id="btn_cerrar_formapago">Cerrar</button>
              </center>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modal-side-fall" id="md_propina" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">
          <span style="margin-right: -61px;" aria-hidden="true">×</span>
        </button>
        <div class="form-group">
          <label for="" class="control-label">¿Desea aplicar propina?</label>
          <h2>
            <div class="icheck-turquoise icheck-inline">
                <input type="radio" value="1" name="propina" checked id="si" />
                <label for="si">Si</label>
            </div>
          </h2>
          <h2>
            <div class="icheck-turquoise icheck-inline">
                <input type="radio" value="2" name="propina" id="no" />
                <label for="no">No</label>
            </div>
          </h2>       
        </div>
        <div class="form-group">
          <center>
            <button id="btn_cobrar_antes_p" class="btn btn-mio">Aceptar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </center>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modal-side-fall" id="md_cambiar_comanda" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">
          <span style="margin-right: -61px;" aria-hidden="true">×</span>
        </button>
        <div class="form-group" id="lapregunta">
          <h2>¿Desea cambiar el tipo de la orden?</h2>
            <h3>
              <div class="icheck-turquoise icheck-inline">
                  <input type="radio" value="2" name="quecambiar" checked id="cno" />
                  <label for="cno">No</label>
              </div>
            </h3>
            <h3>
              <div class="icheck-turquoise icheck-inline">
                <input type="radio" value="1" name="quecambiar" id="csi" />
                <label for="csi">Si</label>
            </div>
          </h3>
        </div>
        <div class="form-group" id="diveltipo" style="display: none;">
          <h2>Seleccione una opción</h2>
            <h3>
              <div class="icheck-turquoise icheck-inline">
                  <input type="radio" value="1" name="eltipodeorden" <?php echo ($comanda_a[tipo]==1) ? 'checked':'' ?> id="mesaa" />
                  <label for="mesaa">Mesas</label>
              </div>
            </h3>
            <h3>
              <div class="icheck-turquoise icheck-inline">
                <input type="radio" value="2" name="eltipodeorden" <?php echo ($comanda_a[tipo]==2) ? 'checked':'' ?> id="lleva" />
                <label for="lleva">Llevar</label>
              </div>
            </h3>
            <h3>
              <div class="icheck-turquoise icheck-inline">
                <input type="radio" value="3" name="eltipodeorden" <?php echo ($comanda_a[tipo]==3) ? 'checked':'' ?> id="domi" />
                <label for="domi">Domicilio</label>
              </div>
            </h3>
        </div>
        <div class="form-group">
          <center>
            <button id="btn_cobrar_antes_p" class="btn btn-mio">Aceptar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </center>
        </div>
      </div>
    </div>
  </div>
</div>
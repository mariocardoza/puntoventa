<div class="row">
        <div class="col-xs-4 col-lg-4">
            <a href="../../php/clientes/clientes.php" style="border-radius: 10px; background-color: #fff">
                <div class="card-index">
                    <div class="row">
                        <div class="col-lg-6 col-xs-6">
                            <div class="card-index-adentro" style="border-right: 3px solid; color: #F3F3F3F3; ">
                                <p style="font-size: 48px; color: #40BAB3; text-align: center; position: relative;top: 27%;"><strong><?php echo $clientes[0][clientes] ?></strong></p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-6">
                            <div class="card-index-adentro">
                                <p style="font-size: 18px; color: #333333; text-align: center; position: relative;top: 47%;"><strong>Clientes inscritos</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xs-4 col-lg-4">
            <a href="../../php/productos/productos.php" style="border-radius: 10px; background-color: #fff">
                <div class="card-index">
                    <div class="row">
                        <div class="col-lg-6 col-xs-6">
                            <div class="card-index-adentro" style="border-right: 3px solid; color: #F3F3F3F3; ">
                                <p style="font-size: 48px; color: #40BAB3; text-align: center; position: relative;top: 27%;"><strong><?php echo $productos[0][productos] ?></strong></p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-6">
                            <div class="card-index-adentro">
                                <p style="font-size: 18px; color: #333333; text-align: center; position: relative;top: 35%;"><strong>Productos en inventario</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xs-4 col-lg-4">
            <a href="javascript:void(0)" style="border-radius: 10px; background-color: #fff">
                <div class="card-index">
                    <div class="row">
                        <div class="col-lg-6 col-xs-6">
                            <div class="card-index-adentro" style="border-right: 3px solid; color: #F3F3F3F3; ">
                                <p style="font-size: 29px; color: #40BAB3; text-align: center; position: relative;top: 37%;"><strong>$<?php echo number_format($datos[3],2); ?></strong></p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-6">
                            <div class="card-index-adentro">
                                <p style="font-size: 18px; color: #333333; text-align: center; position: relative;top: 42%;"><strong>Facturado este mes</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-xs-8">
            <div id="grafica1"></div>
        </div>
        <div class="col-xs-4" style="background: #fff;">
            <table class="table" id="tabla_mas">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-xs-8">
            <div id="grafica2"></div>
        </div>
        <div class="col-xs-4" style="background: #fff;">
            <table class="table" id="tabla_menos">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12" style="background: #FFF;">
            <center><h1>Ventas del día</h1></center>
            <table class="table" id="lasdeldia">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>N° de caja</th>
                        <th>Cajero</th>
                        <th>Monto</th>
                        <th>Fecha y hora</th>
                        <th>Concepto</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>      
        </div>
    </div>
<?php 
	@session_start();
	require_once 'Conexion.php';

	/**
	* 
	*/
	class Genericas2 
	{
		
		function __construct($argument)
		{
			# code...
		}
		public static function seleccionar_todo($array){
			$as = 0;
			$tabla= $campo = $llaves = $valor = "";

			foreach(array_keys($array) as $key ) {
				$as++;
				if ($key === 'table') {//obtengo tabla
	 				$tabla = $array[$key];
	 			}else if ($as===2) {//obtengo el where
	 				$valor = $array[$key];
	 				$campo = $key;
	 			}else if ($as>2) {//obtengo valores a sacar
	 				$llaves.=$key;
					if ($as <count($array)) {
							$llaves.=",";
					}
	 			} 
			}

			$sql = "SELECT $llaves FROM $tabla WHERE $campo = '$valor'";
			try {
				$comando = Conexion::getInstance()->getDb()->prepare($sql);
	       		$comando->execute();
	       		while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
	       			$resultado=$row;
	       		}
	       		//$resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
	       		return array("1",$resultado,$sql);
				//echo json_encode(array("exito" => $exito));
			} catch (Exception $e) {
				return array("0","error",$e->getMessage(),$e->getLine(),$sql);
	            //echo json_encode(array("error" => $error));
			}

		}


		public static function seleccionar_especifico_detabla($array){
			$as = 0;
			$tabla= $campo = "";

			foreach(array_keys($array) as $key ) {
				$as++;
				if ($key === 'table') {//obtengo tabla
	 				$tabla = $array[$key];
	 			}else if ($as===2) {//obtengo tabla
	 				$campo = $array[$key];
	 			} 
			}

			$sql = "SELECT $campo FROM $tabla";
			try {
				$comando = Conexion::getInstance()->getDb()->prepare($sql);
	       		$comando->execute();
	       		$resultado = $comando->fetchAll(PDO::FETCH_COLUMN, 0);
	       		return array($resultado[0],$sql);
				//echo json_encode(array("exito" => $exito));
			} catch (Exception $e) {
				return array("0","error",$e->getMessage(),$e->getLine(),$sql);
	            //echo json_encode(array("error" => $error));
			}

		}




		public static function seleccionar_cualquiera($array){
			$as = 0;
			$tabla= $campo = "";

			foreach(array_keys($array) as $key ) {
				$as++;
				if ($key === 'table') {//obtengo tabla
	 				$tabla = $array[$key];
	 			}else if ($as===2) {//obtengo tabla
	 				$campo = $array[$key];
	 			}else if ($as===3) {//obtengo tabla
	 				$whereid = $key;
	 				$valor_whereid = $array[$key];
	 			}
			}

			$sql = "SELECT $campo FROM $tabla WHERE $whereid = '$valor_whereid'";
			try {
				$comando = Conexion::getInstance()->getDb()->prepare($sql);
	       		$comando->execute();
	       		$resultado = $comando->fetchAll(PDO::FETCH_COLUMN, 0);
	       		return array($resultado[0],$sql);
				//echo json_encode(array("exito" => $exito));
			} catch (Exception $e) {
				return array("0","error",$e->getMessage(),$e->getLine(),$sql);
	            //echo json_encode(array("error" => $error));
			}

		}

		public static function buscar_por_id($tabla,$campo,$id){
			$sql="SELECT * FROM $tabla WHERE $campo='$id'";

			try {
				$comando = Conexion::getInstance()->getDb()->prepare($sql);
	       		$comando->execute();
	       		while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
	       			$resultado[]=$row;
	       		}
	       		//$resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
	       		return array("1",$resultado,$sql);
				//echo json_encode(array("exito" => $exito));
			} catch (Exception $e) {
				return array("0","error",$e->getMessage(),$e->getLine(),$sql);
	            //echo json_encode(array("error" => $error));
			}
		}

		
		public static function retonrar_id_insertar($tabla){
			$gsent = Conexion::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM $tabla");
			$gsent->execute();
			$resultado = $gsent->fetchAll(PDO::FETCH_COLUMN, 0);
			return date("Yidisus").'-'.($resultado[0]+1);
		}

		public static function retornar_correlativo($tabla,$codigo){
			$comando=Conexion::getInstance()->getDb()->prepare("SELECT COUNT(*) as suma FROM $tabla WHERE codigo_producto='$codigo'");
			$comando->execute();
			while($row=$comando->fetch(PDO::FETCH_ASSOC)){
				$resultado=$row['suma'];
			}
			return $codigo.'-'.($resultado+1);
		}

		public static function retornar_imagen($array_imagen){
			$tabla = $campo_buscar = $valor_campo_buscar = $campo_comparar = "";
			$as=0;

			foreach(array_keys($array_imagen) as $key ) {//recorro el array que me envia mi json
	 			$as++;
	 			if ($key === 'table') {//obtengo tabla
	 				$tabla = $array_imagen[$key];
	 			}else if ($as===2) {
	 				$valor_campo_buscar = $array_imagen[$key];
	 				$campo_comparar= $key;
	 			}
	 			else if ($key === 'campo') {//obtengo el campo a comparar
	 				$campo_buscar = $array_imagen[$key];
	 				 
				}
			}

			$sql = "SELECT $campo_buscar FROM $tabla WHERE $campo_comparar = '$valor_campo_buscar'";
			/*return array("1",$sql,$array_imagen);
			exit();*/
			$gsent = Conexion::getInstance()->getDb()->prepare($sql);
			$gsent->execute();
			$resultado = $gsent->fetchAll(PDO::FETCH_COLUMN, 0);
			if (isset($resultado[0]) && $resultado[0]!="") {
				return array("1",$resultado[0],$sql);
			}else{
				return array("0",$sql,$resultado,$sql);
			}
			
		}

		public static function encriptar_datos($datos, $key){

		}
		public static function insertar_generica($tablita,$array_values){
			$tabla = "";
	 		$values = "";
	 		$llaves = "";
			$as =0;
	 		foreach(array_keys($array_values) as $key ) {
	 			$as++;
	 			if ($key === 'table') {
	 				$tabla = $array_values[$key];
	 			} 
	 			if ($as>1) {
	 				$llaves.=$key;
					$values.="'".$array_values[$key]."'";
					if ($as <count($array_values)) {
							$values.=",";
							$llaves.=",";
					}
				}
				if($key==='codigo_oculto'){
					$elid=$array_values[$key];
				}
	 		}
			$sql ="INSERT INTO $tablita($llaves)values($values)";
			//return array(1,$sql);
			try {
				$comando = Conexion::getInstance()->getDb()->prepare($sql);
	       		$comando->execute();
	       		//$elid=$comando->lastInsertId();
	       		return array(1,"Insertado",$sql,$elid);
				//echo json_encode(array("exito" => $exito));
			} catch (Exception $e) {
				return array(-1,"error",$e->getMessage(),$e->getLine(),$sql);
	            //echo json_encode(array("error" => $error));
			}
		}
//funcion para dar de baja (cambiar estado a 2)
		public static function darbaja($tabla,$id){
		$sql="UPDATE $tabla SET estado=2 WHERE id=$id";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			return array(1,"exito",$sql);
		}catch(Exception $e){
			return array(-1,$e->getMessage(),$e->getLine(),$sql);
		}

		
	}

	//funcion para dar de alta (cambiar estado a 1)
		public static function daralta($tabla,$id){
		$sql="UPDATE $tabla SET estado=1 WHERE id=$id";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			return array(1,"exito",$sql);
		}catch(Exception $e){
			return array(-1,$e->getMessage(),$e->getLine(),$sql);
		}

		
	}

		//insert into table ()values()
		//update table set campo = value()
		public static function actualizar_generica($tablita,$array_values){
			//preparo variables
			$tabla = "";
			$wherid="";
	 		$valor_whereid="";
	 		$values = "";
	 		$llaves = "";
	 		$sentencia_update = "";
	 		$as =0;
			$agregando_as="";
			foreach(array_keys($array_values) as $key ) {//recorro el array que me envia mi json
	 			$as++;
	 			if ($key === 'table') {//obtengo tabla
	 				$tabla = $array_values[$key];
	 			}
	 			else if ($as===2) {//obtengo id para update
	 				$valor_whereid = $array_values[$key];
	 				$wherid= $key;
	 			} 
	 			else if ($as>2) {//creo los set
	 				$llaves.=$key;
					$values.="'".$array_values[$key]."'";
					$sentencia_update.= $key.'='."'".$array_values[$key]."'";
					if ($as <count($array_values)) {
							$values.=",";
							$llaves.=",";
							$sentencia_update.=',';
					}
					$agregando_as.=$as;
				}
				if($key==='codigo_oculto'){
					$elid=$array_values[$key];
				}
	 		}

	 		$sql ="UPDATE $tablita SET $sentencia_update WHERE $wherid = '$valor_whereid'";//String de update creada
	 		/*return array("1","2",$sql,$as,$agregando_as);
	 		exit();*/
	 		//return $sql;
			try {
				$comando = Conexion::getInstance()->getDb()->prepare($sql);//ejecutro la actualización
	       		$comando->execute();
	       		return array("1",array("Actualizado",$sql),$elid);//retorno en caso de exito 
				//echo json_encode(array("exito" => $exito));
			} catch (Exception $e) {
				return array("0","Error al actualizar",$e->getMessage(),$e->getLine(),$sql);//retorno mensajes en caso de error
			}




		}

		public static function eliminar_generica($array_values){
			$tabla = $valor_campo=$campo="";
			$as=0;
			foreach(array_keys($array_values) as $key ) {
				$as++;
	 			if ($key === 'table') {//obtengo tabla
	 				$tabla = $array_values[$key];
	 			}else if ($as === 2) {//obtengo id para update
	 				$valor_campo = $array_values[$key];
	 				$campo= $key;
	 			} 
			}

			$sql = "DELETE FROM $tabla WHERE $campo = '$valor_campo'";
			
			try {
				$comando = Conexion::getInstance()->getDb()->prepare($sql);
	            $comando->execute();
	            return array("1","Eliminado");
	        }catch(Exception $e){
	        	return array("0","Error al eliminar",$e->getMessage(),$e->getLine(),$sql);
	        	exit();
	        }
			 
		}

		/***/
		//
		//emailte: valor del campo puede ser telefono o correo 
		//valor_delcampo: es el valor a buscar
		//tabla: el nombre de la tabla
		//quees: si es un insert o un update
		//valor_antiguo: si es una actualizacion sera el campo anterior, si es un insert sera 0
		public static function validar($emailte,$valor_delcampo,$tabla,$quees,$valor_antiguo){
			$campo = "";
			if ($emailte == "email" || $emailte =="correo") {
				$campo = ($emailte=="email") ? $emailte : "correo";
			}else{
				$campo = ($emailte=="telefono") ? $emailte : "telefono_movil";
			}

			$campo_sacado="";
			$sql = ($quees ==1) ? "SELECT $campo from $tabla WHERE $campo = '$valor_delcampo'" : "SELECT $campo from $tabla WHERE $campo = '$valor_delcampo' AND $campo <> '$valor_antiguo'";
			try {
				$comando = Conexion::getInstance()->getDb()->prepare($sql);
	            $comando->execute();

	            while ($row = $comando->fetch(PDO::FETCH_ASSOC)) {
	                $campo_sacado = $row[$campo];
            	}
            	if($cuenta = $comando->rowCount()>0){
            		return array("1",$campo_sacado,$sql);
					exit();
            	}else{
            		return array("2",$campo_sacado,$sql);
					exit();
            	}
				
				
			} catch (Exception $e) {
				return array("-1",$e->getMessage(),$e->getLine(),$sql);
				exit();
			}

		}

		public static function generarpass(){
		    $cadena_base =  'abcdefghijklmnopqrstuvwxyz';
		    $cadena_base .= '0123456789' ;
		    //$cadena_base .= '!@#%^&*()_,./<>?;:[]{}\|=+';
		    $cadena_base .= '';
			$password = '';
			$limite = strlen($cadena_base) - 1;
			$largo = 8;
			for ($i=0; $i < $largo; $i++)
			$password .= $cadena_base[rand(0, $limite)];

			return $password;
		}
		
		public static function generartoken(){
		    $cadena_base .= '0123456789' ;
		    //$cadena_base .= '!@#%^&*()_,./<>?;:[]{}\|=+';
		    $cadena_base .= '';
			$password = '';
			$limite = strlen($cadena_base) - 1;
			$largo = 6;
			for ($i=0; $i < $largo; $i++)
			$password .= $cadena_base[rand(0, $limite)];

			return $password;
		}

		public static function ver_venta($codigo_oculto)
		{
			$sql="SELECT v.*,per.nombre as n_empleado,c.nombre as n_cliente, DATE_FORMAT(v.fecha, '%d/%m/%Y') as lafecha, v.codigo_oculto as codigo_venta FROM tb_venta as v INNER JOIN tb_persona as per ON v.empleado=per.email LEFT JOIN tb_cliente as c ON c.codigo_oculto=v.cliente WHERE v.codigo_oculto='$codigo_oculto'";

			$sql_detalle="SELECT vd.cantidad as cantidad,p.nombre as n_producto,(((p.ganancia / 100) * p.precio_unitario) + p.precio_unitario) AS precio_venta,pd.* FROM tb_venta_detalle as vd INNER JOIN tb_producto_detalle as pd ON pd.codigo_producto=vd.codigo_producto INNER JOIN tb_producto as p ON p.codigo_oculto=pd.codigo_producto  WHERE vd.codigo_venta='$codigo_oculto' GROUP BY pd.codigo_producto";
				try {
			$comando = Conexion::getInstance()->getDb()->prepare($sql);
			$comando2 = Conexion::getInstance()->getDb()->prepare($sql_detalle);
	        $comando->execute();
	        $comando2->execute();
	        $producto="";
	        //$datos = $comando->fetchAll(PDO::FETCH_ASSOC);
	        while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
	        	$venta=$row;
	        }
	        while ($row2=$comando2->fetch(PDO::FETCH_ASSOC)) {
	        	$detalles[]=$row2;
	        }
	        $tipo="";
	        if($venta[tipo]==1){
	        	$tipo="Crédito fiscal";
	        }
	        if($venta[tipo]==2){
	        	$tipo="Consumidor final";
	        }
	        if($venta[tipo]==3){
	        	$tipo="Ticket";
	        }

	        $modal='<div class="modal fade modal-side-fall" id="md_ver_venta" aria-hidden="true"
	      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
	      <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	          <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal">
	              <span aria-hidden="true">×</span>
	            </button>
	            <h4 class="modal-title">Detalle de la venta</h4>
	          </div>
	          <div class="modal-body">
	            <div class="row">
	        		<div class="col-xs-3"></div>
	        		<div class="col-xs-6">
	        			<table class="table">
			                <tbody>
			                    <tr>
			                    	<td>'.$tipo.' N° '.$venta[correlativo].'</td>
			                    </tr>
			                    <tr>
			                    	<td>Cliente: '.$venta[n_cliente].'</td>
			                    </tr>
			                    <tr>
			                    	<td>Cajero (a): '.$venta[n_empleado].'</td>
			                    </tr>
			                    <tr>
			                    	<td>Total: $'.number_format($venta[total],2).'</td>
			                    </tr>
			                </tbody>
		            	</table>
	        		</div>
	        		<div class="col-xs-3"></div>
	            </div>
	            <div class="row">
	            	<div class="col-xs-2"></div>
	            	<div class="col-xs-8">
	            		<table class="table">
	            			<thead>
	            				<tr>
	            					<th>Cant.</th>
	            					<th>Descripción.</th>
	            					<th>Desc.</th>
	            					<th>Precio/u.</th>
	            					<th>Total</th>
	            				</tr>
	            			</thead>
	            			<tbody>';
	            			foreach ($detalles as $detalle):
	            				$modal.='<tr>
	            						<td>'.$detalle[cantidad].'</td>
	            						<td>'.$detalle[n_producto].'</td>
	            						<td>$0.00</td>
	            						<td>$'.number_format($detalle[precio_venta],2).'</td>
	            						<td>$'.number_format($detalle[precio_venta]*$detalle[cantidad],2).'</td>
	            						</tr>';
	            			endforeach;
	            			$modal.='</tbody>
	            		</table>
	            	</div>
	            	<div class="col-xs-2"></div>
	            </div>
	          </div>
	          <div class="modal-footer">
	            <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Cerrar</button>
	          </div>
	        </div>
	      </div>
	    </div>';

	            return array("1",$producto,$sql,$modal,$detalles);
			} catch (Exception $e) {
				return array("-1",$e->getMessage(),$e->getLine(),$sql);
				exit();
			}
	}

	public static function numaletras($xcifra)
	{
    	$xarray = array('0' => "CERO",
        1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
        "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
        "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
        100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
    );
//
    $xcifra = trim($xcifra);
    $xlength = strlen($xcifra);
    $xpos_punto = strpos($xcifra, ".");
    $xaux_int = $xcifra;
    $xdecimales = "00";
    if (!($xpos_punto === false)) {
        if ($xpos_punto == 0) {
            $xcifra = "0" . $xcifra;
            $xpos_punto = strpos($xcifra, ".");
        }
        $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
        $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
		$xdecimales1=Genericas2::numletras($xdecimales);
    }

    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
    $xcadena = "";
    for ($xz = 0; $xz < 3; $xz++) {
        $xaux = substr($XAUX, $xz * 6, 6);
        $xi = 0;
        $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
        $xexit = true; // bandera para controlar el ciclo del While
        while ($xexit) {
            if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                break; // termina el ciclo
            }

            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
            for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                switch ($xy) {
                    case 1: // checa las centenas
                        if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas

                        } else {
                            $key = (int) substr($xaux, 0, 3);
                            if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                $xseek = $xarray[$key];
                                $xsub = Genericas2::sub_fijo($xaux); // devuelve el sub_fijo correspondiente (Millón, Millones, Mil o nada)
                                if (substr($xaux, 0, 3) == 100)
                                    $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                            }
                            else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                $key = (int) substr($xaux, 0, 1) * 100;
                                $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                $xcadena = " " . $xcadena . " " . $xseek;
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 0, 3) < 100)
                        break;
                    case 2: // checa las decenas (con la misma lógica que las centenas)
                        if (substr($xaux, 1, 2) < 10) {

                        } else {
                            $key = (int) substr($xaux, 1, 2);
                            if (TRUE === array_key_exists($key, $xarray)) {
                                $xseek = $xarray[$key];
                                $xsub = Genericas2::sub_fijo($xaux);
                                if (substr($xaux, 1, 2) == 20)
                                    $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3;
                            }
                            else {
                                $key = (int) substr($xaux, 1, 1) * 10;
                                $xseek = $xarray[$key];
                                if (20 == substr($xaux, 1, 1) * 10)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 1, 2) < 10)
                        break;
                    case 3: // checa las unidades
                        if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada

                        } else {
                            $key = (int) substr($xaux, 2, 1);
                            $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                            $xsub = Genericas2::sub_fijo($xaux);
                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                        } // ENDIF (substr($xaux, 2, 1) < 1)
                        break;
                } // END SWITCH
            } // END FOR
            $xi = $xi + 3;
        } // ENDDO

        if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
            $xcadena.= " DE";

        if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
            $xcadena.= " DE";

        // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
        if (trim($xaux) != "") {
            switch ($xz) {
                case 0:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN BILLON ";
                    else
                        $xcadena.= " BILLONES ";
                    break;
                case 1:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN MILLON ";
                    else
                        $xcadena.= " MILLONES ";
                    break;
                case 2:
					if ($xcifra < 0) {
                        $xcadena = " $xdecimales1 CENTAVOS DE DÓLAR DE LOS ESTADOS UNIDOS DE AMERICA";
                    }
					if ($xcifra < 1) {
					if($xdecimales=="00"){
						//$xdecimales1="CERO";
					    $xcadena.= " CERO DOLARES CON CERO CENTAVOS DE DÓLAR DE LOS ESTADOS UNIDOS DE AMERICA " ; //
						}else{
                        $xcadena = "$xdecimales1 CENTAVOS DE DÓLAR DE LOS ESTADOS UNIDOS DE AMERICA";
                    }
					}
					if ($xcifra == 1) {
                        $xcadena.= " DÓLAR EXACTO";
                    }

                    if ($xcifra > 1 && $xcifra < 2) {
					 //  $xdecimales1=numaletras($xdecimales);
                        $xcadena = "UN DÓLAR CON $xdecimales1 CENTAVOS";
                    }

					 if ($xcifra == 2 ) {
					    $xcadena.= " 00/100 " ; //
//						return 0;
                    }

                    if ($xcifra > 2) {
						if($xdecimales=="00"){
						//$xdecimales1="CERO";
					    $xcadena.= " 00/100 DÓLARES" ; //
						}else{
						$xcadena.= " $xdecimales/100 DÓLARES" ; //
						}
//						return 0;
                    }
                    break;

            } // endswitch ($xz)

        } // ENDIF (trim($xaux) != "")
        // ------------------      en este caso, para México se usa esta leyenda     ----------------
        $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda


    } // ENDFOR ($xz)

    return trim($xcadena);

}

// END FUNCTION

public static function sub_fijo($xx)
{ // esta función regresa un sub_fijo para la cifra
    $xx = trim($xx);
    $xstrlen = strlen($xx);
    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
        $xsub = "";
    //
    if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
        $xsub = "MIL";
    //
    return $xsub;
}

public static function numletras($xcifra)
{
    $xarray = array(0 => "CERO",
       1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
        "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
        "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
        100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
    );
//
    $xcifra = trim($xcifra);
    $xlength = strlen($xcifra);
    $xpos_punto = strpos($xcifra, ".");
    $xaux_int = $xcifra;
    $xdecimales = "00";
    if (!($xpos_punto === false)) {
        if ($xpos_punto == 0) {
            $xcifra = "0" . $xcifra;
            $xpos_punto = strpos($xcifra, ".");
        }
        $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
        $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
    }

    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
    $xcadena = "";
    for ($xz = 0; $xz < 3; $xz++) {
        $xaux = substr($XAUX, $xz * 6, 6);
        $xi = 0;
        $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
        $xexit = true; // bandera para controlar el ciclo del While
        while ($xexit) {
            if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                break; // termina el ciclo
            }

            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
            for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                switch ($xy) {
                    case 1: // checa las centenas
                        if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas

                        } else {
                            $key = (int) substr($xaux, 0, 3);
                            if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                $xseek = $xarray[$key];
                                $xsub = Genericas2::nombre($xaux); // devuelve el nombre correspondiente (Millón, Millones, Mil o nada)
                                if (substr($xaux, 0, 3) == 100)
                                    $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                            }
                            else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                $key = (int) substr($xaux, 0, 1) * 100;
                                $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                $xcadena = " " . $xcadena . " " . $xseek;
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 0, 3) < 100)
                        break;
                    case 2: // checa las decenas (con la misma lógica que las centenas)
                        if (substr($xaux, 1, 2) < 10) {

                        } else {
                            $key = (int) substr($xaux, 1, 2);
                            if (TRUE === array_key_exists($key, $xarray)) {
                                $xseek = $xarray[$key];
                                $xsub = Genericas2::nombre($xaux);
                                if (substr($xaux, 1, 2) == 20)
                                    $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3;
                            }
                            else {
                                $key = (int) substr($xaux, 1, 1) * 10;
                                $xseek = $xarray[$key];
                                if (20 == substr($xaux, 1, 1) * 10)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 1, 2) < 10)
                        break;
                    case 3: // checa las unidades
                        if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada

                        } else {
                            $key = (int) substr($xaux, 2, 1);
                            $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                            $xsub = Genericas2::nombre($xaux);
                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                        } // ENDIF (substr($xaux, 2, 1) < 1)
                        break;
                } // END SWITCH
            } // END FOR
            $xi = $xi + 3;
        } // ENDDO

        if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
            $xcadena.= " DE";

        if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
            $xcadena.= " DE";

        // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
        if (trim($xaux) != "") {
            switch ($xz) {
                case 0:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN BILLON ";
                    else
                        $xcadena.= " BILLONES ";
                    break;
                case 1:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN MILLON ";
                    else
                        $xcadena.= " MILLONES ";
                    break;
                case 2:
                    if ($xcifra < 1) {
                        //$xcadena = "CERO PESOS $xdecimales/100 M.N.";
                    }
                    if ($xcifra >= 1 && $xcifra < 2) {
                        //$xcadena = "UN PESO $xdecimales/100 M.N. ";
                    }
                    if ($xcifra >= 2) {
                        //$xcadena.= " PESOS $xdecimales/100 M.N. "; //
                    }
                    break;
            } // endswitch ($xz)
        } // ENDIF (trim($xaux) != "")
        // ------------------      en este caso, para México se usa esta leyenda     ----------------
        $xcadena = str_replace("VEINTI", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
        $xcadena = str_replace(" ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
    } // ENDFOR ($xz)
    return trim($xcadena);
}

public static function nombre($xx)
{ // esta función regresa un nombre para la cifra
    $xx = trim($xx);
    $xstrlen = strlen($xx);
    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
        $xsub = "";
    //
    if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
        $xsub = "MIL";
    //
    return $xsub;
}
	}
	


?>
<?php
   @session_start();
   require_once 'Conexion.php';
   
   class Perfil
   {
   
       function __construct()
       {
           # code...
       }

       public static function obtener_perfil($id){
        $sql="SELECT *,DATE_FORMAT(fecha_nacimiento,'%d/%m/%Y') as fecha FROM tb_persona WHERE id=$id";
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

  public static function construir_perfil($email){
          $codigo_oculto="";
          $html ="";
          $sql = "SELECT p.id, p.nombre as nombre, p.direccion as direccion,p.telefono as telefono,p.nit as nit,p.dui as dui,p.imagen as foto,p.genero,p.email, TIMESTAMPDIFF(YEAR, p.fecha_nacimiento, CURDATE()) AS edad,DATE_FORMAT(p.fecha_nacimiento, '%d/%m/%Y') as fecha_nacimiento,p.estado_civil FROM tb_persona AS p INNER JOIN tb_usuario AS u ON u.email=p.email WHERE p.email='$email'";
          try {
                
                $elec1 = Conexion::getInstance()->getDb()->prepare($sql);
                $elec1->execute();
                while ($row = $elec1->fetch(PDO::FETCH_ASSOC)) {

                  $html.='<div class="block">
                
                            <div class="block-title">
                                <h2><i class="gi gi-user"></i> <strong>Información de</strong> Perfil</h2>
                            </div>
                            <div class="block-section text-center">
                                <a href="javascript:void(0)">
                                    <img src="../../img/usuario/'.$row[foto].'" style="width: 128px;height: 128px;" alt="avatar" class="img-circle">
                                </a>
                                <h3>
                                    <strong>'.$row[nombre].'</strong><br><small></small>
                                </h3>
                            </div>
                            <table class="table table-borderless table-striped table-vcenter">
                                <tbody>

                                    <tr>
                                        <td class="text-right" style="width: 50%;"><strong>Fecha de nacimiento</strong></td>
                                        <td>'.$row[fecha_nacimiento].'</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Edad</strong></td>
                                        <td>'.$row[edad].' años </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Genero</strong></td>
                                        <td>'.$row[genero].'</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Télefono</strong></td>
                                        <td>'.$row[telefono].'</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Correo</strong></td>
                                        <td>'.$row[email].'</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Estado Civil</strong></td>
                                        <td>'.$row[estado_civil].'</td>
                                    </tr>
                                    <!--tr>
                                        <td class="text-right"><strong>Empresa</strong></td>
                                        <td><span class="label label-success">'.$row[empresanombre].'</span></td>
                                    </tr-->
                                    <tr>
                                        <td class="text-right"><a onclick="editar('.$row[id].')" href="#" class="btn btn-warning"><i class="fa fa-edit"></i></a></td>
                                        <td class="text-left"><a onclick="cambiar_pass('.$row[id].')" href="#" class="btn btn-primary"><i class="fa fa-key"></i></a></td>
                                    </tr>
                                </tbody>
                            </table>
               
                        </div>';


                }
                return $html;
          } catch (Exception $e) {
                return array($e->getMessage(),$sql);
          }

          
        }
   
      
   }
   
   
   
   ?>
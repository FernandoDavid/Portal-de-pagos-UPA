<?php

require_once "conexion.php";

class ModeloFormularios
{
    static public function mdlCrearRegistro($tabla, $campos, $datos)
    {
        $strCampos = '`' . implode('`,`', $campos) . '`';
        $strValues = ':' . implode(', :', $campos);
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla($strCampos) VALUES ($strValues)");
        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":direc", $datos["direc"], PDO::PARAM_STR);
        $stmt->bindParam(":curp", $datos["curp"], PDO::PARAM_STR);
        $stmt->bindParam(":rfc", $datos["rfc"], PDO::PARAM_STR);
        $stmt->bindParam(":sexo", $datos["sexo"], PDO::PARAM_STR);
        $stmt->bindParam(":est_civil", $datos["est_civil"], PDO::PARAM_STR);
        $stmt->bindParam(":idCurso", $datos["idCurso"], PDO::PARAM_INT);
        // $i = 0;
        // foreach ($datos as $dato) {
        //     echo '<pre>';
        //     var_dump($dato);
        //     var_dump($i);
        //     var_dump(":".$campos[$i]);
            
        //     if (is_numeric($dato)) {
        //         $stmt->bindParam(":" . $campos[$i], $dato, PDO::PARAM_INT);
        //         echo 'int';
        //     } else {
        //         $stmt->bindParam(":" . $campos[$i], $dato, PDO::PARAM_STR);
        //         echo 'str';
        //     }
        //     echo '</pre>';
        //     $i++;
        // }
        // echo strval($stmt);
        if($stmt -> execute()){
            return "ok";
        }else{
            print_r(Conexion::conectar()->errorInfo());
        }     
    }

    static public function mdlSelecReg($tabla, $atributo, $valor){
        if($atributo==null && $valor==null){
            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");
            $stmt->execute();
            return $stmt->fetchAll();
        }
        
    }
}

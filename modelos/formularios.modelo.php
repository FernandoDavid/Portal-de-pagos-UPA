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
        if($stmt -> execute()){
            return "ok";
        }else{
            print_r(Conexion::conectar()->errorInfo());
        }     
    }    

    static public function mdlSelecReg($tabla,$atributo,$valor){
        if($atributo==null && $valor==null){
            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");
        }else{
            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $atributo = :$atributo");
            if(is_numeric($valor)){
                $stmt -> bindParam(":".$atributo,$valor,PDO::PARAM_INT);
            }else{
                $stmt -> bindParam(":".$atributo,$valor,PDO::PARAM_STR);
            }
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }
        
    static public function mdlSeleccionarId($tabla,$valores){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE correo = :correo AND idCurso = :idCurso");
        $stmt -> bindParam(":correo",$valores["correo"], PDO::PARAM_STR);
        $stmt -> bindParam(":idCurso",$valores["idCurso"], PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt->fetch();
    }
}

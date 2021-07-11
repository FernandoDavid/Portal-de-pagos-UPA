<?php

require_once "conexion.php";

class ModeloFormularios
{
    //Seleccionar un registro de cualquier trabla
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
    //Seleccionar registro que concuerde con el correo y curso 
    static public function mdlSeleccionarId($tabla,$valores){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE correo = :correo AND idCurso = :idCurso");
        $stmt -> bindParam(":correo",$valores["correo"], PDO::PARAM_STR);
        $stmt -> bindParam(":idCurso",$valores["idCurso"], PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt->fetch();
    }
    //Borrar un registrode cualquier tabla
    static public function mdlBorrarRegistro($tabla, $campoId, $valorId){
        $stmt=Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $campoId=:id");
        $stmt->bindParam(":id",$valorId,PDO::PARAM_INT);
        if($stmt->execute()){
            return "ok";
        }else{
            print_r(Conexion::conectar()->errorInfo());
        }
    }


    ////////////////////////ALUMNOS///////////////////////////////////
    //Inserta registro de alumnos
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
    
    //Modificar el registro de un alumno
    static public function mdlModificarRegistro($tabla, $campos, $datos, $id){    
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET idCurso=:idCurso, nombre=:nombre, correo=:correo, telefono=:telefono, direc=:direc, curp=:curp, rfc=:rfc, sexo=:sexo, est_civil=:est_civil WHERE idInscrito=$id");
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
    //Insertar valor del comporbante de pago de un alumno
    static public function mdlComprobante($tabla, $valor, $id){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET pago=:pago WHERE idInscrito=:idInscrito");
        $stmt->bindParam(":pago",$valor, PDO::PARAM_STR);
        $stmt->bindParam(":idInscrito",$id,PDO::PARAM_INT);
        if($stmt -> execute()){
            return "ok";
        }else{
            print_r(Conexion::conectar()->errorInfo());
        }
    }

    static public function mdlSelecComprobante($tabla, $datos){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idInscrito=:idInscrito AND idCurso=:idCurso");
        $stmt -> bindParam(":idInscrito", $datos["idInscrito"], PDO::PARAM_INT);
        $stmt -> bindParam(":idCurso", $datos["idCurso"], PDO::PARAM_INT);
        $stmt -> execute();
        return $stmt->fetch();
    }

    static public function mdlRevisarComprobante($campo,$idInscrito,$idCurso){
        $query = "UPDATE inscritos SET $campo=1 WHERE idInscrito=:idInscrito AND idCurso=:idCurso";
        $stmt = Conexion::conectar()->prepare($query);
        $stmt -> bindParam(":idInscrito",$idInscrito,PDO::PARAM_INT);
        $stmt -> bindParam(":idCurso",$idCurso,PDO::PARAM_INT);
        if($stmt -> execute()){
            return "ok";
        }else{
            print_r(Conexion::conectar()->errorInfo());
        }
    }

    ////////////////////////////////CURSOS//////////////////////////////
    //Modelo para registrar curso
    static public function mdlRegistrarCurso($tabla, $datos){
        $fec_inicio=date_format(date_create($datos["fec_inicio"]), "Y-m-d");
        $fec_fin=date_format(date_create($datos["fec_fin"]), "Y-m-d");
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(`curso`,`desc`,`instructor`,`fec_inicio`,`fec_fin`,`hora_inicio`,`hora_fin`,`cupo`,`status`,`precio`,`lugar`) VALUES (:curso, :descrip, :instructor, :fec_inicio, :fec_fin, :hora_inicio, :hora_fin, :cupo, 1, :precio, :lugar)");
        $stmt->bindParam(":curso", $datos["curso"], PDO::PARAM_STR);
        $stmt->bindParam(":descrip", $datos["desc"], PDO::PARAM_STR);
        $stmt->bindParam(":instructor", $datos["instructor"], PDO::PARAM_STR);
        $stmt->bindParam(":fec_inicio", $fec_inicio, PDO::PARAM_STR);
        $stmt->bindParam(":fec_fin", $fec_fin, PDO::PARAM_STR);
        $stmt->bindParam(":hora_inicio", $datos["hora_inicio"], PDO::PARAM_STR);
        $stmt->bindParam(":hora_fin", $datos["hora_fin"], PDO::PARAM_STR);
        $stmt->bindParam(":cupo", $datos["cupo"], PDO::PARAM_STR);
        $stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
        $stmt->bindParam(":lugar", $datos["lugar"], PDO::PARAM_STR);
        if($stmt -> execute()){
            return "ok";
        }else{
            print_r(Conexion::conectar()->errorInfo());
        }     
    }
    //Modelo para modificar curso
    static public function mdlModificarCurso($tabla, $datos, $id){
        $fec_inicio=date_format(date_create($datos["fec_inicio"]), "Y-m-d");
        $fec_fin=date_format(date_create($datos["fec_fin"]), "Y-m-d");
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET curso=:curso, `desc`=:descrip, instructor=:instructor, fec_inicio=:fec_inicio, fec_fin=:fec_fin, hora_inicio=:hora_inicio, hora_fin=:hora_fin, cupo=:cupo, `status`=:stat, precio=:precio, lugar=:lugar where idCurso=$id");
        $stmt->bindParam(":curso", $datos["curso"], PDO::PARAM_STR);
        $stmt->bindParam(":descrip", $datos["desc"], PDO::PARAM_STR);
        $stmt->bindParam(":instructor", $datos["instructor"], PDO::PARAM_STR);
        $stmt->bindParam(":fec_inicio", $fec_inicio, PDO::PARAM_STR);
        $stmt->bindParam(":fec_fin", $fec_fin, PDO::PARAM_STR);
        $stmt->bindParam(":hora_inicio", $datos["hora_inicio"], PDO::PARAM_STR);
        $stmt->bindParam(":hora_fin", $datos["hora_fin"], PDO::PARAM_STR);
        $stmt->bindParam(":cupo", $datos["cupo"], PDO::PARAM_STR);
        $stmt->bindParam(":stat", $datos["status"], PDO::PARAM_INT);
        $stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
        $stmt->bindParam(":lugar", $datos["lugar"], PDO::PARAM_STR);
        if($stmt -> execute()){
            return "ok";
        }else{
            print_r(Conexion::conectar()->errorInfo());
        }     
    }

    static public function mdlVerificarCupo($idCurso, $mode){
        //Traer el cupo total de un curso
        if($mode==0){
            $stmt = Conexion::conectar()->prepare("SELECT cupo, fec_inicio, fec_fin from Cursos where idCurso=$idCurso");
        }
        //Cantidad de alumnos inscritos a un curso
        else if($mode==1){
            $stmt = Conexion::conectar()->prepare("SELECT COUNT(i.idInscrito) as cuenta FROM Inscritos i INNER JOIN Cursos c ON i.idCurso=c.idCurso where c.idCurso=$idCurso");
        }
        $stmt -> execute();
        return $stmt->fetch();
    }

}

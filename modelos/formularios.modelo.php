<?php

require_once "conexion.php";

class ModeloFormularios
{
    //Seleccionar un registro(s)
    static public function mdlSelecReg($tabla,$campos=null,$datos=null){
        if($campos==null && $datos==null){
            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");
        }else{
            $strIf = "";
            foreach($campos as $key=>$campo){
                $strIf = $strIf."`$campo`=:$campo AND ";
            }
            $query = "SELECT * FROM $tabla WHERE ".substr($strIf,0,-5);
            $stmt=Conexion::conectar()->prepare($query);
            foreach($datos as $key=>&$dato){
                if(is_numeric($dato)){
                    $stmt -> bindParam(":".$key,$dato,PDO::PARAM_INT);
                }else{
                    $stmt -> bindParam(":".$key,$dato,PDO::PARAM_STR);
                }
            }
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    //Borrar registro
    static public function mdlBorrarRegistro($tabla, $campoId, $valorId){
        $stmt=Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $campoId=:id");
        $stmt->bindParam(":id",$valorId,PDO::PARAM_INT);
        if($stmt->execute()){
            return "ok";
        }else{
            print_r(Conexion::conectar()->errorInfo());
        }
    }

    //Inserta registro
    static public function mdlCrearRegistro($tabla, $campos, $datos)
    {
        $strCampos = '`' . implode('`,`', $campos) . '`';
        $strValues = ':' . implode(', :', $campos);
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla($strCampos) VALUES ($strValues)");
        foreach($datos as $key=>&$dato){
            if(is_int($dato)){
                $stmt->bindParam(":".$key,$dato,PDO::PARAM_INT);
            }else{
                $stmt->bindParam(":".$key,$dato,PDO::PARAM_STR);
            }
        }
        if($stmt -> execute()){
            return "ok";
        }else{
            print_r(Conexion::conectar()->errorInfo());
        }     
    }    
    
    //Modificar registro
    static public function mdlModificarRegistro($tabla, $campos, $datos, $id){
        $strSet = "";
        foreach($campos as $key=>$campo){
            $strSet = $strSet."`$campo`=:$campo,";
        }
        $query = "UPDATE $tabla SET ".substr($strSet,0,-1)." WHERE ".array_keys($id)[0]."=:".array_keys($id)[0];
        $stmt = Conexion::conectar()->prepare($query);
        foreach($datos as $key=>&$dato){
            if(is_int($dato)){
                $stmt->bindParam(":".$key,$dato,PDO::PARAM_INT);
            }else{
                $stmt->bindParam(":".$key,$dato,PDO::PARAM_STR);
            }
        }
        $stmt->bindParam(":".array_keys($id)[0],$id[array_keys($id)[0]],PDO::PARAM_INT);
        if($stmt -> execute()){
            return "ok";
        }else{
            print_r(Conexion::conectar()->errorInfo());
        } 
    }

    //////////////////////////////CURSOS//////////////////////////////
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

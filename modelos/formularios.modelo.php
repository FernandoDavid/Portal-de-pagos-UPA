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
        $query = "INSERT INTO $tabla($strCampos) VALUES ($strValues)";
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
    static public function mdlVerificarCupo($idCurso){
        $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) FROM pagos pag INNER JOIN participantes par ON pag.idParticipante=par.idParticipante INNER JOIN cursos c ON par.idCurso=c.idCurso WHERE pag.comprobante<>'' AND c.idCurso=$idCurso");
        $stmt -> execute();
        return $stmt->fetch();
    }

    static public function mdlSelecRango($tabla,$campo,$inicio,$fin){
        $query = "SELECT * FROM $tabla WHERE $campo BETWEEN :fec_inicio AND :fec_fin";
        $stmt=Conexion::conectar()->prepare($query);
        $stmt -> bindParam(":fec_inicio",$inicio,PDO::PARAM_STR);
        $stmt -> bindParam(":fec_fin",$fin,PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function mdlSelecCoincidencias($coincidencia,$campo,$if){
        $query = "SELECT * FROM Participantes p INNER JOIN Cursos c ON p.idCurso=c.idCurso INNER JOIN Pagos pg ON p.idParticipante=pg.idParticipante WHERE (p.nombre LIKE '%$coincidencia%' OR p.correo LIKE '%$coincidencia%' OR p.curp LIKE '%$coincidencia%' OR c.curso LIKE '%$coincidencia%') AND pg.$campo=:rev";
        $stmt=Conexion::conectar()->prepare($query);
        $stmt -> bindParam(":rev",$if,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}

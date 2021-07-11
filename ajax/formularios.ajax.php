<?php
require_once "../controladores/formularios.controlador.php";
require_once "../modelos/formularios.modelo.php";

class AjaxFormularios
{
    /*=====================================
    COMPROBANTE
    ======================================*/
    public $idInscrito;
    public $idCurso;

    /*=====================================
    FillData
    ======================================*/
    public $id;
    public $tabla;
    public $item;

    public function ajaxSelectData(){
        $id = $this->id;
        $tabla = $this->tabla;
        $item = $this->item;
        $res = ControladorFormularios::ctrSelectData($tabla,$item,$id);
        echo json_encode($res[0]);
    }

    public function ajaxComprobante(){
        $inscrito = $this->idInscrito;
        $curso = $this->idCurso;
        $src = ControladorFormularios::ctrSelecComprobante($inscrito,$curso);
        echo json_encode($src);
    }
}

if(isset($_POST["idInscrito"])){
    $img = new AjaxFormularios();
    $img -> idInscrito = $_POST["idInscrito"];
    $img -> idCurso = $_POST["idCurso"];
    $img -> ajaxComprobante();
}

if(isset($_POST["idFD"]) && isset($_POST["tablaFD"]) && isset($_POST["itemFD"])){
    $data = new AjaxFormularios();
    $data -> id = $_POST["idFD"];
    $data -> tabla = $_POST["tablaFD"];
    $data -> item = $_POST["itemFD"];
    $data -> ajaxSelectData();
}
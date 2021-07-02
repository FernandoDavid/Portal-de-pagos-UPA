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
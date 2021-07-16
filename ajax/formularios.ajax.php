<?php
require_once "../controladores/formularios.controlador.php";
require_once "../modelos/formularios.modelo.php";

class AjaxFormularios
{
    /*=====================================
    FillData
    ======================================*/
    public $datos;
    public $tabla;
    public $campos;

    public function ajaxSelectData(){
        $campos = $this->campos;
        $tabla = $this->tabla;
        $datos = $this->datos;
        $res = ModeloFormularios::mdlSelecReg($tabla,$campos,$datos);
        echo json_encode($res[0]);
    }

}

if(isset($_POST["dato"]) && isset($_POST["tabla"]) && isset($_POST["campo"])){
    $data = new AjaxFormularios();
    $dat = array($_POST["campo"]=>$_POST["dato"]);
    $data -> datos = $dat;
    $data -> tabla = $_POST["tabla"];
    $data -> campos = array_keys($dat);
    $data -> ajaxSelectData();
}
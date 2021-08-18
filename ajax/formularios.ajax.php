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
    public $tipo;

    public $id;

    public $coincidencia;
    public $campo;
    public $if;

    public function ajaxSelectData(){
        $campos = $this->campos;
        $tabla = $this->tabla;
        $datos = $this->datos;
        $res = ModeloFormularios::mdlSelecReg($tabla,$campos,$datos);
        echo json_encode($res[0]);
    }

    public function ajaxDeleteSrc(){
        $tabla = $this->tabla;
        $campos = $this->campos;
        $datos = $this->datos;
        $tipo = $this->tipo;
        $res = ModeloFormularios::mdlSelecReg($tabla,$campos,$datos);
        echo json_encode($res[0]);
        if($tipo=="flyer"){
            unlink('../vistas/img/flyers/'.$res[0]["flyer"]);
        }else{
            unlink('../vistas/img/banners/'.$res[0]["banner"]);
        }
    }

    public function ajaxLiveSearch(){
        $coincidencia = $this->coincidencia;
        $campo = $this->campo;
        $if = $this->if;
        $res = ModeloFormularios::mdlSelecCoincidencias($coincidencia,$campo,$if);
        echo json_encode($res);
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

if(isset($_POST["key"]) && isset($_POST["tipo"])){
    $data = new AjaxFormularios();
    // $tipo = explode('-',$_POST["key"]);
    $dat = array("idCurso"=>$_POST["key"]);
    $data -> tabla = "Cursos";
    $data -> tipo = $_POST["tipo"];
    $data -> datos = $dat;
    $data -> campos = array_keys($dat);
    $data -> ajaxDeleteSrc();
}

if(isset($_POST["coincidencia"])){
    $data = new AjaxFormularios();

    $data -> coincidencia = $_POST["coincidencia"];
    $data -> campo = $_POST["campo"];
    $data -> if = intval($_POST["if"]);

    $data -> ajaxLiveSearch();
}
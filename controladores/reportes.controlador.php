<?php
use \PhpOffice\PhpSpreadsheet\SpreadSheet;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use \PhpOffice\PhpSpreadsheet\Style\Fill;
use \PhpOffice\PhpSpreadsheet\Style\Border;
use \PhpOffice\PhpSpreadsheet\Style\Alignment;

use \PhpOffice\PhpWord\TemplateProcessor;

class ControladorReportes
{
    public static function ctrSubscritos()
    {
        if(isset($_POST["subs"])){
            $spreadsheet = IOFactory::load('controladores/plantillas/plantilla_subscritos.xls');
            $spreadsheet->getProperties()->setCreator("Cursos UPA")->setTitle("Alumnos subscritos");
            $spreadsheet->setActiveSheetIndex(0);
            $activeSheet = $spreadsheet->getActiveSheet();

            $styles_v1 = [
                'borders' => [
                    'inside' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => [ 'argb' => 'FFFFFFFF']
                    ]
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [ 'argb' => 'FF4472C4' ]
                ],
                'font' => [
                    'color' => [ 'argb' => 'FFFFFFFF' ]
                ]
            ];
            
            $activeSheet->getStyle('A1:C1')->applyFromArray($styles_v1);            

            $datos = array(
                "subs" => 1
            );
            $res = ModeloFormularios::mdlSelecReg("Participantes", array_keys($datos), $datos);
            foreach($res as $key=>$alumno){
                $activeSheet->setCellValue('A'.$key+2, $alumno["correo"]);
                $activeSheet->setCellValue('B'.$key+2, $alumno["nombre"]);  
                $activeSheet->setCellValue('C'.$key+2, $alumno["telefono"]);
                $activeSheet->getStyle('C'.$key+2)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                if($key%2==0){
                    $activeSheet->getStyle('A'.($key+2).':C'.($key+2))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD9E1F2');
                }else{
                    $activeSheet->getStyle('A'.($key+2).':C'.($key+2))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFB4C6E7');
                }
                $activeSheet->getStyle('A'.($key+2).':C'.($key+2))->getBorders()->getInside()->setBorderStyle(Border::BORDER_THIN)->getColor()->setARGB('FFFFFFFF');
                $lastRow = $key+2;
            }

            $activeSheet->getStyle('A1:C'.$lastRow)->getAlignment()->setWrapText(true);

            ob_end_clean();
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Alumnos subscritos.xls"');
            header('Cache-Control: max-age=0');

            $writer = IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save('php://output');
        }
    }

    public static function ctrRegistro($idCurso){
        $template = new TemplateProcessor('controladores/plantillas/plantilla_ficha_tecnica.docx');
        
        $id = ["idCurso"=>$idCurso];
        $curso = ModeloFormularios::mdlSelecReg("Cursos", array_keys($id), $id);

        $dia = '';
        switch($curso[0]['dia']){
            case "lunes": $dia="Lunes";break;
            case "martes": $dia="Martes";break;
            case "miercoles": $dia="Miércoles";break;
            case "jueves": $dia="Jueves";break;
            case "viernes": $dia="Viernes";break;
            case "sabado": $dia="Sábados";break;
        }

        $template->setValues([
            'curso'=>$curso[0]['curso'],
            'fec_inicio'=>$curso[0]['fec_inicio'],
            'fec_fin'=>$curso[0]['fec_fin'],
            'dia'=>$dia,
            'hora_inicio'=>$curso[0]['hora_inicio'],
            'hora_fin'=>$curso[0]['hora_fin'],
            'aula'=>$curso[0]['aula'],
            'modalidad'=>($curso[0]['modalidad']==1)? "En línea" : "Presencial"
        ]);

        $pathToSave = 'controladores/docs/ft-'.$curso[0]["idCurso"].'.docx';
        $template->saveAs($pathToSave);
    }

    public static function ctrInscrito($idCurso){
        $template = new TemplateProcessor('controladores/plantillas/plantilla_bienvenida_curso.docx');
        
        $id = ["idCurso"=>$idCurso];
        $curso = ModeloFormularios::mdlSelecReg("Cursos", array_keys($id), $id);

        $dia = '';
        switch($curso[0]['dia']){
            case "lunes": $dia="Lunes";break;
            case "martes": $dia="Martes";break;
            case "miercoles": $dia="Miércoles";break;
            case "jueves": $dia="Jueves";break;
            case "viernes": $dia="Viernes";break;
            case "sabado": $dia="Sábados";break;
        }

        $aviso = "Les recordamos que es indispensable la instalación del software para poder manejar las actividades que se llevarán a cabo en el curso.";
        $tem = explode("|||",$curso[0]["temario"]);

        $template->setValues([
            'curso'=>$curso[0]['curso'],
            'objetivo'=>$curso[0]["objetivo"],
            'fec_inicio'=>$curso[0]['fec_inicio'],
            'fec_fin'=>$curso[0]['fec_fin'],
            'dia'=>$dia,
            'aviso'=>$aviso,
            'temario'=>$tem[0],
            'recursos'=>$tem[1],
            'materiales'=>$tem[2],
            'hora_inicio'=>$curso[0]['hora_inicio'],
            'hora_fin'=>$curso[0]['hora_fin'],
            'aula'=>$curso[0]['aula'],
            'modalidad'=>($curso[0]['modalidad']==1)? "En línea" : "Presencial"
        ]);

        $pathToSave = 'controladores/docs/bc-'.$curso[0]["idCurso"].'.docx';
        $template->saveAs($pathToSave);
    }

    public static function ctrIngresos(){
        if(isset($_POST["ingresos"])){
            $spreadsheet = IOFactory::load('controladores/plantillas/plantilla_ingresos.xls');
            $spreadsheet->getProperties()->setCreator("Cursos UPA")->setTitle("Ingresos");
            $spreadsheet->setActiveSheetIndex(0);
            $activeSheet = $spreadsheet->getSheet(0);
            $rfcSheet = $spreadsheet->getSheet(1);

            $styles_v1 = [
                'borders' => [
                    'inside' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => [ 'argb' => 'FFFFFFFF']
                    ]
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [ 'argb' => 'FF4472C4' ]
                ],
                'font' => [
                    'color' => [ 'argb' => 'FFFFFFFF' ]
                ]
            ];

            $activeSheet->getStyle('A1:J1')->applyFromArray($styles_v1); 
            $rfcSheet->getStyle('A1:E1')->applyFromArray($styles_v1);
            $participantes = ModeloFormularios::mdlSelecReg("Participantes");
            $lastRow = [1,2];

            foreach($participantes as $key=>$participante){
                $idCurso = ["idCurso"=>$participante["idCurso"]];
                $idParticipante = ["idParticipante"=>$participante["idParticipante"]];
                $pago = ModeloFormularios::mdlSelecReg("Pagos", array_keys($idParticipante), $idParticipante);
                $curso = ModeloFormularios::mdlSelecReg("Cursos", array_keys($idCurso), $idCurso);
                $factura = ModeloFormularios::mdlSelecReg("Facturas", array_keys($idParticipante), $idParticipante);
                $row = [
                    "participante"=>$participante["nombre"],
                    "curso"=>$curso[0]["curso"],
                    "factura"=>(isset($factura[0]["rfc"]))? "Si" : "No",
                    "genero"=>($participante["sexo"]=="H")? "Masculino" : "Femenino",
                    "validado"=>($pago[0]["r2"]==1)? "Si" : "No",
                    "tipo"=>($curso[0]["tipo"]==1)? "Curso" : "Diplomado",
                    "curp"=>$participante["curp"],
                    "rfc"=>(isset($factura[0]["rfc"]))? $factura[0]["rfc"] : null,
                    "subtot"=>floatval($pago[0]["pago"]*(1-intval($pago[0]["desc"])/100)),
                    "fec_rev"=>$pago[0]["fec_r2"]
                ];

                if(isset($factura[0]["rfc"])){
                    $record = [
                        "participante"=>$participante["nombre"],
                        "curp"=>$participante["curp"],
                        "rfc"=>$factura[0]["rfc"],
                        "cfdi"=>$factura[0]["cfdi"],
                        "obs"=>$factura[0]["obs"]
                    ];
                    if($lastRow[1]%2==0){
                        $rfcSheet->getStyle('A'.($lastRow[1]).':E'.($lastRow[1]))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD9E1F2');
                    }else{
                        $rfcSheet->getStyle('A'.($lastRow[1]).':E'.($lastRow[1]))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFB4C6E7');
                    }
                    $rfcSheet->getStyle('A'.$lastRow[1].':E'.$lastRow[1])->getBorders()->getInside()->setBorderStyle(Border::BORDER_THIN)->getColor()->setARGB('FFFFFFFF');
                    $rfcSheet->fromArray($record,null,'A'.$lastRow[1]);
                    $lastRow[1]++;
                }

                // $activeSheet->getStyle('C'.$key+2)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                if($key%2==0){
                    $activeSheet->getStyle('A'.($key+2).':J'.($key+2))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD9E1F2');
                }else{
                    $activeSheet->getStyle('A'.($key+2).':J'.($key+2))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFB4C6E7');
                }
                $activeSheet->getStyle('A'.($key+2).':J'.($key+2))->getBorders()->getInside()->setBorderStyle(Border::BORDER_THIN)->getColor()->setARGB('FFFFFFFF');

                $lastRow[0] = $key+2;
                $activeSheet->fromArray($row,null,'A'.$lastRow[0]);
            }
            $activeSheet->getStyle('A1:J'.$lastRow[0])->getAlignment()->setWrapText(true);
            $rfcSheet->getStyle('A1:E'.$lastRow[1])->getAlignment()->setWrapText(true);

            ob_end_clean();
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Ingresos.xls"');
            header('Cache-Control: max-age=0');

            $writer = IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save('php://output');
        }
    }
}
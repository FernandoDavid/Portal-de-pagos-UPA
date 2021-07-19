<?php
use \PhpOffice\PhpSpreadsheet\SpreadSheet;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use \PhpOffice\PhpSpreadsheet\Style\Fill;
use \PhpOffice\PhpSpreadsheet\Style\Border;
use \PhpOffice\PhpSpreadsheet\Style\Alignment;

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
            $res = ModeloFormularios::mdlSelecReg("inscritos", array_keys($datos), $datos);
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
}
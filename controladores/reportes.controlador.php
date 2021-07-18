<?php

use \PhpOffice\PhpSpreadsheet\SpreadSheet;
use \PhpOffice\PhpSpreadsheet\IOFactory;

class ControladorReportes
{
    public static function ctrSubscritos()
    {
        $spreadsheet = new SpreadSheet();
        $spreadsheet->getProperties()->setCreator("Cursos UPA")->setTitle("Alumnos subscritos");

        $spreadsheet->setActiveSheetIndex(0);
        $activeSheet = $spreadsheet->getActiveSheet();

        $datos = array(
            "subs" => 1
        );
        $res = ModeloFormularios::mdlSelecReg("inscritos", array_keys($datos), $datos);
        echo '<pre>';
        echo '$res: ';
        var_dump($res);
        echo '</pre>';

        $activeSheet->setCellValue('A1', "Test excel");

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Alumnos subscritos.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}

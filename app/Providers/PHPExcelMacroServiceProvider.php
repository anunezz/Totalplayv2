<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
Use \Maatwebsite\Excel\Sheet;
use \Maatwebsite\Excel\Writer;

class PHPExcelMacroServiceProvider extends ServiceProvider {

    public function boot() {

        Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        });

        Sheet::macro('autoFilter', function (Sheet $sheet, string $cellRange) {
            $sheet->getDelegate()->setAutoFilter($cellRange);
        });

        Sheet::macro('rowHeight', function (Sheet $sheet, string $row, int $height) {
            $sheet->getDelegate()->getRowDimension($row)->setRowHeight($height);
        });

        Sheet::macro('wrapText', function (Sheet $sheet, string $cellRange) {
            $sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
        });

        Sheet::macro('setAutoSize', function (Sheet $sheet) {
            $sheet->getDelegate()->getDefaultColumnDimension()->setAutoSize(true);
        });

        Sheet::macro('mergeCells', function (Sheet $sheet, string $cellRange) {
            $sheet->getDelegate()->mergeCells($cellRange);
        });

        Sheet::macro('setValue', function (Sheet $sheet, string $cell, string $value) {
            $sheet->getDelegate()->getCell($cell)->setValue($value);
        });

        Sheet::macro('setFormat', function (Sheet $sheet, string $cellRange, string $format) {
            $sheet->getDelegate()->getStyle($cellRange)->getNumberFormat()->setFormatCode($format);
        });

        Sheet::macro('textRotation', function (Sheet $sheet, string $cellRange, int $degrees) {
            $sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setTextRotation($degrees);
        });
    }


    public function register()
    {
        //
    }
}

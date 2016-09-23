<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Excel
 *
 * @author admin
 */
namespace backend\components;

use backend\models\Currency;
use common\components\Number;
use common\modules\i18n\Module;
use yii\base\ErrorException;
use yii\helpers\ArrayHelper;

class Excel extends \yii\base\Component
{
    /**
     * Styles array for excel page
     * @var array
     */
    private $styles;

    /**
     * Number format for cells
     * @var string */
    private $numberFormat;

    /**
     * Percentage format for cells
     * @var string */
    private $percentageFormat;

    /**
     * Price format for cells
     * @var string */
    private $priceFormat;

    /**
     * Excel constructor.
     * @param array $config
     */
    public function __construct($config = array())
    {
        parent::__construct($config);
        $this->styles = [
            'bold'          => [
                'font' => [
                    'bold' => true,
                ]
            ],
            'border-bottom' => [
                'borders' => [
                    'bottom' => [
                        'style' => \PHPExcel_Style_Border::BORDER_THIN,
                        'color' => [
                            'rgb' => '000000'
                        ]
                    ]
                ]
            ],
            'border-top'    => [
                'borders' => [
                    'top' => [
                        'style' => \PHPExcel_Style_Border::BORDER_THIN,
                        'color' => [
                            'rgb' => '000000'
                        ]
                    ]
                ]
            ]
        ];
        $this->numberFormat = \PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1;
        $this->percentageFormat = \PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE;
        $this->priceFormat = Currency::getDefaultCurrency()->sign . ' #,##0.00_-';
    }

    /**
     * Get the array from Excel file
     * @param $file
     * @return array
     * @throws \PHPExcel_Reader_Exception
     */
    public function getFromFile($file)
    {
        $inputFileType = \PHPExcel_IOFactory::identify($file);
        $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($file);
        $worksheet = $objPHPExcel->getActiveSheet();
        $response = array();
        foreach ($worksheet->getRowIterator() as $row) {
            $line = array();
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            foreach ($cellIterator as $cell) {
                $line[] = $cell->getValue();
            }
            if (!empty($line)) {
                $response[] = $line;
            }
        }
        return $response;
    }

    /**
     * Generate the excel file from given array
     * @param array $data
     * @param string $filename
     * @param bool $debug
     * @return string
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    public function generateFromArray($data, $filename, $debug = false)
    {
        $objPHPExcel = new \PHPExcel();
        $cacheSettings = array(' memoryCacheSize ' => '8MB');
        $cacheMethod = \PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        \PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setDescription("Delivery document");
        $objPHPExcel->getActiveSheet()->fromArray($data, null, 'A1');
        $alphabet = range('A', 'Z');
        foreach ($alphabet as $key => $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(20);
        }
        for ($i = 1; $i < count($data) + 1; $i++) {
            $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(15);
        }
        $objPHPExcel->getActiveSheet()->setAutoFilter('A1:E1');
        $writer = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        if ($debug) {
            header('Content-type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        } else {
            $path_to_file = FILE_PATH . "/ringostat/" . $filename;
            $this->writeDocument($objPHPExcel, $path_to_file);
            return $path_to_file;
        }
    }

    /**
     * Generate total array (become an outdated mechanism)
     * @param $data
     * @throws \PHPExcel_Exception
     */
    public function generateReportTotal($data)
    {
        $objPHPExcel = new \PHPExcel();
        $this->initObject($objPHPExcel);
        $aSheet = $objPHPExcel->getActiveSheet();
        $startRow = 1;
        $startRowFixed = $startRow;
        $headerWidthCells = 3;
        $offsetRow = 3;
        /**
         * Headers generation and styling
         */
        $columnIndex = 0;
        $columnByTypes = [];
        foreach ($data['headers'] as $column => $bullionType) {
            $columnIndex = $column * $headerWidthCells + 1;
            $aSheet->setCellValueByColumnAndRow($columnIndex, $startRow, $bullionType->name);
            $columnString = \PHPExcel_Cell::stringFromColumnIndex($column * $headerWidthCells + 1);
            $aSheet->getStyle($columnString . $startRow)->applyFromArray($this->styles['bold']);
        }
        for ($i = 0; $i < $columnIndex + 4; $i++) {
            $columnString = \PHPExcel_Cell::stringFromColumnIndex($i);
            $aSheet->getColumnDimension($columnString)->setAutoSize(true);
        }
        $startColumn = \PHPExcel_Cell::stringFromColumnIndex(0);
        $endColumn = \PHPExcel_Cell::stringFromColumnIndex($columnIndex + 3);
        $style = $this->getBorderStyle('bottom', [
            'style' => \PHPExcel_Style_Border::BORDER_THICK
        ]);
        $aSheet->getStyle($startColumn . $startRow . ":" . $endColumn . $startRow)->applyFromArray($style);
        /** Main rows generation */
        $startRow += 2;
        foreach ($data['rows'] as $rowKey => $row) {
            foreach ($row as $column => $cellData) {
                $cellValue = $this->formatCell($cellData, $aSheet, $column, $startRow);
                $aSheet->setCellValueByColumnAndRow($column, $startRow, $cellValue);
            }
            $startColumn = \PHPExcel_Cell::stringFromColumnIndex(0);
            $endColumn = \PHPExcel_Cell::stringFromColumnIndex(count($row) - 2);
            if ($rowKey != count($data['rows']) - 1) {
                $aSheet->getStyle($startColumn . $startRow . ":" . $endColumn . $startRow)->applyFromArray($this->styles['border-bottom']);
            } else {
                $endColumn = \PHPExcel_Cell::stringFromColumnIndex(count($row));
                $style = $this->getBorderStyle('top', [
                    'style' => \PHPExcel_Style_Border::BORDER_THICK
                ]);
                $aSheet->getStyle($startColumn . $startRow . ":" . $endColumn . $startRow)->applyFromArray($style);
            }

            $startRow += $offsetRow;
        }
        /** Styling lines */
        for ($i = 0; $i < count($data['headers']) + 1; $i++) {
            $columnIndex = $i * $headerWidthCells + 1;
            $columnString = \PHPExcel_Cell::stringFromColumnIndex($columnIndex);
            $style = $this->getBorderStyle('left', [
                'style' => \PHPExcel_Style_Border::BORDER_THICK
            ]);
            $aSheet->getStyle($columnString . $startRowFixed . ":" . $columnString . ($startRow - $offsetRow))->applyFromArray($style);
        }

        /** Subtotal rows generating */
        $startRow += 2;
        foreach ($data['subtotalRows'] as $row) {
            foreach ($row as $column => $cellData) {
                $cellValue = $this->formatCell($cellData, $aSheet, $column, $startRow);
                $aSheet->setCellValueByColumnAndRow($column, $startRow, $cellValue);
            }
            $startRow += 1;
        }

        /** Total rows generating */
        $startRow += 1;
        foreach ($data['totalRows'] as $row) {
            foreach ($row as $column => $cellData) {
                $cellValue = $this->formatCell($cellData, $aSheet, $column, $startRow);
                $aSheet->setCellValueByColumnAndRow($column, $startRow, $cellValue);
            }
            $startRow += 1;
        }
        /** Insert bar graph */
        $objDrawing = new \PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath($data['barGraph']);
        $objDrawing->setCoordinates('A' . ($startRow + 2));
        $objDrawing->setWorksheet($aSheet);

        $aSheet->getStyle('A' . $startRowFixed . ":" . 'A' . $startRow)->applyFromArray($this->styles['bold']);
        for ($i = $startRowFixed; $i < $startRow; $i++) {
            $aSheet->getRowDimension($i)->setRowHeight(-1);
        }
        $this->writeObject($objPHPExcel, "Test.xls");
    }

    /**
     * Initiating the PHPExcel object with default values
     * @param $objPHPExcel
     */
    private function initObject($objPHPExcel)
    {
        $cacheSettings = array(' memoryCacheSize ' => '8MB');
        $cacheMethod = \PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        \PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setDescription(Module::t("Report document"));
    }

    /**
     * @param string $borderType
     * @param array $data
     * @return array
     */
    private function getBorderStyle($borderType, $data = [])
    {
        $default = array_key_exists($borderType, $this->styles) ? $this->styles[$borderType] : [];
        return ArrayHelper::merge($default, [
            'borders' => [
                $borderType => $data
            ]
        ]);
    }

    /**
     * @param $cellData
     * @param $aSheet
     * @param $column
     * @param $row
     * @return mixed
     */
    private function formatCell($cellData, $aSheet, $column, $row)
    {
        if (!is_array($cellData)) {
            return $cellData;
        }
        $value = $cellData['value'];
        $column = \PHPExcel_Cell::stringFromColumnIndex($column);
        if (array_key_exists('format', $cellData) && !empty($cellData['format'])) {
            $format = $cellData['format'];
            $aSheet->getStyle($column . $row)->getNumberFormat()->setFormatCode($this->{$format});
        }
        if (array_key_exists('styleCallback', $cellData)) {
            $callback = '_callback' . $cellData['styleCallback'];
            if (method_exists($this, $callback)) {
                $this->{$callback}($aSheet, $column, $row);
            }
        }
        return $value;
    }

    /**
     * @param $objPHPExcel
     * @param $filename
     * @param string $path
     * @throws \PHPExcel_Reader_Exception
     */
    private function writeObject($objPHPExcel, $filename, $path = '')
    {
        $writer = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        if (empty($path)) {
            header('Content-type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        }

    }

    /**
     * Set custom styles due to available
     * @param string $styleName
     * @param array $data
     * @return array
     * @throws ErrorException
     */
    private function getChangedStyle($styleName, $data)
    {
        if (array_key_exists($styleName, $this->styles)) {
            return ArrayHelper::merge($this->styles[$styleName], $data);
        } else {
            throw new ErrorException('Cannot find the specific style: ' . $styleName);
        }
    }

    /**
     * @param $aSheet
     * @param $column
     * @param $row
     */
    private function _callbackFormatTotalValue($aSheet, $column, $row)
    {
        $cell = $aSheet->getStyle($column . $row);
        $cell->getFont()->setSize(16);
        $cell->getFont()->setBold(true);
        $cell->getFont()->setItalic(true);
    }

    /**
     * @param $aSheet
     * @param $column
     * @param $row
     */
    private function _callbackFormatBold($aSheet, $column, $row)
    {
        $cell = $aSheet->getStyle($column . $row);
        $cell->getFont()->setBold(true);
    }

    /**
     * @param $aSheet
     * @param $column
     * @param $row
     */
    private function _callbackFormatTotal($aSheet, $column, $row)
    {
        $cell = $aSheet->getStyle($column . $row);
        $cell->getFont()->setSize(16);
    }

    /**
     * @param $aSheet
     * @param $column
     * @param $row
     */
    private function _callbackFormatSubTotal($aSheet, $column, $row)
    {
        $cell = $aSheet->getStyle($column . $row);
        $cell->getFont()->setItalic(true);
        $cell->getFont()->setBold(true);
    }


}

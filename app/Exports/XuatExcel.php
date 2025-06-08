<?php

namespace App\Exports;

use App\Models\YourModel; // Thay thế YourModel bằng model của bạn
use PHPExcel;
use PHPExcel_IOFactory;

class XuatExcel
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function export()
    {
        $data = YourModel::whereBetween('created_at', [$this->startDate, $this->endDate])->get();

        // Tạo một đối tượng PHPExcel
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        // Thiết lập tiêu đề cho các cột
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Tên');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Ngày tạo');

        // Điền dữ liệu vào file Excel
        $row = 2; // Bắt đầu từ dòng 2
        foreach ($data as $item) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $item->name);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $item->created_at);
            $row++;
        }

        // Đặt định dạng của file xuất ra
        $filename = 'Danhthuthang-' . $this->startDate . '.xlsx';

        // Xuất file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
}

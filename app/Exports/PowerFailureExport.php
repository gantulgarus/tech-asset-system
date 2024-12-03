<?php

namespace App\Exports;

use App\Models\PowerFailure;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PowerFailureExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $powerFailures;

    public function __construct($powerFailures)
    {
        $this->powerFailures = $powerFailures;
    }

    public function collection()
    {
        return $this->powerFailures->map(function ($failure, $index) {
            return [
                'N' => $index + 1,
                'Station' => $failure->station->name ?? '',
                'Equipment' => $failure->equipment->name ?? '',
                'failure_date' => $failure->failure_date,
                'detector_name' => $failure->detector_name,
                'failure_detail' => $failure->failure_detail,
                'notified_name' => $failure->notified_name,
                'action_taken' => $failure->action_taken,
                'fixer_name' => $failure->fixer_name,
                'inspector_name' => $failure->inspector_name,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Д/д',
            'Дэд станц',
            'Тоноглол',
            'Илрүүлсэн огноо',
            'Илрүүлсэн хүн',
            'Илэрсэн гэмтэл',
            'Гэмтлийн талаар мэдэгдсэн хүн',
            'Авсан арга хэмжээ',
            'Гэмтэл арилгасан хүн',
            'Хүлээн авсан хүн',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'D9E1F2'],
                ],
            ],
        ];
    }
}
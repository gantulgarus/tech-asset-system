<?php

namespace App\Exports;

use App\Models\PowerCut;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PowerCutExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $powerCuts;

    public function __construct($powerCuts)
    {
        $this->powerCuts = $powerCuts;
    }

    public function collection()
    {
        return $this->powerCuts->map(function ($cut, $index) {
            return [
                'N' => $index + 1,
                'Station' => $cut->station->name ?? '',
                'Equipment' => $cut->equipment->name ?? '',
                'OrderType' => $cut->orderType->name ?? '',
                'CauseCut' => $cut->cause_cut,
                'Voltage' => $cut->current_voltage,
                'Amper' => $cut->current_amper,
                'Power' => $cut->current_power,
                'Starttime' => $cut->start_time,
                'Endtime' => $cut->end_time,
                'Duration' => $cut->duration,
                'ude' => $cut->ude,
                'approved_by' => $cut->approved_by,
                'OrderNumber' => $cut->order_number,
                'created_by' => $cut->created_by,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Д/д',
            'Дэд станц',
            'Тоноглол',
            'Захиалгын төрөл',
            'Таслалтын шалтгаан',
            'U кВ',
            'I',
            'P',
            'Тасарсан',
            'Залгасан',
            'Нийт хугацаа',
            'ДТЦЭХ кВт.ц',
            'Шийдвэр өгсөн',
            'Захиалгын дугаар',
            'Бүртгэсэн',
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
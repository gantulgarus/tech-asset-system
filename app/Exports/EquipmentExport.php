<?php

namespace App\Exports;

use App\Models\Equipment;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EquipmentExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $equipments;

    public function __construct($equipments)
    {
        $this->equipments = $equipments;
    }

    public function collection()
    {
        return $this->equipments->map(function ($equipment, $index) {
            return [
                'N' => $index + 1,
                'Branch' => $equipment->branch->name ?? '',
                'Station' => $equipment->station->name ?? '',
                'Type' => $equipment->equipmentType->name ?? '',
                'Name' => $equipment->name,
                'Voltage' => $equipment->volts->pluck('name')->join('/'),
                'Year' => $equipment->mark,
                'Capacity' => $equipment->production_date,
            ];
        });
    }

    public function headings(): array
    {
        return [
            '№',
            'Салбар',
            'Дэд станц',
            'Тоноглолын төрөл',
            'ША-ны нэр',
            'Хүчдлийн түвшин',
            'Тип марк',
            'Үйлдвэрлэгдсэн он',
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

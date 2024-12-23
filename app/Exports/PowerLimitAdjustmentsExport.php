<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PowerLimitAdjustmentsExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $adjustments;

    public function __construct($adjustments)
    {
        $this->adjustments = $adjustments;
    }

    public function collection()
    {
        return $this->adjustments->map(function ($adjustment, $index) {
            return [
                'N' => $index + 1,
                'Branch' => $adjustment->branch->name ?? '',
                'Station' => $adjustment->station?->name ?? '',
                'Output_name' => $adjustment->output_name ?? '',
                'start_time' => \Carbon\Carbon::parse($adjustment->start_time)->format('Y-m-d H:i'),
                'end_time' => \Carbon\Carbon::parse($adjustment->end_time)->format('Y-m-d H:i'),
                'duration_minutes' => $adjustment->duration_minutes,
                'duration_hours' => $adjustment->duration_hours,
                'voltage' => $adjustment->voltage,
                'amper' => $adjustment->amper,
                'cosf' => $adjustment->cosf,
                'power' => $adjustment->power,
                'energy_not_supplied' => $adjustment->energy_not_supplied,
                'user_count' => $adjustment->user_count,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Д/д',
            'Салбар',
            'Дэд станц',
            'Гаргалгааны нэр',
            'Тасарсан цаг',
            'Залгасан цаг',
            'Тасарсан хугацаа, мин',
            'Тасарсан хугацаа, цаг',
            'Хүчдэл, кВ',
            'Гүйдэл, А',
            'cos ф',
            'Чадал, МВт',
            'Дутуу түгээсэн ЦЭХ, кВт.ц',
            'Хэрэглэгчийн тоо',
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
<?php

namespace App\Exports;

use App\Models\PowerOutage;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PowerOutageExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $powerOutages;

    public function __construct($powerOutages)
    {
        $this->powerOutages = $powerOutages;
    }

    public function collection()
    {
        return $this->powerOutages->map(function ($outage, $index) {
            return [
                'N' => $index + 1,
                'Station' => $outage->station->name ?? '',
                'Equipment' => $outage->equipment->name ?? '',
                'Protection' => $outage->protection->name ?? '',
                'Starttime' => $outage->start_time,
                'Endtime' => $outage->end_time,
                'Duration' => $outage->duration,
                'Weather' => $outage->weather,
                'CauseOutage' => $outage->causeOutage->name ?? '',
                'Voltage' => $outage->current_voltage,
                'Amper' => $outage->current_amper,
                'Cosf' => $outage->cosf,
                'ude' => $outage->ude,
                'User' => $outage->user->name ?? '',
                'technological_violation' => $outage->technological_violation,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Д/д',
            'Дэд станц',
            'Тоноглол',
            'Хамгаалалт',
            'Тасарсан',
            'Залгасан',
            'Нийт хугацаа',
            'Цаг агаар',
            'Тасралтын шалгтаан',
            'U кВ',
            'I A',
            'cos ф',
            'ДТЦЭХ кВт.ц',
            'Бүртгэсэн',
            'Технологийн зөрчил',
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
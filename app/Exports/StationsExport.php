<?php

namespace App\Exports;

use App\Models\Station;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StationsExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $stations;

    public function __construct($stations)
    {
        $this->stations = $stations;
    }


    public function collection()
    {
        return $this->stations->map(function ($station, $index) {
            return [
                'N' => $index + 1,
                'Type' => $station->station_type,
                'Branch' => $station->branch->name ?? '',
                'Name' => $station->name,
                'Voltage' => $station->volts->pluck('name')->join('/'),
                'Year' => $station->create_year,
                'Capacity' => $station->installed_capacity,
                'Second' => $station->second_capacity,
                'Ownership' => $station->is_user_station == 0 ? 'Хэрэглэгчийн' : 'Өөрийн',
                'Description' => $station->desc,
                'Category' => $station->station_category,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Д/д',
            'Төрөл',
            'Салбар',
            'Дэд станцын ША-ны нэр',
            'Хүчдэлийн түвшин',
            'Ашиглалтад орсон он',
            'Суурилагдсан хүчин чадал Т-1 кВА',
            'Суурилагдсан хүчин чадал Т-2 кВА',
            'Эзэмшил',
            'Эх үүсвэр',
            'Эх үүсвэрийн харьяалал',
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
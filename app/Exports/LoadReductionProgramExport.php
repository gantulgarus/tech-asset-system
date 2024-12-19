<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LoadReductionProgramExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $programs;

    public function __construct($programs)
    {
        $this->programs = $programs;
    }

    public function collection()
    {
        return $this->programs->map(function ($program, $index) {
            return [
                'N' => $index + 1,
                'Branch' => $program->branch->name ?? '',
                'ClientOrg' => $program->clientOrganization?->name ?? '',
                'Station' => $program->station?->name ?? '',
                'Output_name' => $program->output_name ?? '',
                'reduction_capacity' => $program->reduction_capacity,
                'pre_reduction_capacity' => $program->pre_reduction_capacity,
                'reduction_time' => \Carbon\Carbon::parse($program->reduction_time)->format('Y-m-d H:i'),
                'reduced_capacity' => $program->reduced_capacity,
                'post_reduction_capacity' => $program->post_reduction_capacity,
                'restoration_time' => \Carbon\Carbon::parse($program->restoration_time)->format('Y-m-d H:i'),
                'energy_not_supplied' => $program->energy_not_supplied,
                'remarks' => $program->remarks,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Д/д',
            'Салбар',
            'Хэрэглэгчийн ААН-ийн нэр',
            'Дэд станц',
            'Гаргалгааны нэр',
            '2024-2025 хэрэглээг бууруулах чадал, МВт (17-21 цагт)',
            'Ачаалал хөнгөлөхийн өмнөх чадал, (МВт)',
            'Ачаалал хөнгөлсөн цаг',
            'Хөнгөлсөн чадал, (МВт)',
            'Ачаалал хөнгөлсний дараах чадал, (МВт)',
            'Ачаалал авсан цаг',
            'Дутуу түгээсэн ЦЭХ (кВт.ц)',
            'Тайлбар',
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

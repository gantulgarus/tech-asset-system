<?php

namespace App\Exports;

use App\Models\LoadReductionProgram;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class LoadReductionProgramExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $filter;

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    public function collection()
    {
        $query = LoadReductionProgram::with(['branch', 'clientOrganization', 'station']);

        if (!empty($this->filter['branch_id'])) {
            $query->where('branch_id', $this->filter['branch_id']);
        }

        $date = $this->filter['date'] ?? now()->setTimezone('Asia/Ulaanbaatar')->toDateString();
        $query->whereDate('start_time', $date);

        return $query->get();
    }

    public function headings(): array
    {
        return [
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

    public function map($program): array
    {
        return [
            $program->branch?->name ?? 'N/A', // Use 'name' of the branch or 'N/A' if null
            $program->clientOrganization?->name ?? 'N/A', // Use 'name' of the organization or 'N/A' if null
            $program->station?->name ?? 'N/A', // Use 'name' of the station or 'N/A' if null
            $program->output_name ?? 'N/A',
            $program->reduction_capacity,
            $program->pre_reduction_capacity,
            \Carbon\Carbon::parse($program->reduction_time)->format('H:i'),
            $program->reduced_capacity,
            $program->post_reduction_capacity,
            \Carbon\Carbon::parse($program->restoration_time)->format('H:i'),
            $program->energy_not_supplied,
            $program->remarks,
        ];
    }
}

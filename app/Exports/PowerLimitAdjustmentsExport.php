<?php

namespace App\Exports;

use App\Models\PowerLimitAdjustment;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PowerLimitAdjustmentsExport implements FromCollection, WithHeadings, WithMapping
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
        $query = PowerLimitAdjustment::with(['branch', 'station']);

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

    public function map($adjustment): array
    {
        return [
            $adjustment->branch?->name ?? 'N/A',
            $adjustment->station?->name ?? 'N/A',
            $adjustment->output_name ?? 'N/A',
            \Carbon\Carbon::parse($adjustment->start_time)->format('H:i'),
            \Carbon\Carbon::parse($adjustment->end_time)->format('H:i'),
            $adjustment->duration_minutes ?? 'N/A',
            $adjustment->duration_hours ?? 'N/A',
            $adjustment->voltage ?? 'N/A',
            $adjustment->amper ?? 'N/A',
            $adjustment->cosf ?? 'N/A',
            $adjustment->power ?? 'N/A',
            $adjustment->energy_not_supplied ?? 'N/A',
            $adjustment->user_count ?? 'N/A',
        ];
    }
}

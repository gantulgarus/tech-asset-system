<?php

namespace App\Exports;

use App\Models\OrderJournal;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrderJournalExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $orderJournals;

    public function __construct($orderJournals)
    {
        $this->orderJournals = $orderJournals;
    }

    public function collection()
    {
        return $this->orderJournals->map(function ($journal, $index) {
            return [
                'N' => $index + 1,
                'Branch' => $journal->branch->name ?? '',
                'OrderType' => $journal->orderType->name ?? '',
                'OrderNumber' => $journal->order_number,
                'OrderStatus' => $journal->orderStatus->name ?? '',
                'CreatedAt' => $journal->created_at,
                'Station' => $journal->station?->name . ", " . $journal->equipment?->name,
                'Content' => $journal->content,
                'StartDate' => $journal->start_date,
                'EndDate' => $journal->end_date,
                'TransferredBy' => $journal->transferred_by,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Д/д',
            'Салбар',
            'Төрөл',
            'Дугаар',
            'Төлөв',
            'Огноо',
            'Дэд станц, шугам тоноглолын нэр',
            'Захиалгын агуулга',
            'Таслах өдөр, цаг',
            'Залгах өдөр, цаг',
            'Захиалга дамжуулсан ажилтны нэр',
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
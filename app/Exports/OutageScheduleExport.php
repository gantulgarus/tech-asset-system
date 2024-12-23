<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\OutageSchedule;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class OutageScheduleExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithDrawings, WithCustomStartCell, WithColumnWidths
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $schedules;

    public function __construct($schedules)
    {
        $this->schedules = $schedules;
    }

    public function collection()
    {
        return $this->schedules;
    }

    // Map data for each row
    public function map($schedule): array
    {
        $index = 0;
        $customDateFormat = Carbon::parse($schedule->start_date)->format('Y.m.d') . '-' . Carbon::parse($schedule->end_date)->format('d');
        $startTime = Carbon::parse($schedule->start_date)->format('H:i');
        $endTime = Carbon::parse($schedule->end_date)->format('H:i');

        return [
            $index + 1,
            $schedule->branch->name ?? '',
            $schedule->substation_line_equipment,
            $schedule->task, // Task details
            $customDateFormat . ' ' . $startTime,
            $customDateFormat . ' ' . $endTime,
            $schedule->outageScheduleType?->name, // Type
            $schedule->affected_users, // Affected users
            $schedule->responsible_officer, // Responsible staff
        ];
    }

    public function headings(): array
    {
        return [
            ['БЗӨБЦТС ТӨХК-ИЙН 2024 ОНЫ 12 ДУГААР САРЫН ТАСЛАЛТЫН ГРАФИК'],
            [''],
            ['Д/д', 'Салбар', 'Дэд станц, шугам тоноглол', 'Хийх ажлын даалгавар', 'Эхлэх огноо', 'Дуусах огноо', 'Төрөл', 'Тасрах хэрэглэгчид', 'Хариуцах албан тушаалтан'],
        ];
    }

    // Define the starting cell for data
    public function startCell(): string
    {
        return 'A8'; // Data starts after the header
    }

    // Add custom styles
    public function styles(Worksheet $sheet)
    {

        // Set the default font for the entire worksheet
        $sheet->getParent()->getDefaultStyle()->applyFromArray([
            'font' => [
                'name' => 'Arial', // Replace with your desired font (e.g., 'Times New Roman', 'Calibri')
                'size' => 11,      // Replace with your desired font size
            ],
        ]);

        // Style for table headers
        $sheet->mergeCells('A8:I8');
        $sheet->getStyle('A8:I8')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);
        $sheet->getStyle('A10:I10')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);
        $sheet->getStyle('C1:C' . $sheet->getHighestRow())->getAlignment()->setWrapText(true);
        $sheet->getStyle('D1:D' . $sheet->getHighestRow())->getAlignment()->setWrapText(true);
        $sheet->getStyle('E1:E' . $sheet->getHighestRow())->getAlignment()->setWrapText(true);
        $sheet->getStyle('F1:F' . $sheet->getHighestRow())->getAlignment()->setWrapText(true);
        $sheet->getStyle('H1:H' . $sheet->getHighestRow())->getAlignment()->setWrapText(true);
        $sheet->getStyle('I1:I' . $sheet->getHighestRow())->getAlignment()->setWrapText(true);
    }

    // Add a logo to the export file
    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Company Logo');
        $drawing->setPath(public_path('images/logo.png')); // Adjust to your logo path
        $drawing->setHeight(90); // Adjust the height
        $drawing->setCoordinates('A1'); // Place the logo in the top-left corner

        return $drawing;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 10,
            'C' => 20,
            'D' => 40,
            'E' => 15,
            'F' => 15,
            'G' => 10,
            'H' => 40,
            'I' => 20,
        ];
    }
}
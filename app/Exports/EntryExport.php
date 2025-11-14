<?php

namespace App\Exports;

use App\Models\Entry;
use App\Services\EntryService;

// Auth
use Illuminate\Support\Facades\Auth;

use Excel;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

// styles
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpParser\Node\Expr\Empty_;

use function PHPUnit\Framework\isEmpty;

class EntryExport implements FromCollection, WithMapping, WithHeadings, WithStyles, WithEvents
{
    private $entryType;
    private $exportAll;
    private $listIds;

    // Dependency Injection EntryService
    private EntryService $entryService;

    public function __construct(string $entryType, bool $exportAll, array $listIds, EntryService $entryService)
    {
        $this->entryType = $entryType;
        $this->exportAll = $exportAll;
        $this->listIds = $listIds;
        $this->entryService = $entryService;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {      
        // To select the columns in the DB that we want to export
        if ($this->exportAll) {
            // ExportAll
            // Export all the entries in the archive (softdeletes)
            if ($this->entryType == 'archive')
            {
                return Entry::onlyTrashed()
                    ->select('id', 'user_id', 'date', 'title', 'description', 'url', 'place', 'autor', 'value', 'category_id', 'info', 'created_at', 'updated_at')
                    ->get()
                    ->where('user_id', Auth::id());
            }
            else {
                return Entry::select('id', 'user_id', 'date', 'title', 'description', 'url', 'place', 'autor', 'value', 'category_id', 'info', 'created_at', 'updated_at')
                    ->get()
                    ->where('user_id', Auth::id());
            }
        } else {
            // BulkExport
            // Export entries in the archive (softdeletes)
            if ($this->entryType == 'archive')
            {
                return Entry::onlyTrashed()
                    ->select('id', 'user_id', 'date', 'title', 'description', 'url', 'place', 'autor', 'value', 'category_id', 'info', 'created_at', 'updated_at')
                    ->get()                    
                    ->whereIn('id', $this->listIds);            
            }
            // Export normal Entry
            else {
                return Entry::select('id', 'user_id', 'date', 'title', 'description', 'url', 'place', 'autor', 'value', 'category_id', 'info', 'created_at', 'updated_at')
                    ->get()
                    ->whereIn('id', $this->listIds);            
            }
        }
    }

    public function map($entry): array
    {
        // To work with the columns selected in the collection method              
        //dd($entry);
        $tags = implode("\n\n", $this->entryService->getEntryTagsNames($entry));

        $files = $entry->files->count();    
        //dd($entry->files);        
       

        return [$entry->id, $entry->user->name, $entry->date, $entry->title, $entry->description, $entry->url, $entry->place, $entry->autor, $entry->value, $entry->category->name, $tags, $files, $entry->info, date_format($entry->created_at, 'd-m-Y'), date_format($entry->updated_at, 'd-m-Y')];
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {        
        return ['ID', 'USER', 'DATE', 'TITLE', 'DESCRIPTION', 'URL', 'PLACE', 'AUTOR', 'VALUE', 'CATEGORY', 'TAGS', 'FILES', 'INFO', 'CREATED', 'UPDATED'];
    }

    /**
     * Write code on Method
     *
     * @return response()
     */

    public function registerEvents(): array
    {        
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Check if selection or All to establish the number of rows on the Excel file
                $this->exportAll ? ($totalRows = Entry::get()->where('user_id', Auth::id())->count()) : ($totalRows = count($this->listIds));

                // Default Row height and width
                $event->sheet->getRowDimension('1')->setRowHeight(50);
                $event->sheet->getDefaultColumnDimension()->setWidth(20);

                // Except for Title and Files
                $event->sheet->getColumnDimension('A')->setWidth(10);
                $event->sheet->getColumnDimension('C')->setWidth(15);
                $event->sheet->getColumnDimension('N')->setWidth(10);

                $event->sheet->getColumnDimension('D')->setWidth(50);
                $event->sheet->getColumnDimension('J')->setWidth(15);
                $event->sheet->getColumnDimension('K')->setWidth(15);
                $event->sheet->getColumnDimension('L')->setWidth(60);
                $event->sheet->getColumnDimension('M')->setWidth(15);

                $event->sheet->getColumnDimension('O')->setWidth(15);
                $event->sheet->getColumnDimension('P')->setWidth(15);

                //$event->sheet->getColumnDimension('J')->setVisible(false);
                //$event->sheet->getColumnDimension('H')->setVisible(false);

                $event->sheet
                    ->getStyle('A2:P' . $totalRows + 1)
                    ->getAlignment()
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setWrapText(true);               

                // $event->sheet
                //     ->getStyle('L2:L' . $totalRows + 1)
                //     ->getAlignment()
                //     ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

                // $event->sheet
                //     ->getStyle('M2:M' . $totalRows + 1)
                //     ->getAlignment()
                //     ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);


                // Loop through each row and apply conditional formatting
                for ($row = 2; $row <= $totalRows + 1; $row++) {
                    
                    //$cellStatus     = $event->sheet->getCell('C' . $row)->getValue();
                    //$cellWorkouts   = $event->sheet->getCell('H' . $row)->getValue();
                    //$cellDistance   = $event->sheet->getCell('K' . $row)->getValue();
                    //$cellUrls       = $event->sheet->getCell('L' . $row)->getValue();
                    
                    $cellType       = $event->sheet->getCell('E' . $row)->getValue();
                    $cellValue      = $event->sheet->getCell('F' . $row)->getValue();
                    // $cellInfo       = $event->sheet->getCell('M' . $row)->getValue();
                    // $cellFiles      = $event->sheet->getCell('N' . $row)->getValue();

                    // STATUS - 1 red pending, 0 green done
                    // if ($cellStatus == 1) {
                    //     $event->sheet
                    //         ->getStyle('C' . $row)
                    //         ->getFill()
                    //         ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    //         ->getStartColor()
                    //         ->setARGB('e44416');
                    // } else {
                    //     $event->sheet
                    //         ->getStyle('C' . $row)
                    //         ->getFill()
                    //         ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    //         ->getStartColor()
                    //         ->setARGB('e5e7eb');

                    //     $event->sheet->setCellValue('C' . $row, '0');
                    // }
                    // WORKOUTS
                    // if ($cellWorkouts == 0) {
                    //     $event->sheet
                    //         ->getStyle('H' . $row)
                    //         ->getFill()
                    //         ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    //         ->getStartColor()
                    //         ->setARGB('e5e7eb');
                    // }
                    // DISTANCE
                    // if (empty($cellDistance)) {
                    //     $event->sheet
                    //         ->getStyle('K' . $row)
                    //         ->getFont()
                    //         ->getColor()
                    //         ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);

                    //     $event->sheet->setCellValue('K' . $row, '0');
                    // }
                    // URLS
                    // if ($cellUrls == '') {
                    //     $event->sheet
                    //         ->getStyle('L' . $row)
                    //         ->getFill()
                    //         ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    //         ->getStartColor()
                    //         ->setARGB('e5e7eb');
                    // }
                    // VALUE - 1 red pending, 0 green done
                    if ($cellValue < 0) {
                        $event->sheet
                            ->getStyle('F' . $row)
                            ->getFont()
                            ->getColor()
                            ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
                    } else {
                        $event->sheet
                            ->getStyle('F' . $row)
                            ->getFont()
                            ->getColor()
                            ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_GREEN);
                    }
                    // TYPE - 1 red pending, 0 green done
                    if ($cellType == 1) {
                        $event->sheet
                            ->getStyle('E' . $row)
                            ->getFont()
                            ->getColor()
                            ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_GREEN);
                    } else {
                        $event->sheet
                            ->getStyle('E' . $row)
                            ->getFont()
                            ->getColor()
                            ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);

                        $event->sheet->setCellValue('E' . $row, '0');
                    }
                    // INFO
                    // if ($cellInfo == '') {
                    //     $event->sheet
                    //         ->getStyle('M' . $row)
                    //         ->getFill()
                    //         ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    //         ->getStartColor()
                    //         ->setARGB('e5e7eb');
                    // }
                    // FILES
                    // if ($cellFiles == 0) {
                    //     $event->sheet
                    //         ->getStyle('N' . $row)
                    //         ->getFill()
                    //         ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    //         ->getStartColor()
                    //         ->setARGB('e5e7eb');                        
                    // }                    
                    
                }
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $totalRows = count($this->listIds);
        return [
            // Style the first row as bold text.
            1 => [
                'font' => [
                    'name' => 'Arial',
                    'bold' => true,
                    'italic' => false,
                    'strikethrough' => false,
                    'color' => [
                        'rgb' => 'FFFFFF',
                    ],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 90,
                    'startColor' => [
                        'argb' => '16a34a',
                    ],
                    'endColor' => [
                        'argb' => '16a34a',
                    ],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'wrapText' => false,
                ],
                'borders' => [
                    'bottom' => [
                        'borderStyle' => Border::BORDER_THICK,
                        'color' => [
                            'rgb' => '000000',
                        ],
                    ],
                    'top' => [
                        'borderStyle' => Border::BORDER_THICK,
                        'color' => [
                            'rgb' => '000000',
                        ],
                    ],
                    'left' => [
                        'borderStyle' => Border::BORDER_THICK,
                        'color' => [
                            'rgb' => '000000',
                        ],
                    ],
                    'right' => [
                        'borderStyle' => Border::BORDER_THICK,
                        'color' => [
                            'rgb' => '000000',
                        ],
                    ],
                ],
            ],
            /* 'A2:K' . $totalRows + 1 => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                    'wrapText' => false,
                ],
            ], */
        ];
    }
}

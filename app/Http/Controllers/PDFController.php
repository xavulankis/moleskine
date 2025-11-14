<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Entry;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class PDFController extends Controller
{

    public function generateEntryPDF(Entry $data)
    {
        $dataToPdf = clone $data;
        $dataToPdf = $dataToPdf->toArray();

        // Convert the string to a DateTime object
        $dateTime = DateTime::createFromFormat('Y-d-m', $data->date);
        $dataToPdf["date"] = date_format($dateTime, 'd-m-Y');
                
        
        $dataToPdf["user_name"] = $data->user->name;
        $dataToPdf["category_name"] = $data->category->name;
        
        $dataToPdf["tags"] = $data->tags->toArray();

        /* Get the attached files */
        $files = $data->files;
        
        if ($files != null && $files != '[]')
        {
            $dataToPdf["files"] = [];
            foreach ($files as $key => $file)
            {
                $dataToPdf["files"][$key] = $file->toArray();
            }
        } 
        //dd($dataToPdf);
        
        $pdf = PDF::loadView('pdf.entryPDF', $dataToPdf);
        
        $documentName = $data->user->name . '_entry_' . $data->id . '.pdf';

        return $pdf->download($documentName);
       
    }

    public function generateArchiveEntryPDF(mixed $archiveID)
    {
        
        $data = Entry::onlyTrashed()
                ->get()
                ->where('id', '=', $archiveID)->first();

        $dataToPdf = clone $data;
        $dataToPdf = $dataToPdf->toArray();

        // Convert the string to a DateTime object
        $dateTime = DateTime::createFromFormat('Y-d-m', $data->date);
        $dataToPdf["date"] = date_format($dateTime, 'd-m-Y');
        
        ($data->status == 0 ?  $dataToPdf["status"] = 'Complete' :  $dataToPdf["status"]  = 'Pending');
        
        $dataToPdf["user_name"] = $data->user->name;
        $dataToPdf["category_name"] = $data->category->name;
        
        $dataToPdf["tags"] = $data->tags->toArray();

        /* Get the attached files */
        $files = $data->files;
        
        if ($files != null && $files != '[]')
        {
            $dataToPdf["files"] = [];
            foreach ($files as $key => $file)
            {
                $dataToPdf["files"][$key] = $file->toArray();
            }
        } 
        
        $pdf = PDF::loadView('pdf.entryPDF', $dataToPdf);
        
        $documentName = $data->user->name . '_ARCHIVE_entry_' . $data->id . '.pdf';

        return $pdf->download($documentName);
       
    }
    
}

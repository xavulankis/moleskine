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
        
        $dateTime = DateTime::createFromFormat('Y-m-d', $data->date);
        $dataToPdf["date"] = date_format($dateTime, 'd-m-Y');
        //dd($dataToPdf["date"]);        
        
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

        $dataToPdf["archive"] = false;
        
        $pdf = PDF::loadView('pdf.entryPDF', $dataToPdf);
        
        $documentName = 'Moleskine_entry_ID_' . $data->id . '.pdf';

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
        $dateTime = DateTime::createFromFormat('Y-m-d', $data->date);
        $dataToPdf["date"] = date_format($dateTime, 'd-m-Y');
        
        $dataToPdf["dateDeleted"] = date_format($data->deleted_at, 'd-m-Y H:i:s');
        
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

        $dataToPdf["archive"] = true;
        
        $pdf = PDF::loadView('pdf.entryPDF', $dataToPdf);
        
        $documentName = 'Moleskine_archive_entry_ID_' . $data->id . '.pdf';

        return $pdf->download($documentName);
       
    }
    
}

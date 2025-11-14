<?php

namespace App\Http\Controllers;

use App\Exports\EntryExport;
use App\Models\Entry;
use App\Services\EntryService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class EntryController extends Controller
{
    public function __construct(private EntryService $entryService) {        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entry $entry)
    {          
        
        try {            
            $entry->delete();
            return to_route('entries.index')->with('message', 'Entry (' . $entry->title . ') deleted.');
        } catch (Exception $e) {
            return to_route('entries.index')->with('message', 'Error (' . $e->getCode() . ') Entry: ' . $entry->title . ' can not be deleted.');
        }              
    }

    /**
     * -------------- EXPORT to EXCEL --------------------
     */

    /**
     * Export the collection as excel file
     */
    public function export(Request $request) 
    {   
        
        //dd($request);
        $criteriaSelection = json_decode($request->criteriaSelection, true);
        
        $criteriaName = $this->entryService->getCriteriaFilename($criteriaSelection);
        //dd($resultado);
        //dd($request->entries);
        $criteria = $request->criteriaSelection;
        //dd($criteria);

        // listEntries is a string, remove [ ] from start and end of the string
        $stringListEntries = substr($request->entries, 1, -1);

        // convert string to array of Ids
        $listIds = explode(',',$stringListEntries);

        // File name
        if($criteria != '[]')
        {
            if ($request->entryType == 'archive')
            {
                $excelFileName = 'ARCHIVE_Kakebo_'. date('Y-m-d',time()) . '_CRITERIA_' . $criteriaName . 'Total('. count($listIds) .').xlsx';
            }
            else {
                $excelFileName = 'Kakebo_'. date('Y-m-d',time()) . '_CRITERIA_' . $criteriaName . 'Total('. count($listIds) .').xlsx';
            }            
        }
        else {

            if ($request->entryType == 'archive')
            {
                $excelFileName = 'ARCHIVE_Kakebo_'. date('Y-m-d',time()) . '_User_' . Auth::user()->name . '_TotalEntries('. count($listIds) .').xlsx';
            }
            else {
                $excelFileName = 'Kakebo_'. date('Y-m-d',time()) . '_User_' . Auth::user()->name . '_TotalEntries('. count($listIds) .').xlsx';
            }
        }
        
        return Excel::download(new EntryExport($request->entryType, false, $listIds, $this->entryService),  $excelFileName);
    }

    /**
     * Export the collection as excel file
     */
    public function exportBulk(Request $request) 
    {                
        
        //dd($request);

        $criteriaSelection = json_decode($request->criteriaSelection, true);        
        $criteriaName = $this->entryService->getCriteriaFilename($criteriaSelection);
        $criteria = $request->criteriaSelection;
        //dd($criteria);

        // convert string to array of Ids
        $listIds = explode(',',$request->listEntriesBulk);   
        //$excelFileName = Auth::user()->name . '_BulkEntries('. count($listIds) .').xlsx';


        // File name
        if($criteria != '[]')
        {
            if ($request->entryType == 'archive')
            {
                $excelFileName = 'ARCHIVE_Kakebo_Bulk_'. date('Y-m-d',time()) . '_CRITERIA_' . $criteriaName . 'Total('. count($listIds) .').xlsx';
            }
            else {
                $excelFileName = 'Kakebo_Bulk_'. date('Y-m-d',time()) . '_CRITERIA_' . $criteriaName . 'Total('. count($listIds) .').xlsx';
            }            
        }
        else {

            if ($request->entryType == 'archive')
            {
                $excelFileName = 'ARCHIVE_Kakebo_Bulk_'. date('Y-m-d',time()) . '_User_' . Auth::user()->name . '_TotalEntries('. count($listIds) .').xlsx';
            }
            else {
                $excelFileName = 'Kakebo_Bulk_'. date('Y-m-d',time()) . '_User_' . Auth::user()->name . '_TotalEntries('. count($listIds) .').xlsx';
            }
        }

        //print_r($listIds);
        //print_r($excelFileName);
        //dd('export Bulk');

        return Excel::download(new EntryExport($request->entryType, false, $listIds, $this->entryService), $excelFileName);
    }







    /**
     * Export the collection as excel file
     */
    // public function exportAll() 
    // {        
    //     //$totalEntries = $this->codeService->totalEntries();
    //     dd('export all');
    //     $totalEntries = Entry::get()->where('user_id', Auth::id())->count();
    //     $excelFileName = Auth::user()->name . '_AllEntries('. $totalEntries .').xlsx';

    //     return Excel::download(new EntryExport(true, [], $this->entryService), $excelFileName);
    // }

    /**
     * Export the collection as excel file
     */
    // public function exportSelected(Request $request) 
    // {   
    //     // listEntries is a string, remove [ ] from start and end of the string
    //     $stringListEntries = substr($request->listEntries, 1, -1);

    //     // convert string to array of Ids
    //     $listIds = explode(',',$stringListEntries);
    //     $excelFileName = Auth::user()->name . '_SelectionEntriess('. count($listIds) .').xlsx';                
        
    //     return Excel::download(new EntryExport(false, $listIds, $this->entryService),  $excelFileName);
    // }

    

    
}


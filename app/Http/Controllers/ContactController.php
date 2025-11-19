<?php

namespace App\Http\Controllers;

use App\Exports\EntryExport;
use App\Models\Contact;
use App\Services\EntryService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ContactController extends Controller
{
    public function __construct(private EntryService $entryService) {        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {          
        
        try {            
            $contact->delete();
            return to_route('contacts.index')->with('message', 'Contact (' . $contact->first_name . ') deleted.');
        } catch (Exception $e) {
            return to_route('contacts.index')->with('message', 'Error (' . $e->getCode() . ') Contact: ' . $contact->first_name . ' can not be deleted.');
        }              
    }

    /**
     * -------------- EXPORT to EXCEL --------------------
     */

    /**
     * Export the collection as excel file
     */
    // public function export(Request $request) 
    // {   
        
    //     //dd($request);
    //     $criteriaSelection = json_decode($request->criteriaSelection, true);
        
    //     $criteriaName = $this->entryService->getCriteriaFilename($criteriaSelection);
    //     //dd($resultado);
    //     //dd($request->entries);
    //     $criteria = $request->criteriaSelection;
    //     //dd($criteria);

    //     // listEntries is a string, remove [ ] from start and end of the string
    //     $stringListEntries = substr($request->entries, 1, -1);

    //     // convert string to array of Ids
    //     $listIds = explode(',',$stringListEntries);

    //     // File name
    //     if($criteria != '[]')
    //     {
    //         if ($request->entryType == 'archive')
    //         {
    //             $excelFileName = 'Moleskine_Archive_'. date('d-m-Y',time()) . '_CRITERIA_' . $criteriaName . 'Found('. count($listIds) .').xlsx';
    //         }
    //         else {
    //             $excelFileName = 'Moleskine_'. date('d-m-Y',time()) . '_CRITERIA_' . $criteriaName . 'Found('. count($listIds) .').xlsx';
    //         }            
    //     }
    //     else {

    //         if ($request->entryType == 'archive')
    //         {
    //             $excelFileName = 'Moleskine_Archive_'. date('d-m-Y',time()) . '_Total('. count($listIds) .').xlsx';
    //         }
    //         else {
    //             $excelFileName = 'Moleskine_'. date('d-m-Y',time()) . '_Total('. count($listIds) .').xlsx';
    //         }
    //     }
        
    //     return Excel::download(new EntryExport($request->entryType, false, $listIds, $this->entryService),  $excelFileName);
    // }

    /**
     * Export the collection as excel file
     */
    // public function exportBulk(Request $request) 
    // {                
        
    //     //dd($request);

    //     $criteriaSelection = json_decode($request->criteriaSelection, true);        
    //     $criteriaName = $this->entryService->getCriteriaFilename($criteriaSelection);
    //     $criteria = $request->criteriaSelection;
    //     //dd($criteria);

    //     // convert string to array of Ids
    //     $listIds = explode(',',$request->listEntriesBulk);   
    //     //$excelFileName = Auth::user()->name . '_BulkEntries('. count($listIds) .').xlsx';


    //     // File name
    //     if($criteria != '[]')
    //     {
    //         if ($request->entryType == 'archive')
    //         {
    //             $excelFileName = 'Moleskine_Archive_Bulk_'. date('d-m-Y',time()) . '_CRITERIA_' . $criteriaName . 'Found('. count($listIds) .').xlsx';
    //         }
    //         else {
    //             $excelFileName = 'Moleskine_Bulk_'. date('d-m-Y',time()) . '_CRITERIA_' . $criteriaName . 'Found('. count($listIds) .').xlsx';
    //         }            
    //     }
    //     else {

    //         if ($request->entryType == 'archive')
    //         {
    //             $excelFileName = 'Moleskine_Archive_Bulk_'. date('d-m-Y',time()) . '_Total('. count($listIds) .').xlsx';
    //         }
    //         else {
    //             $excelFileName = 'Moleskine_Bulk_'. date('d-m-Y',time()) . '_Total('. count($listIds) .').xlsx';
    //         }
    //     }

    //     //print_r($listIds);
    //     //print_r($excelFileName);
    //     //dd('export Bulk');

    //     return Excel::download(new EntryExport($request->entryType, false, $listIds, $this->entryService), $excelFileName);
    // }
  

    
}


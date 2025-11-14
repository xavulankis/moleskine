<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Services\FileService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArchiveController extends Controller
{
    public function __construct(private FileService $fileService) {        
    }

    /**
     * Restore the entry from Archive to Entries, Soft Delete DB Column deleted_at = NULL.
     */
    public function restore(int $entry)
    {      
                
        $data = Entry::onlyTrashed()->get();
        $restoreEntry = $data->where('id', '=', $entry)->first();
        
        // if can restore is ALREADY an admin
        // if ($restoreEntry->user_id !== Auth::id()) {           
        //     abort(403);
        // }   
         try {            
            $restoreEntry->restore();
            return to_route('archive.index')->with('message', 'Entry ID(' . $restoreEntry->id . ') restored');
        } catch (Exception $e) {
            return to_route('archive.index')->with('error', 'Error (' . $e->getCode() . ') Entry: ' . $restoreEntry->id . ' can not be restored.');
        }         
                      
    }

    /**
     * Delete Permanently the Entry and delete his associated files in the storage
     */
     public function destroy(int $entryID)
    {   
        $entry = Entry::onlyTrashed()->find($entryID);     
        
        // TEST DELETE DIRECTLY THE FOLDER WITH ALL THE FILES FOR THE ENTRY INSTEAD ONE BY ONE.
        //$files = $entry->files;
        //dd($files);
        // test delete folder
        //$testDeleteFolder = public_path('/entryfiles/19');
        //$testDeleteFolder = '/entryfiles/gretucci';
        //dd($testDeleteFolder);
        //$this->fileService->deleteFolder($testDeleteFolder);
        //dd('folder deleted');


        //$storagePathFolder = 'entryfiles/' . $entry->id;
        //if ($files->isNotEmpty()) {
        //        print_r($storagePathFolder);
        //        dd($files);            
                    // BETTER: Delete the directory with all the files inside
        //        }
        //dd('No files in the entry', $entry->id);
        
        try {
            $files = $entry->files;
            // forceDelete method to permanently remove a soft deleted model from the database table
            $result = $entry->forceDelete();

            // If the Entry has been deleted, check if there is associated files and delete them.
            if ($result) {
                if ($files->isNotEmpty()) {
                    //$this->fileService->deleteFiles($files);
                    // BETTER: Delete the directory with all the files inside
                    $folderPath = 'entryfiles/' . $entry->id;
                    $this->fileService->deleteFolder($folderPath);
                }
                
                return to_route('archive.index')->with('message', 'Entry ID(' . $entry->id . ') successfully deleted PERMANENTLY');               
            } else {
                return to_route('archive.index')->with('error', 'Error - Files from Entry ID(' . $entry->id . ') can not be deleted');
            }
        } catch (Exception $e) {            
            return to_route('archive.index')->with('error', 'Error(' . $e->getCode() . ') - Entry ID(' . $entry->id . ') can not be deleted');
        }
           
                      
    }
   
}

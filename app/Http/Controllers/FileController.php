<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\File;
use App\Services\FileService;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function __construct(private FileService $fileService) {        
    }
    
    // public function download(Entry $sport, File $file)
    // {
    //     return $this->fileService->downloadFile($file, 'attachment');
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entry $entry, File $file)
    {          
        //dd($file);
        $this->fileService->deleteOneFile($file, true);
        
        return back()->with('message', 'File ' . $file->original_filename . ' deleted.');
    }

     /**
     * Remove the specified resource from storage.
     * use int archiveID instead of Entry archive, does not recognize the Entry because it is a softdelete.
     */
    public function destroyfilearchive(int $archiveID, File $file)
    {   
        //dd($archiveID, $file);
        $this->fileService->deleteOneFile($file, false);
        
        return back()->with('message', 'File ' . $file->original_filename . ' deleted.');
    }
}

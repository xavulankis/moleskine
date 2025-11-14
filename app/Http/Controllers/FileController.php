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
        $this->fileService->deleteOneFile($file);
        
        return back()->with('message', 'File ' . $file->original_filename . ' deleted.');
    }

     /**
     * Remove the specified resource from storage.
     */
    // public function destroyarchive(Entry $archive, File $file)
    // {   
    //     dd($file);
    //     $this->fileService->deleteOneFile($file);
        
    //     return back()->with('message', 'File ' . $file->original_filename . ' deleted.');
    // }
}

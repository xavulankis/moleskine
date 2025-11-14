<?php

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\TagController;
use App\Livewire\Archive;
use App\Livewire\ArchiveShow;
use App\Livewire\Categories;
use App\Livewire\CategoriesCreate;
use App\Livewire\CategoriesEdit;
use App\Livewire\CategoriesShow;
use App\Livewire\Entries;
use App\Livewire\EntriesCreate;
use App\Livewire\EntriesEdit;
use App\Livewire\EntriesShow;
use App\Livewire\FileUpload;
use App\Livewire\Tags;
use App\Livewire\TagsCreate;
use App\Livewire\TagsEdit;
use App\Livewire\TagsShow;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');

    
    /* ENTRIES */
    Route::get('/entries', Entries::class)->name('entries.index');
    Route::get('/entries/create', EntriesCreate::class)->name('entries.create');
    Route::get('/entries/show/{entry}', EntriesShow::class)->name('entries.show');
    Route::delete('/entries/{entry}', [EntryController::class, 'destroy'])->name('entries.destroy');
    Route::get('/entries/edit/{entry}', EntriesEdit::class)->name('entries.edit');    

    // EXCEL 
    Route::post('/entries/export', [EntryController::class, 'export'])->name('entries.export');
    Route::post('/entries/exportbulk', [EntryController::class, 'exportBulk'])->name('entries.exportbulk');

    /* FILES */
    Route::get('/entries/{entry}/file', FileUpload::class)->name('files.upload');
    Route::delete('/entries/{entry}/file/{file}', [FileController::class, 'destroy'])->name('files.destroy');
    
    /* PDF */
    Route::get('/generate_pdf/{data}', [PDFController::class, 'generateEntryPDF'])->name('entries_pdf.generate');

    /* ARCHIVE */
    Route::get('/archive', Archive::class)->name('archive.index');
    Route::get('/archive/show/{archive}', ArchiveShow::class)->name('archive.show');
    Route::put('/archive/{archive}', [ArchiveController::class, 'restore'])->name('archive.restore');
    Route::delete('/archive/{archive}', [ArchiveController::class, 'destroy'])->name('archive.destroy');

    // test delete file from archive
    //Route::delete('/archive/{archive}/file/{file}', [FileController::class, 'destroyarchive'])->name('files.destroyarchive');

    /* CATEGORIES */
    Route::get('/categories', Categories::class)->name('categories.index');
    Route::get('/categories/create', CategoriesCreate::class)->name('categories.create');
    Route::get('/categories/show/{category}', CategoriesShow::class)->name('categories.show');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/categories/edit/{category}', CategoriesEdit::class)->name('categories.edit');

    /* TAGS */
    Route::get('/tags', Tags::class)->name('tags.index');
    Route::get('/tags/create', TagsCreate::class)->name('tags.create');
    Route::get('/tags/show/{tag}', TagsShow::class)->name('tags.show');
    Route::put('/tags/{tag}', [TagController::class, 'update'])->name('tags.update');
    Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');
    Route::get('/tags/edit/{tag}', TagsEdit::class)->name('tags.edit');

});

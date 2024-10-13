<?php

namespace App\Exports;

use App\Models\Famille;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportFamille implements FromView, ShouldAutoSize
{

    public function view(): View
    {
        return view('exports.familles', [
            'familles' => Famille::where('is_deleted', 0)->with('auteur')->get()
        ]);
    }
}

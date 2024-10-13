<?php

namespace App\Exports;

use App\Models\Fournisseur;use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportFourniseur implements FromView
{
    public function view(): View
    {
        return view('exports.fournisseurs', [
            'fournisseurs' => Fournisseur::where('is_deleted', 0)->with('auteur')->get()
        ]);
    }
}

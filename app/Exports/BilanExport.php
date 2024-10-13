<?php

namespace App\Exports;

use App\Models\Bilan;
use App\Models\BilanHistorique;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BilanExport implements FromView, ShouldAutoSize
{
    protected $reference;

    function __construct($reference) {

            $this->reference = $reference;
    }

    public function view(): View
    {
        $bilan = Bilan::where('reference', $this->reference)->first();

        $bilan_recettes = BilanHistorique::where('bilan_id', $bilan->id)->get();

        return view('exports.bilan', compact('bilan','bilan_recettes'));
    }
}

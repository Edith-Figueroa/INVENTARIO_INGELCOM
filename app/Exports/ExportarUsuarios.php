<?php

namespace App\Exports;

use App\Models\User; // MODELO USUARIOS
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ExportarUsuarios implements FromView
{
    /**
     * @return View
     */
    public function view(): View
    {
        return view('Excel.ExportarUsuarios', [
            'users' => User::all()
        ]);
    }
}

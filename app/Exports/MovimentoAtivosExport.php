<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MovimentoAtivosExport implements FromCollection, WithHeadings
{
    protected $dadosAtivos;

    public function __construct(array $dadosAtivos)
    {
        $this->dadosAtivos = $dadosAtivos;
    }
    public function collection()
    {
        return collect($this->dadosAtivos);
    }

    public function headings(): array
    {
        return [
            'nome',
            'tipo',
            'movimento',
            'data',
            'corretagem',
            'quantidade',
            'valor',
            'valor total',
        ];
    }
}

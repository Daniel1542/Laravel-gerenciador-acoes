<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AtivosExport implements FromCollection, WithHeadings
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
            'Nome',
            'Quant Compra',
            'Quant Venda',
            'Quantidade total',
            'Corretagem',
            'Compras',
            'Vendas',
            'Valor total',
        ];
    }
}

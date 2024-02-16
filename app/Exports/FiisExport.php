<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FiisExport implements FromCollection, WithHeadings
{
    protected $dadosFiis;

    public function __construct(array $dadosFiis)
    {
        $this->dadosFiis = $dadosFiis;
    }

    public function collection()
    {
        return collect($this->dadosFiis);
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

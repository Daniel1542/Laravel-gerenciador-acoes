<?php

namespace App\Jobs;

use App\Models\FormulaBazin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProcessFormulaBazin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Salvar os dados no banco de dados
        $user = Auth::user();
        $FormulaBazin = new FormulaBazin();
        $FormulaBazin-> user_id = $user->id;
        $FormulaBazin->ticker = $this->data['ticker'];
        $FormulaBazin->lpa = $this->data['lpa'];
        $FormulaBazin->payout = $this->data['payout'];
        $FormulaBazin->yield_projetado = $this->data['yield_projetado'];
        $FormulaBazin->save();

        // Log the creation
        Log::info('Bazin formula created:', $this->data);

    }
}
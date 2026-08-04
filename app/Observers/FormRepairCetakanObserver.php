<?php

namespace App\Observers;

use App\Models\FormRepairCetakan;
use App\Models\HistoryCetakan;

class FormRepairCetakanObserver
{
    /**
     * Handle the FormRepairCetakan "created" event.
     */
    public function created(FormRepairCetakan $formRepairCetakan): void
    {
        HistoryCetakan::create([
            'list_code_item_id' => $formRepairCetakan->list_code_item_id,
            'set_code_item_id' => $formRepairCetakan->set_code_item_id,
            'cav_code_item_id' => $formRepairCetakan->cav_code_item_id,
            'tanggal' => $formRepairCetakan->tanggal,
            'deskripsi' => $formRepairCetakan->problem,
        ]);
    }

    /**
     * Handle the FormRepairCetakan "updated" event.
     */
    public function updated(FormRepairCetakan $formRepairCetakan): void
    {
        $history = HistoryCetakan::where('list_code_item_id', $formRepairCetakan->list_code_item_id)
            ->where('set_code_item_id', $formRepairCetakan->set_code_item_id)
            ->where('cav_code_item_id', $formRepairCetakan->cav_code_item_id)
            ->first();

        if ($history) {
            $history->update([
                'tanggal' => $formRepairCetakan->tanggal,
                'deskripsi' => $formRepairCetakan->problem,
            ]);
        } else {
            // Jika data tidak ditemukan, buat data baru
            HistoryCetakan::create([
                'list_code_item_id' => $formRepairCetakan->list_code_item_id,
                'set_code_item_id' => $formRepairCetakan->set_code_item_id,
                'cav_code_item_id' => $formRepairCetakan->cav_code_item_id,
                'tanggal' => $formRepairCetakan->tanggal,
                'deskripsi' => $formRepairCetakan->problem,
            ]);
        }
    }

    /**
     * Handle the FormRepairCetakan "deleted" event.
     */
    public function deleted(FormRepairCetakan $formRepairCetakan): void
    {
        HistoryCetakan::where('list_code_item_id', $formRepairCetakan->list_code_item_id)
            ->where('set_code_item_id', $formRepairCetakan->set_code_item_id)
            ->where('cav_code_item_id', $formRepairCetakan->cav_code_item_id)
            ->delete();
    }

    /**
     * Handle the FormRepairCetakan "restored" event.
     */
    public function restored(FormRepairCetakan $formRepairCetakan): void
    {
        //
    }

    /**
     * Handle the FormRepairCetakan "force deleted" event.
     */
    public function forceDeleted(FormRepairCetakan $formRepairCetakan): void
    {
        //
    }
}

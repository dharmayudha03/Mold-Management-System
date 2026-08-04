<?php

namespace App\Observers;

use App\Models\FormMjo;
use App\Models\FormRepairCetakan;

class FormMjoObserver
{
    /**
     * Handle the FormMjo "created" event.
     */
    public function created(FormMjo $formMjo): void
    {
        if ($formMjo->form_repair_cetakan_id) {
            FormRepairCetakan::where('id', $formMjo->form_repair_cetakan_id)
                ->update(['status' => 'SELESAI']);
        }
    }

    /**
     * Handle the FormMjo "updated" event.
     */
    public function updated(FormMjo $formMjo): void
    {
        //
    }

    /**
     * Handle the FormMjo "deleted" event.
     */
    public function deleted(FormMjo $formMjo): void
    {
        //
    }

    /**
     * Handle the FormMjo "restored" event.
     */
    public function restored(FormMjo $formMjo): void
    {
        //
    }

    /**
     * Handle the FormMjo "force deleted" event.
     */
    public function forceDeleted(FormMjo $formMjo): void
    {
        //
    }
}

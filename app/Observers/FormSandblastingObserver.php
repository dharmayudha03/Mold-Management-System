<?php

namespace App\Observers;

use App\Models\FormSandblasting;
use App\Models\FormSchedule;
use App\Models\HistoryCetakan;
use App\Models\PenomoranRak;

class FormSandblastingObserver
{
    /**
     * Handle the FormSandblasting "created" event.
     */
    public function created(FormSandblasting $formSandblasting): void
    {
        $kategoriName = $formSandblasting->kategori ? $formSandblasting->kategori->name : null;
        $historyExists = HistoryCetakan::where('list_code_item_id', $formSandblasting->list_code_item_id)
            ->where('set_code_item_id', $formSandblasting->set_code_item_id)
            ->where('cav_code_item_id', $formSandblasting->cav_code_item_id)
            ->where('deskripsi', $kategoriName)
            ->exists();

        if (!$historyExists) {
            HistoryCetakan::create([
                'list_code_item_id' => $formSandblasting->list_code_item_id,
                'set_code_item_id' => $formSandblasting->set_code_item_id,
                'cav_code_item_id' => $formSandblasting->cav_code_item_id,
                'tanggal' => $formSandblasting->tanggal,
                'deskripsi' => $kategoriName,
            ]);
        }

        if ($formSandblasting->list_code_item_id && $formSandblasting->list_mesin_id) {
            $formSchedule = FormSchedule::where('list_code_item_id', $formSandblasting->list_code_item_id)
                ->where('list_mesin_id', $formSandblasting->list_mesin_id)
                ->first();
        
            if ($formSchedule) {
                $formSchedule->status = 'SELESAI';
                $formSchedule->save();
            }
        }

        if ($formSandblasting->oiling == '√') {
            PenomoranRak::updateOrCreate(
                [
                    'list_code_item_id' => $formSandblasting->list_code_item_id,
                    'set_code_item_id'  => $formSandblasting->set_code_item_id,
                    'cav_code_item_id'  => $formSandblasting->cav_code_item_id,
                ],
                [
                    'rak'    => $formSandblasting->rak,
                    'norak'  => $formSandblasting->norak,
                    'status' => 'TERISI',
                ]
            );
        } elseif ($formSandblasting->oiling == '-') {
            $penomoranRak = PenomoranRak::where('list_code_item_id', $formSandblasting->list_code_item_id)
                ->where('set_code_item_id', $formSandblasting->set_code_item_id)
                ->where('cav_code_item_id', $formSandblasting->cav_code_item_id)
                ->first();

            if ($penomoranRak) {
                $penomoranRak->update([
                    'status' => 'TERSEDIA',
                ]);
            }
        }
    }

    /**
     * Handle the FormSandblasting "updated" event.
     */
    public function updated(FormSandblasting $formSandblasting): void
    {
        $kategoriName = $formSandblasting->kategori ? $formSandblasting->kategori->name : null;
        $history = HistoryCetakan::where('list_code_item_id', $formSandblasting->list_code_item_id)
            ->where('set_code_item_id', $formSandblasting->set_code_item_id)
            ->where('cav_code_item_id', $formSandblasting->cav_code_item_id)
            ->first();

        if ($history) {
            $history->update([
                'tanggal' => $formSandblasting->tanggal,
                'deskripsi' => $kategoriName,
            ]);
        } else {
            // Jika data tidak ditemukan, buat data baru
            HistoryCetakan::create([
                'list_code_item_id' => $formSandblasting->list_code_item_id,
                'set_code_item_id' => $formSandblasting->set_code_item_id,
                'cav_code_item_id' => $formSandblasting->cav_code_item_id,
                'tanggal' => $formSandblasting->tanggal,
                'deskripsi' => $kategoriName,
            ]);
        }

        if ($formSandblasting->oiling == '√') {
            PenomoranRak::updateOrCreate(
                [
                    'list_code_item_id' => $formSandblasting->list_code_item_id,
                    'set_code_item_id'  => $formSandblasting->set_code_item_id,
                    'cav_code_item_id'  => $formSandblasting->cav_code_item_id,
                ],
                [
                    'rak'    => $formSandblasting->rak,
                    'norak'  => $formSandblasting->norak,
                    'status' => 'TERISI',
                ]
            );
        } elseif ($formSandblasting->oiling == '-') {
            $penomoranRak = PenomoranRak::where('list_code_item_id', $formSandblasting->list_code_item_id)
                ->where('set_code_item_id', $formSandblasting->set_code_item_id)
                ->where('cav_code_item_id', $formSandblasting->cav_code_item_id)
                ->first();

            if ($penomoranRak) {
                $penomoranRak->update([
                    'status' => 'TERSEDIA',
                ]);
            }
        }
    }

    /**
     * Handle the FormSandblasting "deleted" event.
     */
    public function deleted(FormSandblasting $formSandblasting): void
    {
        HistoryCetakan::where('list_code_item_id', $formSandblasting->list_code_item_id)
            ->where('set_code_item_id', $formSandblasting->set_code_item_id)
            ->where('cav_code_item_id', $formSandblasting->cav_code_item_id)
            ->delete();

            if ($formSandblasting->list_code_item_id && $formSandblasting->list_mesin_id) {
                $formSchedule = FormSchedule::where('list_code_item_id', $formSandblasting->list_code_item_id)
                    ->where('list_mesin_id', $formSandblasting->list_mesin_id)
                    ->first();
            
                if ($formSchedule) {
                    $formSchedule->status = 'DIPROSES';
                    $formSchedule->save();
                }
            }

        $penomoranRak = PenomoranRak::where('rak', $formSandblasting->rak)
            ->where('norak', $formSandblasting->norak)
            ->first();

        if ($penomoranRak) {
            $penomoranRak->update([
                'list_code_item_id' => null,
                'set_code_item_id' => null,
                'cav_code_item_id' => null,
                'status' => 'TERSEDIA',
            ]);
        }
    }

    /**
     * Handle the FormSandblasting "restored" event.
     */
    public function restored(FormSandblasting $formSandblasting): void
    {
        //
    }

    /**
     * Handle the FormSandblasting "force deleted" event.
     */
    public function forceDeleted(FormSandblasting $formSandblasting): void
    {
        //
    }
}

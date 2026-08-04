<?php

namespace App\Observers;

use App\Models\CetakanNaik;
use App\Models\FormSchedule;
use App\Models\FormSetupCetakan;
use App\Models\HistoryCetakan;
use App\Models\PenomoranRak;

class FormSetupCetakanObserver
{
    /**
     * Handle the FormSetupCetakan "created" event.
     */
    public function created(FormSetupCetakan $formSetupCetakan): void
    {
        $kategoriName = $formSetupCetakan->kategori ? $formSetupCetakan->kategori->name : null;
        $upperKategori = strtoupper(trim($kategoriName ?? ''));

        $historyExists = HistoryCetakan::where('list_code_item_id', $formSetupCetakan->list_code_item_id)
            ->where('set_code_item_id', $formSetupCetakan->set_code_item_id)
            ->where('cav_code_item_id', $formSetupCetakan->cav_code_item_id)
            ->where('deskripsi', $kategoriName)
            ->exists();

        if (!$historyExists) {
            HistoryCetakan::create([
                'list_code_item_id' => $formSetupCetakan->list_code_item_id,
                'set_code_item_id' => $formSetupCetakan->set_code_item_id,
                'cav_code_item_id' => $formSetupCetakan->cav_code_item_id,
                'tanggal' => $formSetupCetakan->tanggal,
                'deskripsi' => $kategoriName,
            ]);
        }

        // Automatic Sync to CetakanNaik menu
        if ($upperKategori === 'SETUP CETAKAN NAIK' || str_contains($upperKategori, 'NAIK')) {
            CetakanNaik::updateOrCreate(
                ['list_mesin_id' => $formSetupCetakan->list_mesin_id],
                [
                    'list_code_item_id' => $formSetupCetakan->list_code_item_id,
                    'set_code_item_id' => $formSetupCetakan->set_code_item_id,
                    'cav_code_item_id' => $formSetupCetakan->cav_code_item_id,
                    'tanggalnaik' => $formSetupCetakan->tanggal,
                    'keterangan' => 'Produksi',
                    'note' => '-',
                ]
            );
        } elseif ($upperKategori === 'SETUP CETAKAN TURUN' || str_contains($upperKategori, 'TURUN')) {
            CetakanNaik::where('list_mesin_id', $formSetupCetakan->list_mesin_id)->delete();
        }

        $formSchedule = FormSchedule::where('list_code_item_id', $formSetupCetakan->list_code_item_id)
            ->where('list_mesin_id', $formSetupCetakan->list_mesin_id)
            ->first();

        if ($formSchedule) {
            $formSchedule->status = 'SELESAI';
            $formSchedule->save();
        }

        if ($formSetupCetakan->rak && $formSetupCetakan->norak) {
            $penomoranRak = PenomoranRak::where('rak', $formSetupCetakan->rak)
                ->where('norak', $formSetupCetakan->norak)
                ->first();

            if ($penomoranRak) {
                $penomoranRak->update([
                    'list_code_item_id' => $formSetupCetakan->list_code_item_id,
                    'set_code_item_id' => $formSetupCetakan->set_code_item_id,
                    'cav_code_item_id' => $formSetupCetakan->cav_code_item_id,
                    'status' => 'TERISI',
                ]);
            } else {
                PenomoranRak::create([
                    'rak' => $formSetupCetakan->rak,
                    'norak' => $formSetupCetakan->norak,
                    'list_code_item_id' => $formSetupCetakan->list_code_item_id,
                    'set_code_item_id' => $formSetupCetakan->set_code_item_id,
                    'cav_code_item_id' => $formSetupCetakan->cav_code_item_id,
                    'status' => 'TERISI',
                ]);
            }
        }
    }

    /**
     * Handle the FormSetupCetakan "updated" event.
     */
    public function updated(FormSetupCetakan $formSetupCetakan): void
    {
        $kategoriName = $formSetupCetakan->kategori ? $formSetupCetakan->kategori->name : null;
        $upperKategori = strtoupper(trim($kategoriName ?? ''));

        $history = HistoryCetakan::where('list_code_item_id', $formSetupCetakan->list_code_item_id)
            ->where('set_code_item_id', $formSetupCetakan->set_code_item_id)
            ->where('cav_code_item_id', $formSetupCetakan->cav_code_item_id)
            ->first();

        if ($history) {
            $history->update([
                'tanggal' => $formSetupCetakan->tanggal,
                'deskripsi' => $kategoriName,
            ]);
        } else {
            HistoryCetakan::create([
                'list_code_item_id' => $formSetupCetakan->list_code_item_id,
                'set_code_item_id' => $formSetupCetakan->set_code_item_id,
                'cav_code_item_id' => $formSetupCetakan->cav_code_item_id,
                'tanggal' => $formSetupCetakan->tanggal,
                'deskripsi' => $kategoriName,
            ]);
        }

        // Automatic Sync to CetakanNaik menu
        if ($upperKategori === 'SETUP CETAKAN NAIK' || str_contains($upperKategori, 'NAIK')) {
            CetakanNaik::updateOrCreate(
                ['list_mesin_id' => $formSetupCetakan->list_mesin_id],
                [
                    'list_code_item_id' => $formSetupCetakan->list_code_item_id,
                    'set_code_item_id' => $formSetupCetakan->set_code_item_id,
                    'cav_code_item_id' => $formSetupCetakan->cav_code_item_id,
                    'tanggalnaik' => $formSetupCetakan->tanggal,
                    'keterangan' => 'Produksi',
                    'note' => '-',
                ]
            );
        } elseif ($upperKategori === 'SETUP CETAKAN TURUN' || str_contains($upperKategori, 'TURUN')) {
            CetakanNaik::where('list_mesin_id', $formSetupCetakan->list_mesin_id)->delete();
        }

        if ($formSetupCetakan->rak && $formSetupCetakan->norak) {
            $penomoranRak = PenomoranRak::where('rak', $formSetupCetakan->rak)
                ->where('norak', $formSetupCetakan->norak)
                ->first();

            if ($penomoranRak) {
                $penomoranRak->update([
                    'list_code_item_id' => $formSetupCetakan->list_code_item_id,
                    'set_code_item_id' => $formSetupCetakan->set_code_item_id,
                    'cav_code_item_id' => $formSetupCetakan->cav_code_item_id,
                    'status' => 'TERISI',
                ]);
            } else {
                PenomoranRak::create([
                    'rak' => $formSetupCetakan->rak,
                    'norak' => $formSetupCetakan->norak,
                    'list_code_item_id' => $formSetupCetakan->list_code_item_id,
                    'set_code_item_id' => $formSetupCetakan->set_code_item_id,
                    'cav_code_item_id' => $formSetupCetakan->cav_code_item_id,
                    'status' => 'TERISI',
                ]);
            }
        }
    }

    /**
     * Handle the FormSetupCetakan "deleted" event.
     */
    public function deleted(FormSetupCetakan $formSetupCetakan): void
    {
        $kategoriName = $formSetupCetakan->kategori ? $formSetupCetakan->kategori->name : null;
        $upperKategori = strtoupper(trim($kategoriName ?? ''));

        if ($upperKategori === 'SETUP CETAKAN NAIK' || str_contains($upperKategori, 'NAIK')) {
            CetakanNaik::where('list_mesin_id', $formSetupCetakan->list_mesin_id)
                ->where('list_code_item_id', $formSetupCetakan->list_code_item_id)
                ->delete();
        }

        HistoryCetakan::where('list_code_item_id', $formSetupCetakan->list_code_item_id)
            ->where('set_code_item_id', $formSetupCetakan->set_code_item_id)
            ->where('cav_code_item_id', $formSetupCetakan->cav_code_item_id)
            ->where('deskripsi', $kategoriName)
            ->delete();

        $formSchedule = FormSchedule::where('list_code_item_id', $formSetupCetakan->list_code_item_id)
            ->where('list_mesin_id', $formSetupCetakan->list_mesin_id)
            ->first();

        if ($formSchedule) {
            $formSchedule->status = 'DIPROSES';
            $formSchedule->save();
        }

        if ($formSetupCetakan->rak && $formSetupCetakan->norak) {
            $penomoranRak = PenomoranRak::where('rak', $formSetupCetakan->rak)
                ->where('norak', $formSetupCetakan->norak)
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
    }

    /**
     * Handle the FormSetupCetakan "restored" event.
     */
    public function restored(FormSetupCetakan $formSetupCetakan): void
    {
        //
    }

    /**
     * Handle the FormSetupCetakan "force deleted" event.
     */
    public function forceDeleted(FormSetupCetakan $formSetupCetakan): void
    {
        //
    }
}

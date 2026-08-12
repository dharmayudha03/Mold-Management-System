<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CetakanNaikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timestamp = Carbon::now()->toDateString();
        $cetakanNaik = array(
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 54, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 55, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 56, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 61, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 123, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 124, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 125, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 126, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 127, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 128, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 129, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 130, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 131, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 132, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 133, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 134, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 2, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 3, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 4, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 5, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 6, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 22, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 23, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 24, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 25, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 26, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 28, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 30, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 31, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 32, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 33, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 35, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 36, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 37, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 38, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 39, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 40, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 41, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 42, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 43, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 44, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 46, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 47, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 48, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 49, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 50, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 51, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 52, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 53, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 63, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 64, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 67, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 68, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 69, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 70, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 71, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 73, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 74, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 75, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 76, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 77, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 78, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 79, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 80, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 81, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 82, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 83, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 98, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 100, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 112, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 113, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 114, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 115, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 116, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 117, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 118, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 118, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 120, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 121, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 122, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 135, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 136, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 137, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 138, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 141, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 142, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 143, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 144, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 145, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
            array('list_code_item_id' => null, 'set_code_item_id' => null, 'cav_code_item_id' => null, 'list_mesin_id' => 146, 'tanggalnaik' => null, 'keterangan' => 'Tidak Produksi', 'note' => '-', 'created_at' => $timestamp, 'updated_at' => $timestamp),
        );

        $inactiveListMesinIds = DB::table('mesins')->where('status', 'Tidak Aktif')->pluck('list_mesin_id')->toArray();
        if (!empty($inactiveListMesinIds)) {
            $cetakanNaik = array_values(array_filter($cetakanNaik, function($item) use ($inactiveListMesinIds) {
                return !in_array($item['list_mesin_id'], $inactiveListMesinIds);
            }));
        }

        DB::table('cetakan_naiks')->insert($cetakanNaik);
    }
}

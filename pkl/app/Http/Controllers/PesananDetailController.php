<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Response;

class PesananDetailController extends Controller
{
    public function index(Request $request) {
        if ($request->has('search')) {

            $tahun = $request->input('search');
            $menus = Menu::where('kategori', 'makanan')
                         ->orWhere('kategori', 'minuman')
                         ->get();

            $dataMakanan = [];
            $dataMinuman = [];
            $grandTotalHarga = array_fill(0, 12, 0);

            foreach ($menus as $menu) {
                $rowData = [];
                $rowData[] = $menu->nama;
                $hargaBulan = [];

                for ($i = 1; $i <= 12; $i++) {
                    $totalHarga = PesananDetail::whereHas('pesanan', function ($query) use ($i, $tahun) {
                        $query->whereMonth('tanggal', $i)->whereYear('tanggal', $tahun);
                    })->where('m_menu_id', $menu->id)->sum('total');

                    $hargaBulan[] = $totalHarga;
                    $grandTotalHarga[$i - 1] += $totalHarga;
                }
                
                $formatHargaBulan = array_map(function ($harga) {
                    return number_format($harga, 0, ',', '.');
                }, $hargaBulan);
                
                $rowData = array_merge($rowData, $formatHargaBulan);
                $totalHargaMenu = array_sum($hargaBulan);

                $formatTotalHargaMenu = number_format($totalHargaMenu, 0, ',', '.');

                $rowData[] = $formatTotalHargaMenu;

                if ($menu->kategori === 'makanan') {
                    $dataMakanan[] = $rowData;
                } else {
                    $dataMinuman[] = $rowData;
                }
            }

            $grandTotalPesananDetail = PesananDetail::whereHas('pesanan', function ($query) use ($tahun) {
                $query->whereYear('tanggal', $tahun);
            })->sum('total');

            $formatGrandTotalPesananDetail = number_format($grandTotalPesananDetail, 0, ',', '.');

            return view('home', compact('dataMakanan', 'dataMinuman', 'grandTotalHarga', 'formatGrandTotalPesananDetail', 'tahun'));
            
        } else {
            return view('home');
        }
    }

    public function exportCsv(Request $request) {

        $tahun = $request->input('search');
        $menus = Menu::where('kategori', 'makanan')
                    ->orWhere('kategori', 'minuman')
                    ->get();

        $dataMakanan = [];
        $dataMinuman = [];
        $grandTotalHarga = array_fill(0, 12, 0);

        foreach ($menus as $menu) {
            $rowData = [];
            $rowData[] = $menu->nama;
            $hargaBulan = [];

            for ($i = 1; $i <= 12; $i++) {
                $totalHarga = PesananDetail::whereHas('pesanan', function ($query) use ($i, $tahun) {
                    $query->whereMonth('tanggal', $i)->whereYear('tanggal', $tahun);
                })->where('m_menu_id', $menu->id)->sum('total');

                $hargaBulan[] = $totalHarga;
                $grandTotalHarga[$i - 1] += $totalHarga;
            }

            $formatHargaBulan = array_map(function ($harga) {
                return number_format($harga, 0, ',', '.');
            }, $hargaBulan);

            $rowData = array_merge($rowData, $formatHargaBulan);
            $totalHargaMenu = array_sum($hargaBulan);

            $formatTotalHargaMenu = number_format($totalHargaMenu, 0, ',', '.');
            $rowData[] = $formatTotalHargaMenu;

            if ($menu->kategori === 'makanan') {
                $dataMakanan[] = $rowData;
            } else {
                $dataMinuman[] = $rowData;
            }
        }

        $grandTotalPesananDetail = PesananDetail::whereHas('pesanan', function ($query) use ($tahun) {
            $query->whereYear('tanggal', $tahun);
        })->sum('total');
        $formatGrandTotalPesananDetail = number_format($grandTotalPesananDetail, 0, ',', '.');

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=laporan_penjualan_$tahun.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $response = new StreamedResponse(function () use ($dataMakanan, $dataMinuman, $grandTotalHarga, $formatGrandTotalPesananDetail, $tahun) {
            $handle = fopen('php://output', 'w');

            $delimiter = ';';
            fputcsv($handle, ['Menu', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des', 'Total'], $delimiter);

            foreach ($dataMakanan as $row) {
                fputcsv($handle, $row, $delimiter);
            }

            foreach ($dataMinuman as $row) {
                fputcsv($handle, $row, $delimiter);
            }

            fputcsv($handle, array_merge(['Grand Total'], $grandTotalHarga, [$formatGrandTotalPesananDetail]), $delimiter);
        
            fclose($handle);
        }, 200, $headers);

        return $response;
    }
}

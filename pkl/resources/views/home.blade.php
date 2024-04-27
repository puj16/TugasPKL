@extends('master')

@section('title', 'Laporan')

@section('content')

<div class="container">
    <div class="card mt-3 mb-3">
        <div class="card-header">
            Laporan Penjualan Tahunan
        </div>
        <div>
            <div class="ms-4 me-4">
                <div class="row g-3 mt-2">
                    <form class="col-auto row g-2">
                        <div class="col-auto">
                            <input type="text" class="form-control" name="search" id="search" placeholder="Pilih Tahun" value="{{ isset($tahun) ? $tahun : '' }}">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary" id="tampil">Tampilkan</button>
                        </div>
                    </form>
                    
                    <div class="col-auto">
                        <button type="button" class="btn btn-success" id="download" data-tahun="{{ isset($tahun) ? $tahun : '' }}">Download Database</button>
                    </div>
                </div>               

                <hr>

                @if(!empty($dataMakanan) || !empty($dataMinuman))
                <div id="table-container mt-2">
                    <table class="table table-bordered" style="font-size: 11px;">
                        <thead class="table-dark" style="text-align: center; vertical-align: middle;">
                            <tr>
                                <td rowspan="2" style="width: 150px;">Menu</td>
                                <td colspan="12">Periode Pada </td>
                                <td rowspan="2">Total</td>
                            </tr>
                            <tr>
                                <td>Jan</td>
                                <td>Feb</td>
                                <td>Mar</td>
                                <td>Apr</td>
                                <td>Mei</td>
                                <td>Jun</td>
                                <td>Jul</td>
                                <td>Ags</td>
                                <td>Sep</td>
                                <td>Okt</td>
                                <td>Nov</td>
                                <td>Des</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table-secondary">
                                <th colspan="14">Makanan</th>
                            </tr>
                            @foreach($dataMakanan as $row)
                                <tr>
                                    @foreach($row as $cell)
                                        <td>{{ $cell }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                            <tr class="table-secondary">
                                <th colspan="14">Minuman</th>
                            </tr>
                            @foreach($dataMinuman as $row)
                                <tr>
                                    @foreach($row as $cell)
                                        <td>{{ $cell }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                            <tr class="table-dark">
                                <th>Grand Total</th>
                                @foreach($grandTotalHarga as $total)
                                    <td>{{ number_format($total, 0, ',', '.') }}</td>
                                @endforeach
                                <td>{{ $formatGrandTotalPesananDetail }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endif
            </div>                                       
        </div>
    </div>
</div>

@endsection
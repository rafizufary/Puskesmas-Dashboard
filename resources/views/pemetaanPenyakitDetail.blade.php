@extends('layout.layout')
@section('pemetaan', 'active')
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Detail Persebaran Penyakit</h4>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                @if(Auth::user()->level != 'super_admin')
                                    @if ($kecamatan)
                                        <h4 class="card-title">Persebaran penyakit poli {{Auth()->user()->poli->nama_poli}} di daerah {{ $kecamatan->name }}</h4>
                                    @endif
                                @else
                                    @if ($kecamatan)
                                        <h4 class="card-title">Persebaran penyakit Keseluruhan di daerah {{ $kecamatan->name }}</h4>
                                    @endif
                                @endif
                                {{-- <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#modalAddpetugas">
                                    <i class="fa fa-plus"></i>
                                    Tambah Petugas
                                </button> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- <a href="{{ route('exportDataPemetaan', ['name' => $kecamatan->name]) }}" class="btn btn-success mb-3">Export</a> --}}
                            <div class="table-responsive">
                                <table id="add-row" class="display table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Penyakit</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                         $no =1;   
                                        @endphp
                                        @foreach ($datapemetaan as $row)
                                            
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$row->nama_diagnosa}}</td>
                                            <td>{{$row->total}}</td>
                                         

                                        </tr>

                                        @endforeach
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


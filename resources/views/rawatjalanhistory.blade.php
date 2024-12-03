@extends('layout.layout')
@section('historyRawatJalan', 'active')
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">HISTORY RAWAT JALAN</h4>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Daftar History Rawat Jalan</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="add-row" class="display table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIK</th>
                                            <th>Pasien</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Diagnosa</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                         $no =1;   
                                        @endphp
                                        @foreach ($data as $row)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$row->pasien->pasien->nik_pasien}}</td>
                                            <td>{{$row->pasien->pasien->nama_pasien}}</td>
                                            <td>{{date('d-m-Y', strtotime($row->pasien->pasien->tgl_lahir))}}</td>
                                            <td>{{$row->diagnosa->nama_diagnosa}}</td>
                                            <td>
                                                <a href="{{ url('historyrawatjalan/rawatjalanhistorydetail/'.$row->id_pasien.'/'.$row->id_diagnosa)  }}" class="btn btn-success btn-sm">Detail</a>
                                            </td>
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
</div>

@endsection


@extends('layout.layout')
@section('historyRawatJalan', 'active')
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">DETAIL HISTORY RAWAT JALAN</h4>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Daftar Detail History Rawat Jalan</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('detailExport', ['id_pasien' => $id_pasien, 'id_diagnosa' => $id_diagnosa]) }}" class="btn btn-success mb-3">Export</a>
                            <div class="table-responsive">
                                <table id="add-row" class="display table tbl_detail">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIK</th>
                                            <th>Pasien</th>
                                            <th>Usia</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Diagnosa</th>
                                            <th>Tanggal Periksa</th>
                                            <th>Tanggal Kontrol</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                         $no =1;   
                                        @endphp
                                        
                                            @foreach($detailData as $row)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $row->pasien->pasien->nik_pasien }}</td>
                                            <td>{{ $row->pasien->pasien->nama_pasien }}</td>
                                            <td><?php $usia = date_diff(date_create($row->pasien->pasien->tgl_lahir),date_create('now'))->y;?>
                                                {{$usia}} </td>
                                            <td>{{date('d-m-Y', strtotime($row->pasien->pasien->tgl_lahir))}}</td>
                                            <td>{{$row->diagnosa->nama_diagnosa}}</td>
                                            <td>{{date('d-m-Y', strtotime($row->tgl_periksa))}}</td>
                                            <td>{{date('d-m-Y', strtotime($row->tgl_control))}}</td>
                                            <td>{{$row->status}}</td>
                                            

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


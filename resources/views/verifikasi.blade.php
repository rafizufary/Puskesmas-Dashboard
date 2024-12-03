@extends('layout.layout')
@section('verifikasi', 'active')
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Menu Verifikasi</h4>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Verifikasi Pasien</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- <a href="{{Route('exportPoli')}}" class="btn btn-success mb-3">Export</a> --}}
                            <div class="table-responsive">
                                <table id="add-row" class="display table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Usia</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                         $no =1;   
                                        @endphp
                                        @foreach($data as $row)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{ $row->nik_pasien }}</td>
                                            <td>{{ $row->nama_pasien }}</td>
                                            <td><?php $usia = date_diff(date_create($row->tgl_lahir),date_create('now'))->y;?>
                                                {{$usia}}  </td>
                                            <td>{{ $row->jenis_kelamin }}</td>
                                            <td>
                                                <a href="#modalHapuspasien{{$row->id}}" data-toggle="modal" class="btn btn-success btn-sm"><i class="fas fa-address-book"></i> Hapus</a>
                                                <a href="#modalDetailpasien{{$row->id}}" data-toggle="modal" class="btn btn-success btn-sm"><i class="fas fa-address-book"></i> Detail</a>
                                                <a href="#modalVerifikasi{{$row->id}}" data-toggle="modal" class="btn btn-primary btn-sm"><i class="fas fa-address-book"></i> Verifikasi</a>
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
<!-- modal detail pasien -->
@foreach($data as $d)
<div class="modal fade" id="modalDetailpasien{{ $d->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Detail pasien</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>  

            <div class="modal-body">
                <div class="table-responsive">
                    <table class="display table  table-hover">
                        <tr>
                            <th>NIK</th>
                            <td>{{$d->nik_pasien}}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{$d->nama_pasien}}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{$d->jenis_kelamin}}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td>{{date('d-m-Y', strtotime($d->tgl_lahir))}}</td>
                        </tr>
                        <tr>
                            <th>Usia</th>
                            <td>    
                            <?php 
                                $usia = date_diff(date_create($d->tgl_lahir),date_create('now'))->y;
                            ?>
                            {{$usia}}    
                            </td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{$d->alamat}}</td>
                        </tr>
                        <tr>
                            <th>Rt</th>
                            <td>{{$d->rt}}</td>
                        </tr>
                        <tr>
                            <th>Rw</th>
                            <td>{{$d->rw}}</td>
                        </tr>
                        <tr>
                            <th>Provinsi</th>
                            <td>{{$d->provinsi}}</td>
                        </tr>
                        <tr>
                            <th>Kabupaten/kota</th>
                            <td>{{$d->kota}}</td>
                        </tr>
                        <tr>
                            <th>Kecamatan</th>
                            <td>{{$d->kecamatan}}</td>
                        </tr>
                        <tr>
                            <th>Kelurahan</th>
                            <td>{{$d->kelurahan}}</td>
                        </tr>
                        <tr>
                            <th>No Telepon</th>
                            <td>{{$d->notelepon}}</td>
                        </tr>
                        <tr>
                            <th>No BPJS</th>
                            <td>{{$d->no_bpjs}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

{{-- Verifikasi --}}
@foreach($data as $d)
<div class="modal fade" id="modalVerifikasi{{$d->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Verifikasi pasien {{ $d->nama_pasien }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>  

            <form action="{{ route('verifikasi', $d->id) }}" enctype="multipart/form-data" method="GET">
                @csrf 
                <div class="modal-body">
                    <input type="hidden" value="{{$d->id}}" name="id" required>

                    <div class="form-group">
                        <h4>Apakah Anda Ingin Memverifikasi Data Pasien ini?</h4>
                    </div>
                    @if(auth()->user()->level == "super_admin")
                    <div class="form-group">
                        <label>PilihPoli Pasien Yang Akan Diverifikasi</label>
                        <select name="id_poli" class="form-control" required>
                            <option value="" hidden="">--pilih poli--</option>
                            @foreach($poli as $row)
                            <option value="{{ $row->id }}">{{ $row->nama_poli }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-undo"></i> Close</button>
                    <button type="submit" class="btn btn-primary">Verifikasi</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endforeach

{{-- Hapus --}}
@foreach($data as $d)
<div class="modal fade" id="modalHapuspasien{{$d->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Hapus pasien {{ $d->nama_pasien }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>  

            <form action="{{ route('hapus-pasien', $d->id) }}" enctype="multipart/form-data" method="GET">
                @csrf 
                <div class="modal-body">
                    <input type="hidden" value="{{$d->id}}" name="id" required>

                    <div class="form-group">
                        <h4>Apakah Anda Ingin Menghapus Data Pasien ini?</h4>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-undo"></i> Close</button>
                    <button type="submit" class="btn btn-primary">Hapus</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endforeach

@endsection

@extends('layout.layout')
@section('rawatJalan', 'active')
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">DETAIL RAWAT JALAN</h4>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Daftar Pasien</h4>
                                {{-- <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#modalAddpetugas">
                                    <i class="fa fa-plus"></i>
                                    Tambah Petugas
                                </button> --}}
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="add-row" class="display table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIK</th>
                                            {{-- <th>Petugas</th> --}}
                                            <th>Pasien</th>
                                            <th>Diagnosa</th>
                                            <th>Tanggal Periksa</th>
                                            <th>Tanggal Kontrol</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                         $no =1;   
                                        @endphp
                                        @foreach ($detail as $row)
                                            
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$row->nik_pasien}}</td>
                                            {{-- <td>{{$row->id_user->name}}</td> --}}
                                            <td>{{$row->nama_pasien}}</td>
                                            <td>{{$row->nama_diagnosa}}</td>
                                            <td>{{date('d-m-Y', strtotime($row->tgl_periksa))}}</td>
                                            <td>{{date('d-m-Y', strtotime($row->tgl_control))}}</td>
                                            <td>
                                            <a href="#modalEditTanggal{{$row->id}}" data-toggle="modal" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i>Edit</a>
                                            <!-- <a href="#modalHapusPasien{{$row->id}}" data-toggle="modal" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>Selesai</a> -->
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

@foreach($detail as $d)
<div class="modal fade" id="modalEditTanggal{{ $d->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Tanggal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('rawatjalan.update',$d->id) }}" enctype="multipart/form-data" method="POST">
                @csrf 
            <div class="modal-body">


                <div class="form-group">
                    <label>Diagnosa</label>
                    <select name="diagnosa" class="form-control" required>
                        {{-- <option value="{{$d->diagnosa->id}}">{{$d->diagnosa->kode_diagnosa}} - {{$d->diagnosa->nama_diagnosa}}</option> --}}
                        {{-- @foreach ($diagnosa as $item)
                            <option value="{{ $item->id }}" @if($item->id == $d->kode_diagnosa)@endif> {{ $item->kode_diagnosa }} - {{ $item->nama_diagnosa }} </option>
                        @endforeach --}}
                        @foreach ($diagnosa as $item)
                            <option value="{{ $item->id }}" @if($item->kode_diagnosa==$d->kode_diagnosa) selected @endif> {{ $item->kode_diagnosa }} - {{ $item->nama_diagnosa }} </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Tanggal Kontrol</label>
                    <input type="text" name="tgl_control" value="{{ $d->tgl_control }}" class="form-control input_tanggal" placeholder="Tanggal Kontrol..." required>
                </div>
                </div>

                <div class="modal-footer">
                    <a href="{{ route('rawatjalan.selesai', $d->id) }}" class="btn btn-secondary">Selesai</a>
                    <button type="button" class="btn btn-danger"  data-dismiss="modal"><i class="fa fa-undo"></i> Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>

            </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach($detail as $g)
<div class="modal fade" id="modalHapusPasien{{$g->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit poli</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>  

            <form action="{{ route('rawatjalan.destroy',$g->id) }}" enctype="multipart/form-data" method="GET">
                @csrf 
            <div class="modal-body">

                <input type="hidden" value="{{$g->id}}" name="id" required>

                <div class="form-group">
                    <h4>Apakah Anda Ingin Menyelesaikan ini?</h4>
                </div>

               
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-undo"></i> Close</button>
                <button type="submit" class="btn btn-primary">Selesai</button>
                </div>

            </form>
            </div>
        </div>
    </div>

</div>
@endforeach


@endsection


@extends('layout.layout')
@section('diagnosa', 'active')
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Menu diagnosa</h4>
                
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            
                            <div class="d-flex align-items-center">
                                <!-- <h4 class="card-title">Daftar Diagnosa</h4> -->
                                @if(Auth::user()->level == 'super_admin')
                                    <h4 class="card-title">Daftar Keseluruhan Diagnosa</h4>
								@else
									<h4 class="card-title">Daftar Diagnosa Penyakit Poli {{ Auth()->user()->poli->nama_poli }}</h4>
								@endif
                                <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#modalAdddiagnosa">
                                    <i class="fa fa-plus"></i>
                                    Tambah Diagnosa
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                        <a href="{{Route('exportDiagnosa')}}" class="btn btn-success mb-3">Export</a>
                            <div class="table-responsive">
                                <table id="add-row" class="display table">
                                    <thead>
                                        <tr>
                                            <th>Nomer</th>
                                            <th>Poli</th>
                                            <th>Kode Diagnosa</th>
                                            <th>Nama Diagnosa</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                         $no =1;   
                                        @endphp
                                        @foreach ($diagnosa as $row)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$row->poli->nama_poli}}</td>
                                            <td>{{$row->kode_diagnosa}}</td>
                                            <td>{{$row->nama_diagnosa}}</td>
                                            <td>
                                            <a href="#modalEditdiagnosa{{$row->id}}" data-toggle="modal" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>Edit</a>
                                            <a href="#modalHapusdiagnosa{{$row->id}}" data-toggle="modal" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>Hapus</a>
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


<div class="modal fade" id="modalAdddiagnosa" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Tambah diagnosa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('diagnosa.store') }}" enctype="multipart/form-data" method="POST">
                @csrf 
            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Diagnosa</label>
                    <input type="text" name="kode_diagnosa" class="form-control" placeholder="Kode Diagnosa..." required>
                </div>

                <div class="form-group">
                    <label>Nama Diagnosa</label>
                    <input type="text" name="nama_diagnosa" class="form-control" placeholder="Nama Diagnosa..." required>
                </div>
                @if(auth()->user()->level == "super_admin")
                <div class="form-group">
                    <label>Pilih Poli</label>
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
                <button type="submit" class="btn btn-primary">Save changes</button>
                </div>

            </form>
            </div>
        </div>
    </div>

</div>

@foreach($diagnosa as $d)
<div class="modal fade" id="modalEditdiagnosa{{ $d->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit diagnosa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>  

            <form action="{{ route('diagnosa.update', $d->id) }}" enctype="multipart/form-data" method="POST">
                @csrf 
            <div class="modal-body">

                <input type="hidden" value="{{$d->id}}" name="id" required>

                <div class="form-group">
                    <label>Kode Diagnosa</label>
                    <input type="text" value="{{$d->kode_diagnosa}}" name="kode_diagnosa" class="form-control" placeholder="Kode Diagnosa..." required>
                </div>

                <div class="form-group">
                    <label>Nama Diagnosa</label>
                    <input type="text" value="{{$d->nama_diagnosa}}" name="nama_diagnosa" class="form-control" placeholder="Nama Diagnosa..." required>
                </div>

                @if(auth()->user()->level == "super_admin")
                <div class="form-group">
                    <label>Pilih Poli</label>
                    <select name="id_poli" class="form-control" required>
                        <option value="" hidden="">--pilih poli--</option>
                        @foreach($poli as $row)
                        <option value="{{ $row->id }}" @if($row->id==$d->id_poli) selected @endif>{{ $row->nama_poli }}</option>
                        @endforeach
                    </select>
                </div>
                @endif


            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-undo"></i> Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </div>

            </form>
            </div>
        </div>
    </div>

    </div>
@endforeach

@foreach($diagnosa as $g)
<div class="modal fade" id="modalHapusdiagnosa{{$g->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Hapus diagnosa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>  

            <form action="{{ route('diagnosa.destroy', $g->id) }}" enctype="multipart/form-data" method="GET">
                @csrf 
            <div class="modal-body">

                <input type="hidden" value="{{$g->id}}" name="id" required>

                <div class="form-group">
                    <h4>Apakah Anda Ingin Menghapus Data ini?</h4>
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

</div>
@endforeach

@endsection

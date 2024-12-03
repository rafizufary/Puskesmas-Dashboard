@extends('layout.layout')
@section('poli', 'active')
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Menu Poli</h4>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Daftar Poli</h4>
                                <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#modalAddpoli">
                                    <i class="fa fa-plus"></i>
                                    Tambah Poli
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <a href="{{Route('exportPoli')}}" class="btn btn-success mb-3">Export</a>
                            <div class="table-responsive">
                                <table id="add-row" class="display table">
                                    <thead>
                                        <tr>
                                            <th>Nomer</th>
                                            <th>Kode Poli</th>
                                            <th>Nama Poli</th>
                                            @if (auth()->user()->level == 'super_admin')
                                            <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                         $no =1;   
                                        @endphp
                                        @foreach ($poli as $row)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$row->kode_poli}}</td>
                                            <td>{{$row->nama_poli}}</td>
                                            @if (auth()->user()->level == 'super_admin')
                                            <td>
                                            <a href="#modalEditpoli{{$row->id}}" data-toggle="modal" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>Edit</a>
                                            <a href="#modalHapuspoli{{$row->id}}" data-toggle="modal" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>Hapus</a>
                                            </td>
                                            @endif
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


<div class="modal fade" id="modalAddpoli" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Tambah poli</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('poli.store') }}" enctype="multipart/form-data" method="POST">
                @csrf 
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode poli</label>
                        <input type="text" name="kode_poli" class="form-control" placeholder="Kode poli..." required>
                    </div>

                    <div class="form-group">
                        <label>Nama poli</label>
                        <input type="text" name="nama_poli" class="form-control" placeholder="Nama poli..." required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-undo"></i> Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>

            </form>
            </div>
        </div>
    </div>

</div>

@foreach($poli as $d)
<div class="modal fade" id="modalEditpoli{{ $d->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit poli</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>  

            <form action="{{ route('poli.update', $d->id) }}" enctype="multipart/form-data" method="POST">
                @csrf 
            <div class="modal-body">

                <input type="hidden" value="{{$d->id}}" name="id" required>

                <div class="form-group">
                    <label>Kode poli</label>
                    <input type="text" value="{{$d->kode_poli}}" name="kode_poli" class="form-control" placeholder="Kode poli..." required>
                </div>

                <div class="form-group">
                    <label>Nama poli</label>
                    <input type="text" value="{{$d->nama_poli}}" name="nama_poli" class="form-control" placeholder="Nama poli..." required>
                </div>


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

@foreach($poli as $g)
<div class="modal fade" id="modalHapuspoli{{$g->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Hapus poli</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>  

            <form action="{{ route('poli.destroy', $g->id) }}" enctype="multipart/form-data" method="GET">
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

@extends('layout.layout')
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Menu Petugas</h4>
                
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Daftar Petugas</h4>
                                <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#modalAddpetugas">
                                    <i class="fa fa-plus"></i>
                                    Tambah Petugas
                                </button>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="add-row" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nomer</th>
                                            <th>Id Petugas</th>
                                            <th>Nama Petugas</th>
                                            <th>Jabatan</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                         $no =1;   
                                        @endphp
                                        @foreach ($petugas as $row)
                                            
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$row->id_petugas}}</td>
                                            <td>{{$row->nama_petugas}}</td>
                                            <td>{{$row->jabatan}}</td>
                                            <td>
                                            <a href="#modalEditpetugas{{$row->id}}" data-toggle="modal" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>Edit</a>
                                            <a href="#modalHapuspetugas{{$row->id}}" data-toggle="modal" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>Hapus</a>
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


<div class="modal fade" id="modalAddpetugas" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Tambah Petugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="/petugas/store" enctype="multipart/form-data" method="POST">
                @csrf 
            <div class="modal-body">
                <div class="form-group">
                    <label>Id Petugas</label>
                    <input type="number" name="id_petugas" class="form-control" placeholder="Kode petugas..." required>
                </div>

                <div class="form-group">
                    <label>Nama Petugas</label>
                    <input type="text" name="nama_petugas" class="form-control" placeholder="Nama petugas..." required>
                </div>

                <div class="form-group">
                    <label>Jabatan</label>
                    <input type="text" name="jabatan" class="form-control" placeholder="jabatan..." required>
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

@foreach($petugas as $d)
<div class="modal fade" id="modalEditpetugas{{ $d->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Petugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>  

            <form action="/petugas/{{$d->id}}/update" enctype="multipart/form-data" method="POST">
                @csrf 
            <div class="modal-body">

                <input type="hidden" value="{{$d->id}}" name="id" required>

                <div class="form-group">
                    <label>Id Petugas</label>
                    <input type="text" value="{{$d->id_petugas}}" name="id_petugas" class="form-control" placeholder="Id petugas..." required>
                </div>

                <div class="form-group">
                    <label>Nama Petugas</label>
                    <input type="text" value="{{$d->nama_petugas}}" name="nama_petugas" class="form-control" placeholder="Nama petugas..." required>
                </div>

                <div class="form-group">
                    <label>Jabatan</label>
                    <input type="text" value="{{$d->jabatan}}" name="jabatan" class="form-control" placeholder="Jabatan..." required>
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
@endforeach

@foreach($petugas as $g)
<div class="modal fade" id="modalHapuspetugas{{$g->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Petugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>  

            <form action="/petugas/{{$g->id}}/destroy" enctype="multipart/form-data" method="GET">
                @csrf 
            <div class="modal-body">

                <input type="hidden" value="{{$g->id}}" name="id" required>

                <div class="form-group">
                    <h4>Apakah Anda Ingin Menghapus Data ini?</h4>
                </div>

               
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-undo"></i> Close</button>
                <button type="submit" class="btn btn-primary">Hapus</button>
                </div>

            </form>
            </div>
        </div>
    </div>

</div>
@endforeach

@endsection

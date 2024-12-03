@extends('layout.layout')
@section('user', 'active')
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Menu User</h4>
                
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Daftar User</h4>
                                <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#modalAddUser">
                                    <i class="fa fa-plus"></i>
                                    Tambah User
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                        <a href="{{ Route('exportUser') }}" class="btn btn-success mb-3">Export</a>
                            <div class="table-responsive">
                                <table id="add-row" class="display table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Level</th>
                                            <th>Poli</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                         $no =1;   
                                        @endphp
                                        @foreach ($user as $row)
                                            
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$row->name}}</td>
                                            <td>{{$row->email}}</td>
                                            <td>{{$row->level}}</td>
                                            <td>{{$row->poli->nama_poli}}</td>
                                            <td>
                                            <a href="#modalEditUser{{$row->id}}" data-toggle="modal" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>Edit</a>
                                            <a href="#modalHapusUser{{$row->id}}" data-toggle="modal" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>Hapus</a>
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


<div class="modal fade" id="modalAddUser" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('user.store') }}" enctype="multipart/form-data" method="POST">
                @csrf 
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" placeholder="Nama Lengkap..." required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Email..." required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password..." minlength="8" required>
                </div>

                <div class="form-group">
                    <label>Level</label>
                    <select name="level" class="form-control" required>
                        <option value="" hidden="">--pilih level--</option>
                        <option value="super_admin">Super Admin</option>
                        <option value="admin">Admin</option>

                    </select>

                </div>

                <div class="form-group">
                    <label>Poli</label>
                    <select name="poli" class="form-control" required>
                        <option value="" hidden="">--pilih level--</option>

                        @foreach ($poli as $item)
                        <option value={{$item->id}}>{{$item->nama_poli}}</option>
                        @endforeach

                    </select>

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

@foreach($user as $d)
<div class="modal fade" id="modalEditUser{{ $d->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>  

            <form action="{{ route('user.update',  $d->id ) }}" enctype="multipart/form-data" method="POST">
                @csrf 
            <div class="modal-body">

                <input type="hidden" value="{{$d->id}}" name="id" required>

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" value="{{$d->name}}" name="name" class="form-control" placeholder="Nama Lengkap..." required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" value="{{$d->email}}" name="email" class="form-control" placeholder="Email..." required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" value="" name="password" class="form-control" placeholder="Password..." minlength="8" required>
                </div>

                <div class="form-group">
                    <label>Level</label>
                    <select name="level" class="form-control" required>
                        <option value="" hidden="">--pilih level--</option>
                        <option value="super_admin" {{ ($d->level === 'super_admin') ? 'selected' : '' }}>Super Admin</option>
                        <option value="admin" {{ ($d->level === 'admin') ? 'selected' : '' }}>Admin</option>

                    </select>

                </div>

                <div class="form-group">
                    <label>Poli</label>
                    <select name="poli" class="form-control" required>
                        <option value="" hidden="">--pilih level--</option>
                        @foreach ($poli as $item)
                        <option value={{$item->id}} {{ ($item->id === $d->id_poli) ? 'selected' : '' }}>{{$item->nama_poli}}</option>
                        @endforeach

                    </select>

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

@foreach($user as $g)
<div class="modal fade" id="modalHapusUser{{$g->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Hapus User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>  

            <form action="{{ route('user.destroy', $d->id) }}" enctype="multipart/form-data" method="GET">
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

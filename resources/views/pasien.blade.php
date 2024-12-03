@extends('layout.layout')
@section('pasien', 'active')
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Menu pasien</h4>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <!-- <h4 class="card-title" id="table-title">Daftar pasien</h4> -->
                                @if(Auth::user()->level == 'super_admin')
                                    <h4 class="card-title">Daftar Keseluruhan Pasien</h4>
								@else
									<h4 class="card-title">Daftar Pasien Poli {{ Auth()->user()->poli->nama_poli }}</h4>
								@endif
                                <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#modalAddpasien">
                                    <i class="fa fa-plus"></i>
                                    Tambah pasien
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                        <a href="{{Route('exportPasien')}}" class="btn btn-success mb-3">Export</a>
                            <div class="table-responsive">
                                <table id="add-row" class="display table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nik</th>
                                            <th>Nama</th>
                                            <th>Poli</th>
                                            <th>Usia</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                         $no =1;   
                                        @endphp
                                        @foreach ($pasien as $row)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$row->pasien->nik_pasien}}</td>
                                            <td>{{$row->pasien->nama_pasien}}</td>
                                            <td>{{$row->datapoli->nama_poli}}</td>
                                            <td><?php $usia = date_diff(date_create($row->pasien->tgl_lahir),date_create('now'))->y;?>
                                                {{$usia}}  
                                            </td>
                                            <td>{{$row->pasien->jenis_kelamin}}</td>
                                            <td>
                                            {{-- <a href="#modalEditpasien{{$row->id}}" data-toggle="modal" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a> --}}
                                            <a href="{{ route('editPasien', $row->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a> 
                                            <a href="#modalDetailpasien{{$row->id}}" data-toggle="modal" class="btn btn-success btn-sm"><i class="fas fa-address-book"></i> Detail</a>
                                            <a href="#modalHapuspasien{{$row->id}}" data-toggle="modal" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</a>
                                            <!-- <a href="{{ route('editPasien', $row->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Tes Edit</a> -->
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


<div class="modal fade" id="modalAddpasien" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Tambah Pasien</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('pasien.store') }}" enctype="multipart/form-data" method="POST">
                @csrf 
            <div class="modal-body">
                <div class="form-group">
                    <label>Nik Pasien</label>
                    <input type="number" id="nik_input" name="nik_pasien" class="form-control" placeholder="Nik Pasien..." required>
                </div>

                <div class="form-group">
                    <label>Nama Pasien</label>
                    <input type="text" id="nama_input" name="nama_pasien" class="form-control" placeholder="Nama Pasien..." required>
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                        <option value="" hidden="">--pilih Jenis Kelamin--</option>
                        <option value="laki-laki">Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="text" id="tgl_lahir" name="tanggal_lahir" class="form-control input_tanggal" placeholder="Tanggal Lahir..." required>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" id="alamat" name="alamat" class="form-control" placeholder="Alamat..." required>
                </div>

                <div class="form-group">
                    <label>Rt</label>
                    <select name="rt" id="rt" class="form-control" required>
                        <option value="" hidden="">--pilih Rt--</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Rw</label>
                    <select name="rw" id="rw" class="form-control" required>
                        <option value="" hidden="">--pilih Rw--</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Provinsi</label>
                    <select class="form-control provinsi" id="provinsi" name="provinsi">
                        <option>Pilih Provinsi</option>
                        @foreach ($provinces as $provinsi)
                            <option value="{{$provinsi->id}}">{{$provinsi->name}}</option>
                        @endforeach
                    </select>
                </div>
        
                 <div class="form-group">
                    <label for="exampleFormControlSelect1">Kabupaten</label>
                        <select name="kabupaten" id="kabupaten" class="form-control kabupaten" required >

                        </select>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlSelect1">Kecamatan</label>
                        <select name="kecamatan" id="kecamatan" class="form-control" required >

                        </select>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlSelect1">Kelurahan</label>
                        <select name="datakelurahan" id="kelurahan" class="form-control" required >

                        </select>
                </div>

                <div class="form-group">
                    <label>No Telepon</label>
                    <input type="number" id="notelepon" name="notelepon" class="form-control" placeholder="No telepon..." required>
                </div>

                <div class="form-group">
                    <label>No Bpjs</label>
                    <input type="number" id="no_bpjs" name="no_bpjs" class="form-control" placeholder="No Bpjs...">
                </div>

                @if(auth()->user()->level == "super_admin")
                    <div class="form-group">
                        <label>Poli</label>
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

@foreach($pasien as $d)
<div class="modal fade" id="modalEditpasien{{ $d->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit pasien</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>  

            {{-- menjalankan proses update ke alamat update pasien --}}
            <form action="{{ route('pasien.update', $d->id) }}" enctype="multipart/form-data" method="POST">
                @csrf 
                <div class="modal-body">

                    <input type="hidden" value="{{$d->id}}" name="id" required>

                    <div class="form-group">
                        <label>Nik Pasien</label>
                        <input type="number" value="{{$d->nik_pasien}}" name="nik_pasien" class="form-control" placeholder="Nik Pasien..." required>
                    </div>

                    <div class="form-group">
                        <label>Nama Pasien</label>
                        <input type="text" value="{{$d->nama_pasien}}" name="nama_pasien" class="form-control" placeholder="Nama Pasien..." required>
                    </div>

                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control" required>
                            <option value="" hidden="">--pilih Jenis Kelamin--</option>
                            <option value="laki-laki" {{($d->jenis_kelamin === 'laki-laki') ? 'Selected' : ''}}>Laki-Laki</option>
                            <option value="Perempuan" {{($d->jenis_kelamin === 'perempuan') ? 'Selected' : ''}}>Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="text" value="{{$d->tgl_lahir}}" name="tgl_lahir" class="form-control input_tanggal" placeholder="Tanggal Lahir..." required>
                    </div>

                    <!-- <div class="form-group">
                        <label>Usia</label>
                        <?php $usia = date_diff(date_create($d->tgl_lahir),date_create('now'))->y;?>
                        <input disabled type="number" value="{{$usia}}" name="usia" class="form-control" placeholder="Usia..."required>
                    </div> -->

                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" value="{{$d->alamat}}" name="alamat" class="form-control" placeholder="Alamat..." required>
                    </div>

                    <div class="form-group">
                        <label>Rt</label>
                        <input type="number" value="{{$d->rt}}" name="rt" class="form-control" placeholder="Rt..." required>
                    </div>

                    <div class="form-group">
                        <label>Rw</label>
                        <input type="number" value="{{$d->rw}}" name="rw" class="form-control" placeholder="Rw..." required>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Provinsi</label>
                        <select class="form-control" id="provinsiedit" name="provinsi">
                            <option>Pilih Provinsi</option>
                            @foreach ($provinces as $provinsi)
                                <option value="{{$provinsi->id}}">{{$provinsi->name}}</option>
                            @endforeach
                        </select>
                    </div>
            
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Kabupaten</label>
                            <select name="kabupaten" id="kabupatenedit" class="form-control" required >

                            </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Kecamatan</label>
                            <select name="kecamatan" id="kecamatanedit" class="form-control" required >

                            </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Kelurahan</label>
                            <select name="datakelurahan" id="kelurahanedit" class="form-control" required >

                            </select>
                    </div>

                    <div class="form-group">
                        <label>No Telepon</label>
                        <input type="number" value="{{ substr_replace($d->notelepon, '0', 0, 2) }}" name="notelepon" class="form-control" placeholder="notelepon..." required>                   
                    </div>

                    <div class="form-group">
                        <label>No Bpjs</label>
                        <input type="number" value="{{$d->no_bpjs}}" name="no_bpjs" class="form-control" placeholder="No Bpjs...">
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

<!-- modal detail pasien -->
@foreach($pasien as $d)
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
                            <td>{{$d->pasien->nik_pasien}}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{$d->pasien->nama_pasien}}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{$d->pasien->jenis_kelamin}}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td>{{$d->pasien->tgl_lahir}}</td>
                        </tr>
                        <tr>
                            <th>Usia</th>
                            <td><?php 
                                $usia = date_diff(date_create($d->pasien->tgl_lahir),date_create('now'))->y;
                            ?>
                            {{$usia}}    
                        </td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{$d->pasien->alamat}}</td>
                        </tr>
                        <tr>
                            <th>Rt</th>
                            <td>{{$d->pasien->rt}}</td>
                        </tr>
                        <tr>
                            <th>Rw</th>
                            <td>{{$d->pasien->rw}}</td>
                        </tr>
                        <tr>
                            <th>Provinsi</th>
                            <td>{{$d->pasien->provinces->name}}</td>
                        </tr>
                        <tr>
                            <th>Kabupaten/kota</th>
                            <td>{{$d->pasien->regencies->name}}</td>
                        </tr>
                        <tr>
                            <th>Kecamatan</th>
                            <td>{{$d->pasien->district->name}}</td>
                        </tr>
                        <tr>
                            <th>Kelurahan</th>
                            <td>{{$d->pasien->village->name}}</td>
                        </tr>
                        <tr>
                            <th>No Telepon</th>
                            <td>{{$d->pasien->notelepon}}</td>
                        </tr>
                        <tr>
                            <th>No BPJS</th>
                            <td>{{$d->pasien->no_bpjs}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach($pasien as $g)
<div class="modal fade" id="modalHapuspasien{{$g->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Hapus pasien</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>  

            <form action="{{ route('pasien.destroy', $g->id) }}" enctype="multipart/form-data" method="GET">
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
@endforeach

<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> --}}

<script>
    $(function() {
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });  
        
        $(function(){
            // jika tabel provinsi ada perubahan maka dilakukan function
            $('#provinsi').on('change',function(){
                let id_provinsi = $('#provinsi').val();
                console.log(id_provinsi);
                //maka ambil value yg ada di id provinsi
                //jika select provinsi

                $.ajax({
                    // maka akan get kabupatennya dengan data id provinsi
                    type : 'POST',
                    url : "{{route('getkabupaten')}}",
                    data : {id_provinsi:id_provinsi},
                    cache : false,

                    success:function(response){
                        $('#kabupaten').html(response.options);
                        $('#kecamatan').html('');
                        $('#kelurahan').html('');
                    },
                    error: function(data){
                        console.log('error:',data)
                    }, 
                })
            })

            $('#kabupaten').on('change',function(){
                let id_kabupaten = $('#kabupaten').val();
                console.log(id_kabupaten);
                // ambil value yg ada di id provinsi

                $.ajax({
                    // get kabupatennya dengan data id provinsi
                    type : 'POST',
                    url : "{{route('getkecamatan')}}",
                    data : {id_kabupaten:id_kabupaten},
                    cache : false,

                    success:function(response){
                        $('#kecamatan').html(response.options);
                        $('#kelurahan').html('');
                    
                    },
                    error: function(data){
                        console.log('error:',data)
                    }, 
                })
            })

            $('#kecamatan').on('change',function(){
                let id_kecamatan = $('#kecamatan').val();
                console.log(id_kecamatan);
                // ambil value yg ada di id provinsi

                $.ajax({
                    // get kabupatennya dengan data id provinsi
                    type : 'POST',
                    url : "{{route('getkelurahan')}}",
                    data : {id_kecamatan:id_kecamatan},
                    cache : false,

                    success:function(response){
                        $('#kelurahan').html(response.options);
                    },
                    error: function(data){
                        console.log('error:',data)
                    }, 
                })
            })
        })
    });    
</script>
<script>
    $(document).ready(function() {
        $('#nik_input').on('input', function() {
            var nik = $(this).val();

            $.ajax({
                // url: '/check-nik/' + nik,
                url : "{{ route('check.nik', ':nik') }}".replace(':nik', nik),
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        // Data ditemukan, isi form input lainnya
                        var data = response.data;

                        $('#nama_input').val(data.nama_pasien);
                        
                        var selectElement = $('#jenis_kelamin');
                        selectElement.val(data.jenis_kelamin); 

                        $('#tgl_lahir').val(data.tgl_lahir);
                        $('#alamat').val(data.alamat);

                        var selectElement = $('#rt');
                        selectElement.val(data.rt);
                        
                        var selectElement = $('#rw');
                        selectElement.val(data.rw);
                        
                        var selectElement = $('#provinsi');
                        selectElement.val(data.provinsi);

                        var selectElement = $('#kabupaten');
                        selectElement.html(response.options.kabupaten); 

                        var selectElement = $('#kecamatan');
                        selectElement.html(response.options.kecamatan); 

                        var selectElement = $('#kelurahan');
                        selectElement.html(response.options.kelurahan);

                        var nomorTelepon = data.notelepon;
                        var nomorTeleponFormatted = nomorTelepon.substring(0, 0) + '0' + nomorTelepon.substring(3);
                        $('#notelepon').val(nomorTeleponFormatted);
                        
                        $('#no_bpjs').val(data.no_bpjs);
                        
                    } else {
                        // Data tidak ditemukan, reset form input lainnya
                        $('#nama_input').val('');
                        $('#alamat_input').val('');

                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection

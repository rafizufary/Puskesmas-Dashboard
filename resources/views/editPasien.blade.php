@extends('layout.layout')
@section('pasien', 'active')
@section('content')

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Menu Edit pasien</h4>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form action="{{ route('pasien.update', $item->id) }}" enctype="multipart/form-data" method="POST">
                            @csrf
								<div class="card-header">
									<div class="card-title">Edit Pasien</div>
								</div>
                                <form action="{{ route('pasien.update', $item->id) }}" enctype="multipart/form-data" method="POST">

                                <input type="hidden" value="{{$item->id}}" name="id" required>
								<div class="card-body">
									<div class="form-group">
										<label for="nik">NIK Pasien</label>
										<input type="text" name="nik_pasien" value="{{$item->pasien->nik_pasien}}" class="form-control" id="nik" placeholder="" reuierd>
									</div>

									<div class="form-group">
										<label for="nama">Nama</label>
										<input type="text" name="nama_pasien" value="{{$item->pasien->nama_pasien}}" class="form-control" id="nama" placeholder="" required>
									</div>

									<div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <select name="jenis_kelamin" class="form-control" required>
                                            <option value="" hidden="">--pilih level--</option>
                                            <option value="laki-laki" {{($item->pasien->jenis_kelamin === 'laki-laki') ? 'selected' : ''}}>Laki-Laki</option>
                                            <option value="perempuan" {{($item->pasien->jenis_kelamin === 'perempuan') ? 'selected' : ''}}>Perempuan</option>
                                        </select>
                                    </div>

									<div class="form-group">
										<label for="">Tanggal Lahir</label>
                                        <input type="text" id="tgl_lahir" value="{{$item->pasien->tgl_lahir}}" name="tanggal_lahir" class="form-control input_tanggal" placeholder="Tanggal Lahir..." required>
									</div>

                                    <div class="form-group">
                                        <label>Usia</label>
                                        <?php $usia = date_diff(date_create($item->pasien->tgl_lahir),date_create('now'))->y;?>
                                        <input disabled type="number" value="{{$usia}}" name="usia" class="form-control" placeholder="Usia..."required>
                                    </div>

									<div class="form-group">
										<label for="">Alamat</label>
										<input type="text" name="alamat" value="{{$item->pasien->alamat}}" class="form-control" id="" placeholder="">
									</div>

									<div class="form-group">
										<label for="">RT</label>
										<select name="rt" class="form-control" required>
                                            <option value="" hidden="">--pilih RT--</option>
                                            <option value="01" {{($item->pasien->rt === '01') ? 'selected' : ''}}>01</option>
                                            <option value="02" {{($item->pasien->rt === '02') ? 'selected' : ''}}>02</option>
                                            <option value="03" {{($item->pasien->rt === '03') ? 'selected' : ''}}>03</option>
                                            <option value="04" {{($item->pasien->rt === '04') ? 'selected' : ''}}>04</option>
                                            <option value="05" {{($item->pasien->rt === '05') ? 'selected' : ''}}>05</option>
                                            <option value="06" {{($item->pasien->rt === '06') ? 'selected' : ''}}>06</option>
                                            <option value="07" {{($item->pasien->rt === '07') ? 'selected' : ''}}>07</option>
                                            <option value="08" {{($item->pasien->rt === '08') ? 'selected' : ''}}>08</option>
                                            <option value="09" {{($item->pasien->rt === '09') ? 'selected' : ''}}>09</option>
                                            <option value="10" {{($item->pasien->rt === '10') ? 'selected' : ''}}>10</option>
                                            <option value="11" {{($item->pasien->rt === '11') ? 'selected' : ''}}>11</option>
                                            <option value="12" {{($item->pasien->rt === '12') ? 'selected' : ''}}>12</option>
                                            <option value="13" {{($item->pasien->rt === '13') ? 'selected' : ''}}>13</option>
                                            <option value="14" {{($item->pasien->rt === '14') ? 'selected' : ''}}>14</option>
                                            <option value="15" {{($item->pasien->rt === '15') ? 'selected' : ''}}>15</option>
                                            <option value="16" {{($item->pasien->rt === '16') ? 'selected' : ''}}>16</option>
                                            <option value="17" {{($item->pasien->rt === '17') ? 'selected' : ''}}>17</option>
                                            <option value="18" {{($item->pasien->rt === '18') ? 'selected' : ''}}>18</option>
                                            <option value="19" {{($item->pasien->rt === '19') ? 'selected' : ''}}>19</option>
                                            <option value="20" {{($item->pasien->rt === '20') ? 'selected' : ''}}>20</option>
                                        </select>
									</div>

									<div class="form-group">
										<label for="">RW</label>
										<select name="rw" class="form-control" required>
                                            <option value="" hidden="">--pilih RW--</option>
                                            <option value="01" {{($item->pasien->rw === '01') ? 'selected' : ''}}>01</option>
                                            <option value="02" {{($item->pasien->rw === '02') ? 'selected' : ''}}>02</option>
                                            <option value="03" {{($item->pasien->rw === '03') ? 'selected' : ''}}>03</option>
                                            <option value="04" {{($item->pasien->rw === '04') ? 'selected' : ''}}>04</option>
                                            <option value="05" {{($item->pasien->rw === '05') ? 'selected' : ''}}>05</option>
                                            <option value="06" {{($item->pasien->rw === '06') ? 'selected' : ''}}>06</option>
                                            <option value="07" {{($item->pasien->rw === '07') ? 'selected' : ''}}>07</option>
                                            <option value="08" {{($item->pasien->rw === '08') ? 'selected' : ''}}>08</option>
                                            <option value="09" {{($item->pasien->rw === '09') ? 'selected' : ''}}>09</option>
                                            <option value="10" {{($item->pasien->rw === '10') ? 'selected' : ''}}>10</option>
                                            <option value="11" {{($item->pasien->rw === '11') ? 'selected' : ''}}>11</option>
                                            <option value="12" {{($item->pasien->rw === '12') ? 'selected' : ''}}>12</option>
                                            <option value="13" {{($item->pasien->rw === '13') ? 'selected' : ''}}>13</option>
                                            <option value="14" {{($item->pasien->rw === '14') ? 'selected' : ''}}>14</option>
                                            <option value="15" {{($item->pasien->rw === '15') ? 'selected' : ''}}>15</option>
                                            <option value="16" {{($item->pasien->rt === '16') ? 'selected' : ''}}>16</option>
                                            <option value="17" {{($item->pasien->rt === '17') ? 'selected' : ''}}>17</option>
                                            <option value="18" {{($item->pasien->rt === '18') ? 'selected' : ''}}>18</option>
                                            <option value="19" {{($item->pasien->rt === '19') ? 'selected' : ''}}>19</option>
                                            <option value="20" {{($item->pasien->rt === '20') ? 'selected' : ''}}>20</option>
                                        </select>
									</div>

									<div class="form-group">
                                        <label for="exampleFormControlSelect1">Provinsi</label>
                                        <select class="form-control" id="provinsi" name="provinsi">     
                                            <option>Pilih Provinsi</option>
                                            @foreach ($provinces as $provinsi)
                                                <option value="{{$provinsi->id}}" @if($provinsi->id == $item->pasien->provinsi) selected @endif>{{$provinsi->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                            
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Kabupaten</label>
                                            <select name="kabupaten" id="kabupaten" class="form-control" required >
                                                <option>Pilih Kabupaten</option>
                                                @foreach ($regencies as $kabupaten)
                                                    <option value="{{$kabupaten->id}}" @if($kabupaten->id == $item->pasien->kota) selected @endif>{{$kabupaten->name}}</option>
                                                @endforeach

                                            </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Kecamatan</label>
                                            <select name="kecamatan" id="kecamatan" class="form-control" required >
                                                <option>Pilih Kecamatan</option>
                                                @foreach ($districts as $kecamatan)
                                                    <option value="{{$kecamatan->id}}" @if($kecamatan->id == $item->pasien->kecamatan) selected @endif>{{$kecamatan->name}}</option>
                                                @endforeach

                                            </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Kelurahan</label>
                                            <select name="datakelurahan" id="kelurahan" class="form-control" required >
                                                <option>Pilih Kelurahan</option>
                                                @foreach ($villages as $kelurahan)
                                                    <option value="{{$kelurahan->id}}" @if($kelurahan->id == $item->pasien->kelurahan) selected @endif>{{$kelurahan->name}}</option>
                                                @endforeach

                                            </select>
                                    </div>

									<div class="form-group">
										<label for="">Nomor Telepon</label>
										<input type="number" name="notelepon" value="{{ str_replace('+62', '0', $item->pasien->notelepon) }}" class="form-control" id="" placeholder="">
									</div>

									<div class="form-group">
										<label for="">Nomor BPJS</label>
										<input type="number" name="no_bpjs" value="{{ $item->pasien->no_bpjs }}" class="form-control" id="" placeholder="">
									</div>
								</div>
								<div class="card-action">
									<button class="btn btn-primary">Submit</button>
								</div>
							</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

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
            //maka ambil value yg ada di id provinsi
            //jika select provinsi

           $.ajax({
                // maka akan get kabupatennya dengan data id provinsi
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
            //maka ambil value yg ada di id provinsi
            //jika select provinsi

           $.ajax({
                // maka akan get kabupatennya dengan data id provinsi
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

@endsection
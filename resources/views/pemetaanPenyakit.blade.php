@extends('layout.layout')
@section('pemetaan', 'active')
@section('content')

<style>
	.skala-list {
		background-color: #f9f9f9;
		padding: 10px;
		border: 1px solid #ccc;
		border-radius: 5px;
		font-family: Arial, sans-serif;
	}

	.skala-list h4 {
		margin-top: 0;
		margin-bottom: 10px;
	}

	.skala-list ul {
		list-style-type: none;
		padding: 0;
	}

	.skala-list li {
		margin-bottom: 5px;
	}

	.skala-list img{
		padding-right: 5px;
	}

</style>

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Persebaran Penyakit Kecamatan Pesanggrahan</h4>
            </div>
            <div class="card">
				<div class="card-header">
					<div class="d-flex align-items-center">
						<h4 class="card-title">Pemetaan Penyakit {{ $penyakitSel->nama_diagnosa }}</h4>
					</div>
					<form action="{{ route('pemetaanPenyakit') }}" method="POST">
						@csrf
						<div class="form-group col-md-4">
							<label>Pilih Wilayah</label>
							<select  name="penyakit" class="form-control" required>
								<option value="" hidden="">--pilih Penyakit--</option>
                                <option value="default">default</option>
								@foreach($penyakit as $row)
									<option value="{{ $row->id }}">{{ $row->kode_diagnosa }} - {{ $row->nama_diagnosa }}</option>
								@endforeach
							</select>
							<button class="btn btn-primary mt-2">Submit</button>
						</div>
						
					</form>
                    
				</div>
            	<div class="card-body">
					<div class="table-responsive">
						<!-- Buat element div untuk menampung peta -->
						<div id="map" style="width:100%; height:75vh;"></div>

						<script>
							var peta1 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
									attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
								});

							var kecamatan = L.layerGroup();

							var map = L.map('map', {
								center: [-6.2497358, 106.7730951],
								zoom: 13,
								layers: [peta1,kecamatan]
							});

							var overlayer = {
								"Kecamatan" : kecamatan,
							};
							
							L.control.layers(overlayer).addTo(map);

							// Buat kontrol kustom untuk daftar skala
							var skalaControl = L.control({ position: 'topright' });

							skalaControl.onAdd = function (map) {
							var skalaDiv = L.DomUtil.create('div', 'skala-list');
							skalaDiv.innerHTML = '<table>' +
								'<tr>' +
									'<td style="text-align: center;">'+
										'<img src="{{ asset('assets/img/Hijau.png') }}" />'+
									'</td>'+
									'<td>Rendah</td>'+
									'</tr>'+
								'<tr>'+
									'<td style="text-align: center;">'+
										'<img src="{{ asset('assets/img/Kuning.png') }}" />'+
									'</td>'+
									'<td>Sedang</td>'+
								'</tr>'+
								'<tr>'+
									'<td style="text-align: center;">'+
										'<img src="{{ asset('assets/img/Merah.png') }}" />'+
									'</td>'+
									'<td>Banyak</td>'+
								'</tr>'+
								'</table>';

								// Tambahkan gaya CSS untuk memberikan latar belakang pada daftar skala
								skalaDiv.style.backgroundColor = '#ffffff';
								skalaDiv.style.padding = '10px';

							return skalaDiv;
							};

							// Tambahkan kontrol skala ke peta
							skalaControl.addTo(map);

							@foreach ($kecamatan as $data)
								L.geoJSON(<?= $data->geojson ?>, {
									style: function(feature) {

										var userLevel = '<?php echo Auth()->user()->level; ?>';
										if(userLevel == 'super_admin'){
											var totalPasien = {{App\Models\pasienPoli::Join('rawatjalan', 'rawatjalan.id_pasien', '=', 'pasien_poli.id')->join('pasien','pasien.id','=','pasien_poli.id_pasien')->where('rawatjalan.status', 'rawat')->where('rawatjalan.id_diagnosa', $penyakitSel->id)->where('kelurahan',$data->id)->count()}};
										} else {
											var totalPasien = {{App\Models\pasienPoli::Join('rawatjalan', 'rawatjalan.id_pasien', '=', 'pasien_poli.id')->join('pasien','pasien.id','=','pasien_poli.id_pasien')->where('rawatjalan.status', 'rawat')->where('rawatjalan.id_diagnosa', $penyakitSel->id)->where('rawatjalan.poli', auth()->user()->id_poli)->where('kelurahan',$data->id)->count()}};
										}
										
										var fillColor;
										if (totalPasien >= 3) {
											fillColor = "#ff0000"; // merah untuk kecamatan dengan total pasien >= 50
										} else if (totalPasien >= 1) {
											fillColor = "#FFD700"; // oranye untuk kecamatan dengan total pasien >= 20
										} else {
											fillColor = "#008000"; // kuning untuk kecamatan dengan total pasien kurang dari 20
										}
										return { fillColor: fillColor };
									}
								}).addTo(kecamatan).bindPopup('@if(Auth()->user()->level != 'super_admin') <a href="penyakit/detail/{{$data->id}}/{{ $penyakitSel->nama_diagnosa }}" target="_blank">Detail Penyakit {{ $penyakitSel->nama_diagnosa }} di Kelurahan {{$data->name}}</a><br> Total Pasien : {{App\Models\pasienPoli::Join('rawatjalan', 'rawatjalan.id_pasien', '=', 'pasien_poli.id')->where('rawatjalan.poli',Auth()->user()->id_poli)->join('pasien','pasien.id','=','pasien_poli.id_pasien')->where('rawatjalan.status','rawat')->where('kelurahan',$data->id)->where('rawatjalan.id_diagnosa', $penyakitSel->id)->count()}} <br> {{ $penyakitSel->nama_diagnosa }} : {{App\Models\pasienPoli::Join('rawatjalan', 'rawatjalan.id_pasien', '=', 'pasien_poli.id')->where('rawatjalan.poli',Auth()->user()->id_poli)->where('rawatjalan.status','rawat')->where('kelurahan',$data->id)->join('pasien','pasien.id','=','pasien_poli.id_pasien')->where('rawatjalan.id_diagnosa', $penyakitSel->id)->count()}} @else <a href="penyakit/detail/{{$data->id}}/{{ $penyakitSel->nama_diagnosa }}" target="_blank">Detail Penyakit di Kelurahan {{$data->name}}</a><br> Total Pasien :  {{App\Models\pasienPoli::Join('rawatjalan', 'rawatjalan.id_pasien', '=', 'pasien_poli.id')->where('rawatjalan.status','rawat')->join('pasien','pasien.id','=','pasien_poli.id_pasien')->where('kelurahan',$data->id)->where('rawatjalan.id_diagnosa', $penyakitSel->id)->count()}} <br> {{ $penyakitSel->nama_diagnosa }} : {{App\Models\pasienPoli::Join('rawatjalan', 'rawatjalan.id_pasien', '=', 'pasien_poli.id')->where('rawatjalan.status','rawat')->join('pasien','pasien.id','=','pasien_poli.id_pasien')->where('kelurahan',$data->id)->where('rawatjalan.id_diagnosa', $penyakitSel->id)->count()}}  @endif');
							@endforeach
							// masalah total pada popup
						</script>
					</div>
            	</div>
        	</div>
        </div>
    </div>  
</div>


@endsection 




@extends('layout.layout')
@section('dashboard', 'active')
@section('content')

			<div class="main-panel">
				<div class="content">
					<div class="page-inner">			
						<div class="row">
							<div class="col-sm-6 col-md-4">
								<div class="card card-stats card-round">
									<div class="card-body ">
										<div class="row align-items-center">
											<div class="col-icon">
												<div class="icon-big text-center icon-info bubble-shadow-small">
													<i class="flaticon-users"></i>
												</div>
											</div>
											<div class="col col-stats ml-3 ml-sm-0">
												<div class="numbers">
													<p class="card-category">User</p>
													<h4 class="card-title">{{$user}}</h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-sm-6 col-md-4">
								<div class="card card-stats card-round">
									<div class="card-body">
										<div class="row align-items-center">
											<div class="col-icon">
												<div class="icon-big text-center icon-info bubble-shadow-small">
													<i class="fas fa-wheelchair"></i>
												</div>
											</div>
											<div class="col col-stats ml-3 ml-sm-0">
												<div class="numbers">
													<p class="card-category">Pasien</p>
													<h4 class="card-title">{{$pasien}}</h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-md-4">
								<div class="card card-stats card-round">
									<div class="card-body">
										<div class="row align-items-center">
											<div class="col-icon">
												<div class="icon-big text-center icon-info bubble-shadow-small">
													<i class="flaticon-list"></i>
												</div>
											</div>
											<div class="col col-stats ml-3 ml-sm-0">
												<div class="numbers">
													<p class="card-category">Penyakit</p>
													<h4 class="card-title">{{$diagnosa}}</h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
									@if(Auth::user()->level == 'super_admin')
                                        <h4 class="card-title">Daftar Keseluruhan Pasien Control</h4>
									@else
										<h4 class="card-title">Daftar Pasien Control Poli {{ Auth::user()->poli->nama_poli }}</h4>
									@endif
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="add-row" class="display table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
											@if(Auth::user()->level == 'super_admin')
												<th>Poli</th>
											@endif
                                            <th>Nik</th>
                                            <th>Nama</th>
                                            <th>Diagnosa</th>
                                            <th>No Telepon</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                         $no =1;   
                                        @endphp
                                        @foreach ($pasiencontrol as $row)
                                            
                                        <tr>
                                            <td>{{$no++}}</td>
											@if(Auth::user()->level == 'super_admin')
												<td>{{ $row->datapoli->nama_poli }}</td>
											@endif
											<td>{{$row->pasien->pasien->nik_pasien}}</td>
                                            <td>{{$row->pasien->pasien->nama_pasien}}</td>
											<td>{{ $row->diagnosa->nama_diagnosa }}</td>
                                            <td>{{$row->pasien->pasien->notelepon}}</td>
                                            <td>
												<a href="{{ route('kirimpesan', ['pasienId' => $row->pasien->id, 'tglControl' => $row->tgl_control, 'poli' => auth()->user()->poli->nama_poli,  'diagnosaId' => $row->diagnosa->id]) }}" target="whatsapp" class="btn btn-success btn-sm">
													<i class="fa fa-paper-plane"></i> Kirim Pesan
												</a>
											{{-- <a href="https://web.whatsapp.com/send?phone={{$row->pasien->notelepon}}&text=REMINDER : %0AHalo {{$row->pasien->nama_pasien}}, Anda memiliki jadwal kontrol pada tanggal {{date('d-m-Y', strtotime($row->tgl_control))}} di Poli {{auth()->user()->poli->nama_poli}} Puskesmas Kecamatan Pesanggrahan . Mohon pastikan Anda hadir pada Tanggal tersebut" target="whatsapp"  class="btn btn-success btn-sm"><i class="fa fa-paper-plane"></i> Kirim Pesan</a> --}}
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

				<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

				

	
@endsection
@extends('layout.layout')
@section('rawatJalan', 'active')
@section('contentCss')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />

	<style>
		.fc-event {
			width: 94%;
			height: 100px;
			border: 1px solid #c3c3c3;
			display: flex;
			flex-wrap: wrap;
			align-content: center;
		}
		.fc-event:hover{
			cursor: pointer;
		}
		.fc-content{
			margin: 0 auto;
			font-size: 20px;
			font-weight:
		}
	</style>
@endsection

@section('content')
	<div class="main-panel">
		<div class="content">
			<div class="page-inner">
				<div class="page-header">
					<h4 class="page-title">RAWAT JALAN</h4>
				</div>
				<div class="card">
					<div class="card-body">
						<div id="rawatjalan"> 

					</div>

				</div>
			
				</div>
			</div>
		</div>
		
	</div>

	<div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Tambah Pasien</h5>
					<button type="button" class="close"  data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<form action="rawatjalan/store" enctype="multipart/form-data" method="POST">
					@csrf 
				<div class="modal-body">

					<div class="form-group">
							<label>Pasien</label>
							<select class="form-control" aria-label="Default select example" name="pasien">
								<option selected>Pilih Pasien</option>
								@foreach ($pasien as $item)
									@if(auth()->user()->level == 'super_admin'){
										<option value={{$item->id}}>{{$item->pasien->nik_pasien}} - {{$item->pasien->nama_pasien}} - Poli {{ $item->datapoli->nama_poli }} </option>
									} @else {
										<option value={{$item->id}}>{{$item->pasien->nik_pasien}} - {{$item->pasien->nama_pasien}}</option>
									}
									@endif
								@endforeach
							  </select>
					</div>

					<div class="form-group">
						<label>Diagnosa</label>
						<select class="form-control" aria-label="Default select example" name="diagnosa">
							<option selected>Pilih Diagnosa</option>
							@foreach ($diagnosa as $item)
							@if(auth()->user()->level == 'super_admin'){
								<option value="{{$item->id}}">{{$item->nama_diagnosa}} - Poli {{ $item->poli->nama_poli }}</option>
							} @else {
								<option value="{{$item->id}}">{{$item->nama_diagnosa}}</option>
							}
							@endif
							@endforeach
						  </select>
					</div>

					<div class="form-group">
						<label>Tanggal Kontrol</label>
						<input type="text" name="tgl_control" class="form-control input_tanggal" placeholder="Tanggal Kontrol..." required>
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
					<button type="button" class="btn btn-danger"  data-dismiss="modal"><i class="fa fa-undo"></i> Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
	
				</form>
				</div>
			</div>
		</div>
	
	</div>
@endsection

@section('contentjs')
	{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
	{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> --}}
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
	{{-- <script src="/assets/js/plugin/sweetalert/sweetalert.min.js"></script> --}}
	{{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script> --}}
	{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script> --}}
	{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> --}}
	{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

	<script>
		$("#selectPasien").select2({
			placeholder:'Pilih Provinsi',
			ajax:{
				url:"{{route('datapasien.index')}}",
				processResults: function({data}){
					return{
						results: $.map(data,function(item){
							return{
								id: item.id,
								text: item.nama_pasien
							}
						})
					}
				}
			}
		});
	</script>

	<script>
		$(document).ready(function(){

			$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});

			var booking = @json($events);

			$('#rawatjalan').fullCalendar({
				header: {
					left: 'prev, next today',
					center: 'title',
					right: 'month, agendaWeek, agendaDay',
				},
				events: booking, 
				selectable: true,
				selectHelper: true,
				defaultView: 'month',
				select: function(start, end, allDays) {

					// jika calnder di select dia akan melakukan penampilan modal 
					$('#bookingModal').modal('toggle');

					
					$('#saveBtn').click(function() {
						var title = $('#title').val();
						var start_date = moment(start).format('YYYY-MM-DD');
						var end_date = moment(end).format('YYYY-MM-DD');


						$.ajax({
							url:"{{ route ('rawatjalan') }}",
							type:"POST",
							dataType: 'json',
							data:{ title, start_date, end_date},
							success:function(response)
							{	

								$('#bookingModal').modal('hide')
								$('#calendar').fullCalendar('renderEvent',{
									'title' : response.title,
									'start' : response.start,
									'end'	: response.end,
									'color' : response.color
								});
								
								location.reload();
							},
							error:function(error)
							{
								if(error.responseJSON.errors) {
									$('#titleError').html(error.responseJSON.errors.title);
								}
							},

						});
				
					});	
				
				},

				eventClick: function(event){

					//mendapatkan id sama dengan tanggal yang kita pilih
					var id = moment(event.start).format('YYYY-MM-DD');		

					//akan dikirim ke alamat yang dituju
					window.location.href = "{{ route('rawatjalan.detail', ':id') }}".replace(':id', id);
				},
				
			})

			$("#bookingModal").on("hidden.bs.modal", function(){
				$('#saveBtn').unbind();
			});
		});
	</script>
@endsection


	
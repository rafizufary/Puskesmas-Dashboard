@extends('layout.layout')
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
                        <div class="card-body">

                            <div class="container">
								<div class="row">
									<div class="col-12">
										
										<h3 class="text-center mt-5">Rawat Jalan</h3>
											<div class="col-md-11 offset-1 mt-5 mb-5">
												<div id="rawatjalan"> 
						
												</div>
										</div>
									</div>
								</div>
							</div>
						
							<div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLongTitle">Tambah Pasien</h5>
											<button type="button" class="close"  data-bs-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
						
										<form action="rawatjalan/store" enctype="multipart/form-data" method="POST">
											@csrf 
										<div class="modal-body">
						
											<div class="form-group">
												<label>Pasien</label>
												<select name="pasien" class="form-control" required>
													<option value="" hidden="">--pilih pasien--</option>
													@foreach ($pasien as $item)
													<option value={{$item->id}}>{{$item->nik_pasien}} - {{$item->nama_pasien}}</option>
													@endforeach
												</select>
											</div>
						
											<div class="form-group">
												<label>Diagnosa</label>
												<select name="diagnosa" class="form-control" required>
													<option value="" hidden="">--pilih diagnosa--</option>
													@foreach ($diagnosa as $item)
													<option value={{$item->id}}>{{$item->kode_diagnosa}} - {{$item->nama_diagnosa}}</option>
													@endforeach
												</select>
											</div>	
										</div>
						
										<div class="form-group">
											<label>Tanggal Kontrol</label>
											<input type="date" name="tgl_control" class="form-control" placeholder="Tanggal Kontrol..." required>
										</div>
							
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary"  data-bs-dismiss="modal"><i class="fa fa-undo"></i> Close</button>
											<button type="submit" class="btn btn-primary">Save changes</button>
											</div>
							
										</form>
										</div>
									</div>
								</div>
							
							</div>
						
						
							
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
											var id = moment(event.start).format('YYYY-MM-DD');		
						
											window.location.href = '/rawatjalan/detail/'+id;
								
						
										},
										 
									})
						
									$("#bookingModal").on("hidden.bs.modal", function(){
										$('#saveBtn').unbind();
									});
								});
							</script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>




@endsection

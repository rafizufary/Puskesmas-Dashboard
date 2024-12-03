<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-tofit-no">
        <meta name="csrf-token" content="{{ csrf_token() }}" /> 
        <title>Select2</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        
    </head>
    <body>
    
    <div class="container">
        <h1 class='mt-5'>Indonesia</h1>
                <form class='mt-2'>
                    <div class='mb-2'>
                        <label>Provinsi</label>
						<select id="selectProv" class="form-select" aria-label="Default select example">
                        </select>
                    </div>

                    <div class='mb-2'>
                        <label>Kabupaten</label>
						<select id="selectkabu" class="form-select" aria-label="Default select example">
                        </select>
                    </div>

                </form>
    </div>


                   
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
		$(document).ready(function(){
			$("#selectProv").select2({
				placeholder:'Pilih Provinsi',
				ajax:{
					url:"{{route('provinsi.index')}}",
                    processResults: function({data}){
                        return{
                            results: $.map(data,function(item){
                                return{
                                    id: item.id,
                                    text: item.name
                                }
                            })
                        }
                    }
				}
			});

            
		});
	</script>

   

    </body>
</html>

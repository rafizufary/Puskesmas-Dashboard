<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

    <form action="{{ route('tesRelasi-store') }}" method="POST">
        @csrf
        <div class="form-group row mt-5">
            <label for="text1" class="col-4 col-form-label">Text Field</label> 
            <div class="col-8">
                {{-- <input id="text1" name="text1" type="text" class="form-control"> --}}
                <select name="id_pasien" id="" class="form-control">
                    <option value="" hidden>Pilih Pasien</option>
                    @foreach($pasien as $row)
                        <option value="{{ $row->id }}">{{ $row->nama_pasien }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="text" class="col-4 col-form-label">Text Field</label> 
            <div class="col-8">
                {{-- <input id="text" name="text" type="text" class="form-control"> --}}
                <select name="id_poli" id="" class="form-control">
                    <option value="" hidden>Pilih Poli</option>
                    @foreach($poli as $row)
                        <option value="{{ $row->id }}">{{ $row->nama_poli }}</option>
                    @endforeach
                </select>
            </div>
        </div> 
        <div class="form-group row">
            <div class="offset-4 col-8">
                <button name="submit" type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
    <div>
        <table border="3">
            <tr>
                <th>pasien</th>
                <th>Poli</th>
            </tr>
            @foreach ($data as $item)
            <tr>

                <td>{{ $item->pasien->nama_pasien }}</td>
                <td>{{ $item->datapoli->nama_poli }}</td>
            </tr>
            @endforeach
            <tr>
                <td style="text-align: center;"><img src="assets/img/Merah.png" /></td>
            </tr>
        </table>
    </div>
</body>
</html>
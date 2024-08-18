<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Print Hasil Nilai
        </div>
        <div class="card-body">
            <form class="form-inline" action="{{url('nilai-print')}}" method="get" target="_blank">

                <div class="form-group">
                    <label>Tahun Ajaran</label>
                    <select class="form-control select2" name="tahun_ajaran" id="tahun_ajaran" required>
                        <option value="">Pilih Tahun Ajaran</option>
                        @foreach ($tahunajaran as $e=>$m)
                        <option value="{{$m}}" @php if($m==$nowtahunajaran) { echo "selected=''" ; } @endphp>{{$m}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-info">Print</button>
            </form>
        </div>
    </div>
@extends('master')
@section('title', 'Beban')
@section('judul', 'Form Beban')
@section('content')
<form role="form" method="post" action="{{($action!='beban.store') ? url($action): route($action) }}">
    {{csrf_field()}}
    <div class="form-group">
        <input type="hidden" name="bebanId" value="{{ ($action!='beban.store') ? $beban->bebanId : ''}}">
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Jenis Beban</label>
            <div class="col-sm-10">
                <select name="nama" class="form-control" required>
                    <option value="">Pilih Jenis Beban</option>
                    @foreach($akunbeban as $key => $value)
                    <option value="{{$value->nama}}">{{$value->nama}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Tanggal</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" placeholder="Date" name="tanggal" value="{{ ($action!='beban.store') ? $beban->tanggal : $tahun.'-01-01'}}" required>
            </div>
        </div>
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Nominal</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" placeholder="Nominal" name="nominal" value="{{ ($action!='beban.store') ? $beban->nominal : ''}}" required>
            </div>
        </div>
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Keterangan</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="keterangan" name="keterangan" value="{{ ($action!='beban.store') ? $beban->keterangan : '-'}}" required>
            </div>
        </div>
        <input type="hidden" class="form-control" placeholder="faktur" name="faktur" value="{{ ($action!='beban.store') ? $beban->faktur : $faktur+1}}">
        <!-- /.card-body -->
        <div class="card-footer">
            <input type="submit" class="btn btn-primary" value="{{ ($action!='beban.store') ? 'Update' : 'Simpan' }}">
            <button type="reset" class="btn btn-default float-right">Cancel</button>
        </div>
        <!-- /.card-footer -->
    </div>
</form>
@endsection
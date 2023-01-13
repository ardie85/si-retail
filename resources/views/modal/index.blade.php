@extends('master')
@section('title', 'Modal')
@section('judul', 'Penanaman Modal')
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
    {{$message}}
</div>
@endif
<form role="form" method="post" action="{{($action!='modal.store') ? url($action): url($action) }}">
    {{csrf_field()}}
    <div class="form-group">
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Modal</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" placeholder="10000000" name="modal" value="" required>
            </div>
        </div>
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Tanggal</label>
            <div class="col-sm-10">
            <input type="date" class="form-control" placeholder="" value="<?php echo $tahun . '-01-01'; ?>" name="tanggal" required>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <input type="submit" class="btn btn-primary" value='Tambah Modal'>
            <button type="reset" class="btn btn-default float-right">Cancel</button>
        </div>
        <!-- /.card-footer -->
    </div>
</form>
@endsection
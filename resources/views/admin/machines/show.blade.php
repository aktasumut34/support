@extends('layouts.adminmaster')

@section('content')
    <!--Page header-->
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{ trans('langconvert.machines.machines') }}</span></h4>
        </div>
    </div>
    <!--End Page header-->

    <!-- Customer Edit -->
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header border-0">
                <h4 class="card-title">{{ trans('langconvert.machines.edit_machine') }}</h4>
            </div>
            <form method="POST" action="{{ url('/admin/machines/' . $machine->id) }}" enctype="multipart/form-data">
                <div class="card-body">
                    @csrf

                    @honeypot
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">{{ trans('langconvert.machines.machine_name') }}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ $machine->name, old('name') }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">{{ trans('langconvert.machines.machine_name_english') }}</label>
                                <input type="text" class="form-control @error('name_english') is-invalid @enderror" name="name_english"
                                    value="{{ $machine->name_english, old('name_english') }}">
                                @error('name_english')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">{{ trans('langconvert.machines.machine_code') }}</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" name="code"
                                    value="{{ $machine->code, old('code') }}">
                                @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">{{ trans('langconvert.machines.machine_image') }}</label>
                                <div class="input-group file-browser">
                                    <input class="form-control @error('image') is-invalid @enderror" name="image"
                                        type="file" accept="image/png, image/jpeg,image/jpg">
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <small
                                    class="text-muted"><i>{{ trans('langconvert.admindashboard.filesize') }}</i></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="form-group float-end">
                        <input type="submit" class="btn btn-secondary"
                            value="{{ trans('langconvert.admindashboard.savechanges') }}"
                            onclick="this.disabled=true;this.form.submit();">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Customer Edit -->
@endsection

@section('scripts')
    <!-- INTERNAL select2 js-->
    <script src="{{ asset('assets/js/select2.js') }}"></script>
@endsection

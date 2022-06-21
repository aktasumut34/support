@extends('layouts.adminmaster')

@section('styles')
    <!-- INTERNAl Tag css -->
    <link href="{{ asset('assets/plugins/taginput/bootstrap-tagsinput.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />
@endsection

@section('content')
    <!--Page header-->
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Spare Parts</span></h4>
        </div>
    </div>
    <!--End Page header-->

    <!-- Create Spare Part -->
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header border-0">
                <h4 class="card-title">Add Spare Part</h4>
            </div>
            <form method="POST" action="{{ url('/admin/spare-parts/create') }}" enctype="multipart/form-data">
                <div class="card-body">
                    @csrf

                    @honeypot
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">Spare Part Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">Spare Part Code</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" name="code"
                                    value="{{ old('code') }}">
                                @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">Size Info</label>
                                <input type="text" class="form-control @error('size') is-invalid @enderror" name="size"
                                    value="{{ old('size') }}">
                                @error('size')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Select Machine <span class="text-red">*</span></label>
                            <select
                                class="form-control select2-show-search select2 @error('machine_id') is-invalid @enderror"
                                data-placeholder="Select Machine" name="machine_id[]" id="machine_id" multiple='multiple'>
                                <option label="Select Machine"></option>
                                @foreach ($machines as $machine)
                                    <option value="{{ $machine->id }}" @if (old('machine_id') == $machine->id) selected @endif>
                                        {{ $machine->name }} ( {{ $machine->code }} )</option>
                                @endforeach

                            </select>
                            <span id="MachineError" class="text-danger alert-message"></span>
                            @error('machine_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">Spare Part Image</label>
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
                <div class="col-md-12 card-footer">
                    <div class="form-group float-end">
                        <input type="submit" class="btn btn-secondary" value="Create Spare Part"
                            onclick="this.disabled=true;this.form.submit();">
                    </div>
                </div>
            </form>

        </div>
    </div>
    <!-- Create Spare Part -->
@endsection

@section('scripts')
    <!--File BROWSER -->
    <script src="{{ asset('assets/js/form-browser.js') }}"></script>

    <!-- INTERNAL Vertical-scroll js-->
    <script src="{{ asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>

    <!-- INTERNAL Index js-->
    <script src="{{ asset('assets/js/support/support-sidemenu.js') }}"></script>

    <!-- INTERNAL TAG js-->
    <script src="{{ asset('assets/plugins/taginput/bootstrap-tagsinput.js') }}"></script>
@endsection

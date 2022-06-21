@extends('layouts.adminmaster')

@section('styles')
    <!-- INTERNAl Tag css -->
    <link href="{{ asset('assets/plugins/taginput/bootstrap-tagsinput.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />
@endsection

@section('content')
    <!--Page header-->
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Lineup Documents</span></h4>
        </div>
    </div>
    <!--End Page header-->

    <!-- Create Lineup Document -->
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header border-0">
                <h4 class="card-title">Add Lineup Document</h4>
            </div>
            <form method="POST" action="{{ url('/admin/lineup-documents/create') }}" enctype="multipart/form-data">
                <div class="card-body">
                    @csrf

                    @honeypot
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">Document Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Select Document Type <span class="text-red">*</span></label>
                            <select
                                class="form-control select2-show-search select2 @error('type') is-invalid @enderror"
                                data-placeholder="Select Document Type" name="type" id="type">
                                <option label="Select Document Type"></option>
                                <option value='document' @if (old('type') == 'document') selected @endif>PDF / Word
                                    Document</option>
                                <option value='video' @if (old('type') == 'video') selected @endif>Video</option>
                            </select>
                            @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                        <div class="form-group">
                            <label class="form-label">Select Lineup <span class="text-red">*</span></label>
                            <select
                                class="form-control select2-show-search select2 @error('lineup_id') is-invalid @enderror"
                                data-placeholder="Select Lineup" name="lineup_id" id="lineup_id">
                                <option label="Select Lineup"></option>
                                @foreach ($lineups as $lineup)
                                    <option value="{{ $lineup->id }}" @if (old('lineup_id') == $lineup->id) selected @endif>
                                        {{ $lineup->name }} (
                                        {{ $lineup->code ? $lineup->code : 'No Code Provided' }} )</option>
                                @endforeach

                            </select>
                            @error('lineup_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">Lineup Document</label>
                                <div class="input-group file-browser">
                                    <input class="form-control @error('path') is-invalid @enderror" name="document"
                                        type="file" accept="*">
                                    @error('document')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <small
                                    class="text-muted"><i>{{ trans('langconvert.admindashboard.filesize') }}</i></small>
                            </div>
                            <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 card-footer">
                    <div class="form-group float-end">
                        <input type="submit" class="btn btn-secondary" value="Create Spare Part">
                    </div>
                </div>
            </form>

        </div>
    </div>
    <!-- Create Lineup Document -->
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
    <script src="{{asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>


    <script>
        $('form').ajaxForm({
                    beforeSend: function () {
                        var percentage = '0';
                    },
                    uploadProgress: function (event, position, total, percentComplete) {
                        var percentage = percentComplete;
                        $('.progress .progress-bar').css("width", percentage+'%', function() {
                          return $(this).attr("aria-valuenow", percentage) + "%";
                        })
                    },
                    complete: function (xhr) {
                        var redirect = JSON.parse(xhr.responseText);
                        if(redirect.success) {
                            swal('Success', 'File uploaded successfully', 'success').then(function() {
                                window.location.href = redirect.url;
                            });
                        } else {
                            swal('Error', redirect.error, 'error');
                            $('.progress .progress-bar').css("width", 0+'%', function() {
                          return $(this).attr("aria-valuenow", 0) + "%";
                        })
                        }
                    }
                });
    </script>
@endsection

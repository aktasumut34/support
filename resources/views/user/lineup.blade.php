@extends('layouts.usermaster')

@section('styles')
    <!-- INTERNAl Summernote css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote.css') }}?v=<?php echo time(); ?>">

    <!-- INTERNAl DropZone css -->
    <link href="{{ asset('assets/plugins/dropzone/dropzone.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />

    <link href="{{ asset('assets/plugins/wowmaster/css/animate.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />
    <style>
        .nav-tabs .nav-link:hover:not(.disabled):not(.active) {
            color: rgba(236, 148, 25, 1) !important;
        }

        .nav-tabs .nav-link {
            border: none !important;
        }
    </style>
@endsection

@section('content')
    <!-- Section -->
    <section>
        <div class="bannerimg cover-image" data-bs-image-src="{{ asset('assets/images/photos/banner1.jpg') }}">
            <div class="header-text mb-0">
                <div class="container">
                    <div class="row text-white">
                        <div class="col">
                            <h1 class="mb-0">{{ trans('langconvert.lineups.lineup_documents') }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section -->

    <!--Section-->
    <section>
        <div class="cover-image sptb">
            <div class="container">
                <div class="row">
                    @include('includes.user.verticalmenu')
                    <div class="col-xl-9">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title" style="font-size: 2em">{{ $lineup->name }}</h2>
                            </div>
                            <div class='card-body'>
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="documents-tab" data-bs-toggle="tab"
                                            data-bs-target="#documents" type="button" role="tab" aria-controls="documents"
                                            aria-selected="true" style='text-transform: uppercase;'>{{ trans('langconvert.machines.documents') }}</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="videos-tab" data-bs-toggle="tab"
                                            data-bs-target="#videos" type="button" role="tab" aria-controls="videos"
                                            aria-selected="false" style='text-transform: uppercase;'>{{ trans('langconvert.machines.videos') }}</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="documents" role="tabpanel"
                                        aria-labelledby="documents-tab" style="min-height: 40vh;">
                                        <div class="row" style="padding: 30px;">
                                            @if (count($documents))
                                                @foreach ($documents as $document)
                                                    <div class="col-md-4 col-lg-3">
                                                        <a href="{{ $document->path }}" target="_blank">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h5 class="card-title">{{ $document->name }}</h5>
                                                                </div>
                                                                <div class="card-body"
                                                                    style="display: flex; flex-direction: column;  align-items: center;">
                                                                    <img src="{{ asset('assets/images/pdf.png') }}"
                                                                        style="height: 120px">
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="alert alert-info">
                                                    {{ trans('langconvert.lineups.no_documents') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="videos" role="tabpanel" aria-labelledby="videos-tab"
                                        style="min-height: 40vh;">

                                        <div class="row" style="padding: 30px;">
                                            @if (count($videos))
                                                <div class="row">
                                                    @foreach ($videos as $video)
                                                        <div class="col-md-6 card">
                                                            <div class="card-header">
                                                                <h4 class="card-title">{{ $video->name }}</h4>
                                                            </div>
                                                            <div class="card-body">
                                                                <video controls>
                                                                    <source src="{{ $video->path }}" type="video/mp4">
                                                                </video>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="alert alert-info">
                                                    {{ trans('langconvert.lineups.no_videos') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Section-->
@endsection
@section('scripts')
    <!-- INTERNAL Vertical-scroll js-->
    <script src="{{ asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js') }}?v=<?php echo time(); ?>">
    </script>

    <!-- INTERNAL Summernote js  -->
    <script src="{{ asset('assets/plugins/summernote/summernote.js') }}?v=<?php echo time(); ?>"></script>

    <!-- INTERNAL Index js-->
    <script src="{{ asset('assets/js/support/support-sidemenu.js') }}?v=<?php echo time(); ?>"></script>
    <script src="{{ asset('assets/js/select2.js') }}?v=<?php echo time(); ?>"></script>

    <!-- INTERNAL Dropzone js-->
    <script src="{{ asset('assets/plugins/dropzone/dropzone.js') }}?v=<?php echo time(); ?>"></script>

    <!-- wowmaster js-->
    <script src="{{ asset('assets/plugins/wowmaster/js/wow.min.js') }}?v=<?php echo time(); ?>"></script>
@endsection

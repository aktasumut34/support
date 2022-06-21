@extends('layouts.usermaster')

@section('styles')
    <!-- INTERNAl Summernote css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote.css') }}?v=<?php echo time(); ?>">

    <!-- INTERNAl DropZone css -->
    <link href="{{ asset('assets/plugins/dropzone/dropzone.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />

    <link href="{{ asset('assets/plugins/wowmaster/css/animate.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />
    <link href="{{ asset('assets/css/tailwind.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />
    <style>
        .machine-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(227, 143, 27, 0.3);
background: linear-gradient(0deg, rgba(227, 143, 27, 0.60) 0%, rgba(227, 143, 27,0.03) 50%, rgba(227, 143, 27, 0.01) 100%);
            opacity: 0;
            display: flex;
            justify-content: center;
            align-items: end;
            z-index: 2;
            pointer-events: none;
            border-radius: 13px;
            transition: opacity 0.15s ease-in-out;
        }
        .machine-overlay span {
            color: #fff;
            font-size: 1.2rem;
            font-weight: 600;
            padding-bottom: .5em;
        }
        .machine-container:hover .machine-overlay {
            opacity: 1;
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
                            <h1 class="mb-0">Machines & Documents</h1>
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
                        @foreach ($lineups as $lineup)
                            <div class="row" style="margin-bottom: 35px;">
                                <div style="display: flex; justify-content: space-between">
                                    <h2 class="card-title" style="font-size: 2em">{{ $lineup->name }}</h2>
                                    <a href="{{ route('lineup', ['id' => $lineup->id]) }}" class="btn btn-primary">Show Lineup Documents</a>
                                </div>
                                <div class="t-grid t-grid-cols-1 lg:t-grid-cols-3 t-gap-4 t-items-stretch">
                                    @foreach ($lineup->machines as $machine)
                                        <div class="machine-container" style='position: relative;'>
                                            <div class="machine-overlay">
                                                <span>Show Documents</span>
                                            </div>
                                            <a href="{{ route('machine', ['id' => $machine->id]) }}">
                                                <div class="card" style="height: 100%">
                                                    <div class="card-header"
                                                        style="display: flex; flex-direction: column; align-items: start; justify-content: left;">
                                                        <h4 class="card-title">{{ $machine->name }}</h4>
                                                        </h4>
                                                        <small>Machine Code:
                                                            <b>{{ $machine->code }}</b></small><small>Serial
                                                            Number: <b>
                                                                {{ $machine->pivot->serial_number }}</b></small>
                                                                <small>Register
                                                            Date: <b>
                                                                {{ Carbon\Carbon::parse($machine->pivot->register_date)->format('d.m.Y') }}</b></small>
                                                    </div>
                                                    <div class="card-body" style="margin-top: auto;">
                                                        <img style='width: 100%; height:200px; object-fit: contain; border-radius: .4em;'
                                                            src="{{ $machine->image }}" />
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        @endforeach
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

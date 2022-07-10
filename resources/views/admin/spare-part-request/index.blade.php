@extends('layouts.adminmaster')

@section('styles')
    <!-- INTERNAL Data table css -->
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}?v=<?php echo time(); ?>"
        rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/responsive.bootstrap5.css') }}?v=<?php echo time(); ?>"
        rel="stylesheet" />

    <!-- INTERNAL Sweet-Alert css -->
    <link href="{{ asset('assets/plugins/sweet-alert/sweetalert.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />
@endsection

@section('content')
    <!--Page header-->
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{ trans('langconvert.spare_parts.spare_part_requests') }}</span></h4>
        </div>
    </div>
    <!--End Page header-->

    <!-- Machine List -->
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header d-sm-max-flex border-0">
                <h4 class="card-title">{{ trans('langconvert.spare_parts.all_spare_part_requests') }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive spruko-delete">

                    <div class="table-responsive">
                        <table class="table-vcenter text-nowrap table-bordered table-striped w-100 table"
                            id="sparepartrequestlist">
                            <thead>
                                <tr>
                                    <th>{{ trans('langconvert.admindashboard.id') }}</th>
                                    <th>#{{ trans('langconvert.admindashboard.id') }}</th>
                                    <th>{{ trans('langconvert.admindashboard.customer') }}</th>
                                    <th>{{ trans('langconvert.spare_parts.spare_part_request_number') }}</th>
                                    <th>{{ trans('langconvert.admindashboard.date') }}</th>
                                    <th>{{ trans('langconvert.admindashboard.status') }}</th>
                                    <th>{{ trans('langconvert.spare_parts.last_action') }}</th>
                                    <th>{{ trans('langconvert.admindashboard.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Machine List -->
@endsection

@section('scripts')
    <!-- INTERNAL Vertical-scroll js-->
    <script src="{{ asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js') }}"></script>

    <!-- INTERNAL Data tables -->
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>

    <!-- INTERNAL Index js-->
    <script src="{{ asset('assets/js/support/support-sidemenu.js') }}"></script>

    <!-- INTERNAL Sweet-Alert js-->
    <script src="{{ asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>

    <script type="text/javascript">
        "use strict";

        (function($) {

            // Variables
            var SITEURL = '{{ url('') }}';

            // Csrf Field
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Datatable
            $('#sparepartrequestlist').DataTable({
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('/admin/spare-part-requests') }}"
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        'visible': false
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'customer',
                        name: 'customer'
                    },
                    {
                        data: 'subject',
                        name: 'subject'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        orderable: false,
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ],
                order: [],
                responsive: true,
                drawCallback: function() {
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll(
                        '[data-bs-toggle="tooltip"]'))
                    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl)
                    });
                    $('.form-select').select2({
                        minimumResultsForSearch: Infinity,
                        width: '100%'
                    });
                },
            });

        })(jQuery);
    </script>
@endsection

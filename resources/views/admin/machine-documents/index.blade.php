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
            <h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{ trans('langconvert.machines.machine_documents') }}</span></h4>
        </div>
    </div>
    <!--End Page header-->

    <!-- Machine Document List -->
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header d-sm-max-flex border-0">
                <h4 class="card-title">{{ trans('langconvert.machines.all_machine_documents') }}</h4>
                <div class="card-options mt-sm-max-2">
                    <a href="{{ url('admin/machine-documents/create') }}" class="btn btn-success me-3"><i
                            class="feather feather-plus"></i>
                            {{ trans('langconvert.machines.add_machine_document') }}</a>

                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive spruko-delete">

                    <table class="table-vcenter text-nowrap table-bordered table-striped ticketdeleterow w-100 table"
                        id="support-machinedocumentlist">
                        <thead>
                            <tr>
                                <th width="10">{{ trans('langconvert.admindashboard.id') }}</th>
                                <th width="10">{{ trans('langconvert.admindashboard.name') }}</th>
                                <th>{{ trans('langconvert.machines.machine') }}</th>
                                <th width="10">{{ trans('langconvert.machines.document_type') }}</th>
                                <th>Link</th>
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
    <!-- End Machine Document List -->
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
            $('#support-machinedocumentlist').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('/admin/machine-documents') }}"
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        'visible': false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'machine_name',
                        name: 'machine_name'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'path',
                        name: 'path'
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

            // Delete the machine document
            $('body').on('click', '#show-delete', function() {
                var _id = $(this).data("id");
                swal({
                        title: `{{ trans('langconvert.admindashboard.wanttocontinue') }}`,
                        text: "{{ trans('langconvert.admindashboard.eraserecordspermanently') }}",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                type: "get",
                                url: SITEURL + "/admin/machine-documents/delete/" + _id,
                                success: function(data) {
                                    toastr.error(data.error);
                                    var oTable = $('#support-machinedocumentlist').dataTable();
                                    oTable.fnDraw(false);
                                },
                                error: function(data) {
                                    console.log('Error:', data);

                                }
                            });
                        }
                    });
            });

        })(jQuery);
    </script>
@endsection

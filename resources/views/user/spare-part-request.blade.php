 @extends('layouts.usermaster')

 @section('styles')
     <!-- INTERNAL Data table css -->
     <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}?v=<?php echo time(); ?>"
         rel="stylesheet" />
     <link href="{{ asset('assets/plugins/datatable/responsive.bootstrap5.css') }}?v=<?php echo time(); ?>"
         rel="stylesheet" />
 @endsection

 @section('content')
     <!-- Section -->
     <section>
         <div class="bannerimg cover-image" data-bs-image-src="{{ asset('assets/images/photos/banner1.jpg') }}">
             <div class="header-text mb-0">
                 <div class="container">
                     <div class="row text-white">
                         <div class="col">
                             <h1 class="mb-0">Spare Part Requests</h1>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </section>
     <!-- Section -->

     <!--Dashboard List-->
     <section>
         <div class="cover-image sptb">
             <div class="container">
                 <div class="row">
                     @include('includes.user.verticalmenu')

                     <div class="col-xl-9">
                         <div class="row">
                             <div class="col-xl-12 col-lg-12 col-md-12">
                                 <div class="card mb-0">
                                     <div class="card-header d-flex border-0">
                                         <h4 class="card-title">
                                             Spare Part Requests</h4>
                                         <div class="float-end ms-auto"><a href="{{ route('spare-part-request-new') }}"
                                                 class="btn btn-secondary ms-auto"><i
                                                     class="fa fa-paper-plane-o me-2"></i>New Spare Part Request</a>
                                         </div>
                                     </div>
                                     <div class="card-body">
                                         <div class="table-responsive">
                                             <table
                                                 class="table-vcenter text-nowrap table-bordered table-striped w-100 table"
                                                 id="userdashboard">
                                                 <thead>
                                                     <tr>
                                                         <th>{{ trans('langconvert.admindashboard.id') }}</th>
                                                         <th>#{{ trans('langconvert.admindashboard.id') }}</th>
                                                         <th>Request Number</th>
                                                         <th>{{ trans('langconvert.admindashboard.date') }}</th>
                                                         <th>{{ trans('langconvert.admindashboard.status') }}</th>
                                                         <th>Last Action</th>
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
                     </div>
                 </div>
             </div>
         </div>
     </section>
     <!--Dashboard List-->
 @endsection

 @section('scripts')
     <!-- INTERNAL Vertical-scroll js-->
     <script src="{{ asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js') }}?v=<?php echo time(); ?>">
     </script>

     <!-- INTERNAL Data tables -->
     <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}?v=<?php echo time(); ?>"></script>
     <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.js') }}?v=<?php echo time(); ?>"></script>
     <script src="{{ asset('assets/plugins/datatable/dataTables.responsive.min.js') }}?v=<?php echo time(); ?>"></script>
     <script src="{{ asset('assets/plugins/datatable/responsive.bootstrap5.min.js') }}?v=<?php echo time(); ?>"></script>

     <!-- INTERNAL Index js-->
     <script src="{{ asset('assets/js/support/support-sidemenu.js') }}?v=<?php echo time(); ?>"></script>

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

             //________ Data Table
             $('#userdashboard').DataTable({

                 language: {
                     searchPlaceholder: 'Search...',
                     sSearch: '',
                 },
                 processing: true,
                 serverSide: true,
                 ajax: {
                     url: "{{ route('spare-part-request') }}"
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

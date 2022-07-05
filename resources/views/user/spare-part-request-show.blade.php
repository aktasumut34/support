 @extends('layouts.usermaster')

 @section('styles')
     <link href="{{ asset('assets/css/tailwind.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />
 @endsection

 @section('content')
     <!-- Section -->
     <section>
         <div class="bannerimg cover-image" data-bs-image-src="{{ asset('assets/images/photos/banner1.jpg') }}">
             <div class="header-text mb-0">
                 <div class="container">
                     <div class="row text-white">
                         <div class="col">
                             <h1 class="mb-0">{{ trans('langconvert.spare_parts.spare_part_requests') }}</h1>
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
                                 <div class="card t-min-h-[50vh] mb-0">
                                     <div class="card-header d-flex border-0">
                                         <h4 class="card-title">
                                             <span class="t-font-normal">{{ trans('langconvert.spare_parts.spare_part_request') }}:</span>
                                             <span class="t-font-bold">{{ $sparePartRequest->request_no }}</span>
                                         </h4>
                                     </div>
                                     <div class="card-body">
                                         <div class="t-flex t-flex-col t-gap-8">
                                             <div class="t-grid t-grid-cols-1 xl:t-grid-cols-3 t-gap-4">
                                                 <div
                                                     class="t-flex t-justify-between t-items-center t-rounded-lg t-bg-slate-200 t-p-4">
                                                     <span class="t-font-bold">{{ trans('langconvert.spare_parts.status') }}</span>
                                                     <span class="t-font-bold">{{ $sparePartRequest->status }}</span>
                                                 </div>
                                                 <div
                                                     class="t-flex t-justify-between t-items-center t-rounded-lg t-bg-slate-200 t-p-4">
                                                     <span class="t-font-bold">{{ trans('langconvert.spare_parts.request_created_at') }}</span>
                                                     <span
                                                         class="t-font-semibold">{{ $sparePartRequest->created_at->format(setting('date_format')) }}</span>
                                                 </div>
                                                 <div
                                                     class="t-flex t-justify-between t-items-center t-rounded-lg t-bg-slate-200 t-p-4">
                                                     <span class="t-font-bold">{{ trans('langconvert.spare_parts.last_action') }}</span>
                                                     <span
                                                         class="t-font-semibold">{{ $sparePartRequest->updated_at->diffForHumans() }}</span>
                                                 </div>
                                             </div>
                                             <table class="table-striped table-hover table">
                                                 <thead>
                                                     <tr>
                                                         <th scope="col">{{ trans('langconvert.machines.machine') }}</th>
                                                         <th scope="col">{{ trans('langconvert.machines.serial_number') }}</th>
                                                         <th scope="col">{{ trans('langconvert.spare_parts.spare_part') }}</th>
                                                         <th scope="col">{{ trans('langconvert.spare_parts.quantity') }}</th>
                                                         @if ($sparePartRequest->status != 'New')
                                                             <th scope="col">{{ trans('langconvert.spare_parts.unit_price') }}</th>
                                                             <th scope="col">{{ trans('langconvert.spare_parts.total_price') }}</th>
                                                             <th scope="col">{{ trans('langconvert.spare_parts.due_date') }}</th>
                                                         @endif
                                                     </tr>
                                                 </thead>
                                                 <tbody>
                                                     @foreach ($sparePartRequest->items as $item)
                                                         <tr>
                                                             <td class="t-flex t-flex-col"><span
                                                                     class="t-font-semibold t-text-lg t-text-slate-700">{{ $item->customerLineupMachine->machine->name }}</span>
                                                                 <span
                                                                     class="t-text-slate-500 t-text-sm">{{ $item->customerLineupMachine->machine->code }}</span>
                                                             </td>
                                                             <td class="t-text-lg">
                                                                 {{ $item->customerLineupMachine->serial_number }}</td>
                                                             <td class="t-flex t-flex-col"><span
                                                                     class="t-font-semibold t-text-lg t-text-slate-700">{{ $item->sparePart->name }}</span>
                                                                 <span
                                                                     class="t-text-slate-500 t-text-sm">{{ $item->sparePart->code }}</span>
                                                             </td>
                                                             @if($item->quantity > 0)
                                                                <td class="t-text-lg">{{ $item->quantity }}</td>
                                                                @if($sparePartRequest->status != 'New')
                                                                    <td class="t-text-lg">{{ $item->price }}</td>
                                                                    <td class="t-text-lg">
                                                                        {{ number_format($item->price * $item->quantity, 2) }}
                                                                    </td>
                                                                    <td class="t-text-lg">
                                                                        {{ \Carbon\Carbon::parse($item->due_date)->format('d.m.Y') }}
                                                                    </td>
                                                                @endif
                                                            @else
                                                                <td class="t-text-lg" style="color: red;">{{ trans('langconvert.spare_parts.out_of_stock') }}</td>
                                                                @if($sparePartRequest->status != 'New')
                                                                    <td class="t-text-lg"> - </td>
                                                                    <td class="t-text-lg"> - </td>
                                                                    <td class="t-text-lg"> - </td>
                                                                @endif
                                                            @endif
                                                         </tr>
                                                     @endforeach
                                                 </tbody>
                                             </table>
                                             @if($sparePartRequest->status != 'New')
                                             <div class="t-flex t-flex-col t-gap-2 t-mb-8">
                                                <div class="t-grid t-grid-cols-2 t-items-center t-rounded-lg t-bg-slate-200 t-p-4">
                                                    <span class="t-font-bold">{{ trans('langconvert.spare_parts.total_price') }}</span>
                                                    <span class="t-font-semibold">₺ {{ number_format($sparePartRequest->total, 2) }}</span>
                                                    <input type='hidden' name='total' value="{{ $sparePartRequest->total }}" />
                                                </div>
                                                @if($sparePartRequest->discounted_total && $sparePartRequest->discounted_total != $sparePartRequest->total)
                                                    <div class="t-grid t-grid-cols-2 t-items-center t-rounded-lg t-bg-slate-200 t-p-4">
                                                        <span class="t-font-bold">Discounted Price (₺)</span>
                                                        <span class="t-font-semibold">₺ {{ number_format($sparePartRequest->discounted_total, 2) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                             @endif
                                             @if ($sparePartRequest->status == 'Waiting for Approval')


                                             <form method="POST"
                                                 action="{{ route('spare-part-request-update', ['id' => $sparePartRequest->id]) }}">
                                                    @csrf
                                                 <div class="button-group">
                                                     <input name="status" type="submit" value="{{ trans('langconvert.spare_parts.approve') }}" class="btn btn-outline-success" type="submit" />
                                                     <input name="status" type="submit" value="{{ trans('langconvert.spare_parts.reject') }}" class="btn btn-outline-danger" type="submit" />
                                                 </div>
                                             </form>
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
     <!--Dashboard List-->
 @endsection

 @section('scripts')
     <!-- INTERNAL Vertical-scroll js-->
     <script src="{{ asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js') }}?v=<?php echo time(); ?>">
     </script>

     <!-- INTERNAL Index js-->
     <script src="{{ asset('assets/js/support/support-sidemenu.js') }}?v=<?php echo time(); ?>"></script>
 @endsection

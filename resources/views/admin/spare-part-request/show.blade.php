@extends('layouts.adminmaster')
@section('styles')
    <link href="{{ asset('assets/css/tailwind.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />
@endsection
@section('content')
    <!--Page header-->
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Spare Part Request</span></h4>
        </div>
    </div>
    <!--End Page header-->

    <!-- Customer Edit -->
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card t-min-h-[50vh] mb-0">
            <div class="card-header d-flex border-0">
                <h4 class="card-title">
                    <span class="t-font-normal">Spare Part Request:</span>
                    <span class="t-font-bold">{{ $sparePartRequest->request_no }}</span>
                </h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('sparepartrequestupdate', $sparePartRequest->id) }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="t-flex t-flex-col t-gap-8">
                        <div class="t-grid t-grid-cols-2 xl:t-grid-cols-4 t-gap-4">
                            <div class="t-flex t-justify-between t-items-center t-rounded-lg t-bg-slate-200 t-p-4">
                                <span class="t-font-bold">Customer</span>
                                <span class="t-font-semibold t-flex t-flex-col t-items-end">
                                    <span
                                        class="t-text-lg t-text-slate-800">{{ $sparePartRequest->customer->username }}</span>
                                    <span class="t-text-slate-600">{{ $sparePartRequest->customer->company_name }}</span>
                                </span>
                            </div>
                            <div class="t-flex t-justify-between t-items-center t-rounded-lg t-bg-slate-200 t-p-4">
                                <span class="t-font-bold">Status</span>
                                <span>{{ $sparePartRequest->status }}</span>
                            </div>
                            <div class="t-flex t-justify-between t-items-center t-rounded-lg t-bg-slate-200 t-p-4">
                                <span class="t-font-bold">Request Created</span>
                                <span
                                    class="t-font-semibold">{{ $sparePartRequest->created_at->format(setting('date_format')) }}</span>
                            </div>
                            <div class="t-flex t-justify-between t-items-center t-rounded-lg t-bg-slate-200 t-p-4">
                                <span class="t-font-bold">Last Action</span>
                                <span class="t-font-semibold">{{ $sparePartRequest->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <table class="table-striped table-hover table">
                            <thead>
                                <tr>
                                    <th scope="col">Machine</th>
                                    <th scope="col">Machine Serial Number</th>
                                    <th scope="col">Spare Part</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Unit Price (₺)</th>
                                    <th scope="col">Total Price (₺)</th>
                                    <th scope="col">Due Date</th>
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
                                            <span class="t-text-slate-500 t-text-sm">{{ $item->sparePart->code }}</span>
                                        </td>
                                        <td class="t-text-lg">
                                            <input type="text" class='form-control quantityInput liveInput' value='{{ $item->quantity }}' id='quantity-{{ $item->id }}' name='q-{{ $item->id }}' data-iid='{{ $item->id }}' placeholder='Quantity' @if($sparePartRequest->status != 'New' && $sparePartRequest->status != 'Rejected' && $sparePartRequest->status != 'Waiting for Approval') disabled @endif>
                                        </td>
                                        <td class="t-text-lg">
                                            <input type='text' class='form-control priceInput liveInput' value='{{ $item->price }}' id='price-{{ $item->id }}' name='p-{{ $item->id }}' data-iid='{{ $item->id }}' placeholder='Unit Price' @if($sparePartRequest->status != 'New' && $sparePartRequest->status != 'Rejected' && $sparePartRequest->status != 'Waiting for Approval') disabled @endif>
                                        </td>
                                        <td class="t-text-lg">
                                            <span id='total-{{ $item->id }}'> {{ number_format($item->quantity * $item->price,2) }} </span>
                                        </td>
                                        <td class="t-text-lg">
                                            <input type='date' class='form-control liveInput' id='date-{{ $item->id }}' name='d-{{ $item->id }}' data-iid='{{ $item->id }}' value='{{ $item->due_date ? \Carbon\Carbon::parse($item->due_date)->format("Y-m-d") : date("Y-m-d") }}' @if($sparePartRequest->status != 'New' && $sparePartRequest->status != 'Rejected' && $sparePartRequest->status != 'Waiting for Approval') disabled @endif>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="t-flex t-flex-col t-gap-2 t-mb-8">
                        <div class="t-grid t-grid-cols-2 t-items-center t-rounded-lg t-bg-slate-200 t-p-4">
                            <span class="t-font-bold">Total Price (₺)</span>
                            <span class="t-font-semibold" id='totalPrice'>₺ {{ number_format($sparePartRequest->total, 2) }}</span>
                            <input type='hidden' name='total' value="{{ $sparePartRequest->total }}" />
                        </div>

                        <div class="t-grid t-grid-cols-2 t-items-center t-rounded-lg t-bg-slate-200 t-p-4">
                            <span class="t-font-bold">Discounted Price (₺)</span>
                            <input type='text' class='form-control' value='{{ number_format($sparePartRequest->discounted_total, 2) }}' name='discounted_total' placeholder='Discounted Total' id="discounted_total" @if($sparePartRequest->status != 'New' && $sparePartRequest->status != 'Rejected' && $sparePartRequest->status != 'Waiting for Approval') disabled @endif>
                        </div>
                    </div>
                    <input type="hidden" name="items" id="items" value="{{ json_encode($sparePartRequest->items) }}" />
                    @if($sparePartRequest->status == 'Approved')
                        <label>Tracking Number: </label>
                        <input type='text' class='form-control' style='margin-bottom: 5px;' name='tracking_number' placeholder='Tracking Number'>
                        <button class="btn btn-primary" type="submit">Ship Now</button>
                    @else
                    <button class="btn btn-primary" type="submit">Save</button>
                    @endif
                </form>
            </div>
        </div>
    </div>
    <!-- End Customer Edit -->
@endsection

@section('scripts')
    <!-- INTERNAL select2 js-->
    <script src="{{ asset('assets/js/select2.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
        let items = JSON.parse($('#items').val());
        const changeInput = function() {
            var id = $(this).data('iid');
            var quantity = $('#quantity-' + id).val();
            var price = $('#price-' + id).val();
            var date = $('#date-' + id).val();
            var total = quantity * price;
            $('#total-' + id).text(total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            const item = items.find(item => item.id == id);
            item.quantity = quantity;
            item.price = price;
            item.due_date = date;
            $('#items').val(JSON.stringify(items));


            const totalPrice = items.reduce((acc, item) => acc + item.quantity * item.price, 0);
            $("#totalPrice").text("₺ " + totalPrice.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $("#discounted_total").val(totalPrice.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        }
        $('.liveInput').on('change', changeInput);
        $('.liveInput').on('keyup', changeInput);
    </script>
@endsection

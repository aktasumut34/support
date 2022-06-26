@extends('layouts.adminmaster')

@section('styles')
    <!-- INTERNAl Tag css -->
    <link href="{{ asset('assets/plugins/taginput/bootstrap-tagsinput.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />

    <!-- INTERNAL Sweet-Alert css -->
    <link href="{{ asset('assets/plugins/sweet-alert/sweetalert.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />
@endsection

@section('content')
    <!--Page header-->
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <h4 class="page-title"><span
                    class="font-weight-normal text-muted ms-2">{{ trans('langconvert.admindashboard.customer') }}</span>
            </h4>
        </div>
    </div>
    <!--End Page header-->

    <!-- Create Customers -->
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header border-0">
                <h4 class="card-title">{{ trans('langconvert.admindashboard.createcustomer') }}</h4>
            </div>
            <form method="POST" action="{{ url('/admin/customer/create') }}" enctype="multipart/form-data">
                <div class="card-body">
                    @csrf

                    @honeypot
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Company Name</label>
                                <input type="text" class="form-control" name="company_name"
                                    value="{{ old('company_name') }}">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{trans('langconvert.admindashboard.uploadimage')}}</label>
                                <div class="input-group file-browser">
                                    <input class="form-control @error('image') is-invalid @enderror" name="image" type="file" accept="image/png, image/jpeg,image/jpg" >
                                    @error('image')

                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                                <small class="text-muted"><i>{{trans('langconvert.admindashboard.filesize')}}</i></small>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">Company Address</label>
                                <textarea class="form-control" name="company_address" placeholder='Company Address'>{{ old('company_name') }}</textarea>

                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{ trans('langconvert.admindashboard.firstname') }} <span
                                        class="text-red">*</span></label>
                                <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                                    name="firstname" value="{{ old('firstname') }}">
                                @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{ trans('langconvert.admindashboard.lastname') }} <span
                                        class="text-red">*</span></label>
                                <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                                    name="lastname" value="{{ old('lastname') }}">
                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{ trans('langconvert.admindashboard.emailaddress') }}
                                    <span class="text-red">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{ trans('langconvert.admindashboard.password') }} <small
                                        class="text-muted"><i>{{ trans('langconvert.admindashboard.copythepassword') }}</i></small></label>
                                <div class="input-group mb-4">
                                    <div class="input-group">
                                        <a href="javascript:void(0)" class="input-group-text">
                                            <i class="fe fe-eye" aria-hidden="true"></i>
                                        </a>
                                        <input class="form-control @error('password') is-invalid @enderror" type="text"
                                            name="password" value="{{ str_random(10) }}" readonly>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">ACTY Contact No</label>
                                <input type="text" class="form-control" name="glass_number"
                                    value="{{ old('glass_number') }}">

                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label
                                    class="form-label">{{ trans('langconvert.admindashboard.mobilenumber') }}</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                                    value="{{ old('phone') }}">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 mt-4">
                            <div class="form-group">
                                <h3 class='mb-3'>Customer Line Ups</h3>
                                <input type="hidden" value="{{ old('lineups') }}" name="lineups" id="lineUpInput"
                                    value="">
                                <div id='lineups'></div>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#lineUpModal">
                                    Add New Lineup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 card-footer">
                    <div class="form-group float-end">
                        <input type="submit" class="btn btn-secondary"
                            value="{{ trans('langconvert.admindashboard.createcustomer') }}"
                            onclick="this.disabled=true;this.form.submit();">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Create Customers -->
    <!-- Modal -->
    <div class="modal fade" id="lineUpModal" tabindex="-1" aria-labelledby="lineUpModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Lineup</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Select Lineup Type</label>
                        <select class="form-control select2-show-search select2" data-placeholder="Select Lineup Type"
                            name="lineup_type" id="modalLineupType">
                            <option label="Select Lineup Type"></option>
                            @foreach ($lineups as $lineup)
                                <option value="{{ $lineup->id }}">{{ $lineup->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <label class="form-label">{{ trans('langconvert.usermenu.machines') }}</label>
                        <div class='row'>
                            @foreach ($machines as $machine)
                                <div class="form-group col-sm-6 col-lg-4 col-xl-3"
                                    style="display: flex; flex-direction: column;">
                                    <div class="switch_section" style="height: 50px;">
                                        <div class="switch-toggle d-flex mt-4">
                                            <a class="onoffswitch2">
                                                <input type="checkbox" id="onoffswitch{{ $machine->id }}"
                                                    value="{{ $machine->id }}"
                                                    class="toggle-class onoffswitch2-checkbox modalMachineSwitch"
                                                    name="modalMachines[]">

                                                <label for="onoffswitch{{ $machine->id }}"
                                                    class="toggle-class onoffswitch2-label"></label>
                                            </a>
                                            <div class="ps-3">
                                                <label class="form-label">{{ $machine->name }}
                                                    ({{ $machine->code ? $machine->code : 'N/A' }})
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <input data-name='{{ $machine->name }}' data-code='{{ $machine->code }}'
                                        type="text" class="form-control serialNumberInputs" style='display: none'
                                        id="serialNumber-{{ $machine->id }}" placeholder="Serial Number">
                                    <input type="date" class="form-control dateInputs" style='display: none; margin-top: .5em;'
                                        id="machineDate-{{ $machine->id }}" placeholder="Date">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="addLineup">Add Lineup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editlineUpModal" tabindex="-1" aria-labelledby="lineUpEditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Lineup</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Select Lineup Type</label>
                        <select class="form-control select2-show-search select2" data-placeholder="Select Lineup Type"
                            name="lineup_type" id="editmodalLineupType">
                            <option label="Select Lineup Type"></option>
                            @foreach ($lineups as $lineup)
                                <option value="{{ $lineup->id }}">{{ $lineup->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <label class="form-label">{{ trans('langconvert.usermenu.machines') }}</label>
                        <div class='row'>
                            @foreach ($machines as $machine)
                                <div class="form-group col-sm-6 col-lg-4 col-xl-3"
                                    style="display: flex; flex-direction: column;">
                                    <div class="switch_section" style="height: 50px;">
                                        <div class="switch-toggle d-flex mt-4">
                                            <a class="onoffswitch2">
                                                <input type="checkbox" id="editonoffswitch{{ $machine->id }}"
                                                    value="{{ $machine->id }}"
                                                    class="toggle-class onoffswitch2-checkbox editmodalMachineSwitch"
                                                    name="editmodalMachines[]">

                                                <label for="editonoffswitch{{ $machine->id }}"
                                                    class="toggle-class onoffswitch2-label"></label>
                                            </a>
                                            <div class="ps-3">
                                                <label class="form-label">{{ $machine->name }}
                                                    ({{ $machine->code ? $machine->code : 'N/A' }})
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <input data-name='{{ $machine->name }}' data-code='{{ $machine->code }}'
                                        type="text" class="form-control editserialNumberInputs" style='display: none'
                                        id="editserialNumber-{{ $machine->id }}" placeholder="Serial Number">
                                    <input type="date" class="form-control editdateInputs" style='display: none; margin-top: .5em;'
                                        id="editmachineDate-{{ $machine->id }}" placeholder="Date">

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="editLineup">Update Lineup</button>
                </div>
            </div>
        </div>
    </div>
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

    <!-- INTERNAL Sweet-Alert js-->
    <script src="{{ asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>

    <script>
        let customerLineups = JSON.parse($('#lineUpInput').val() || '[]');
        drawLineups();
        $('.modalMachineSwitch').on('change', function() {
            var id = $(this).val();
            if ($(this).is(':checked')) {
                $('#serialNumber-' + id).slideDown();
                $('#machineDate-' + id).slideDown();
            } else {
                $('#serialNumber-' + id).slideUp();
                $('#machineDate-' + id).slideUp();
            }
        });

        $('.editmodalMachineSwitch').on('change', function() {
            var id = $(this).val();
            if ($(this).is(':checked')) {
                $('#editserialNumber-' + id).slideDown();
                $('#editmachineDate-' + id).slideDown();
            } else {
                $('#editserialNumber-' + id).slideUp();
                $('#editmachineDate-' + id).slideUp();
            }
        });
        $('#addLineup').on('click', function() {
            var lineupType = $('#modalLineupType').val();
            var machines = [];
            var emptySerial = false;
            var sameSerial = false;
            var serials = [];
            var serialsAll = customerLineups.flatMap(function(lineup) {
                return lineup.machines.flatMap(function(machine) {
                    return machine.serialNumber;
                });
            });
            $('.modalMachineSwitch').each(function() {
                if ($(this).is(':checked')) {
                    var id = $(this).val();
                    var serialNumber = $('#serialNumber-' + id);
                    var machineDate = $('#machineDate-' + id);
                    if (!serialNumber.val() || !machineDate.val()) {
                        emptySerial = true;
                        return;
                    } else {
                        if(serials.indexOf(serialNumber.val()) !== -1 || serialsAll.indexOf(serialNumber.val()) !== -1) {
                            sameSerial = true;
                            return;
                        }
                        serials.push(serialNumber.val());
                    }
                    machines.push({
                        id: id,
                        name: serialNumber.data('name'),
                        code: serialNumber.data('code'),
                        registerDate: machineDate.val(),
                        serialNumber: serialNumber.val()
                    });
                }
            });
            if (emptySerial) {
                swal({
                    title: "Error!",
                    text: "Please enter serial number and register date for all selected machines!",
                    icon: "error",
                    button: "Ok",
                });
                return;
            }
            if(sameSerial) {
                swal({
                    title: "Error!",
                    text: "You cannot give same serial number to different machines!",
                    icon: "error",
                    button: "Ok",
                });
                return;
            }
            if (!lineupType) {
                swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please select a lineup type!',
                });
                return false;
            }
            if (machines.length === 0) {
                swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please select at least one machine!',
                });
                return false;
            }
            customerLineups.push({
                id: customerLineups[customerLineups.length - 1] ? customerLineups[customerLineups.length -
                    1].id + 1 : 1,
                lineup: {
                    id: lineupType,
                    name: $('#modalLineupType option:selected').text()
                },
                machines: machines
            });
            drawLineups();

            swal({
                icon: 'success',
                title: 'Success',
                text: 'Lineup added successfully!',
            });

            $('.modalMachineSwitch').each(function() {
                if ($(this).is(':checked')) {
                    $(this).prop('checked', false);
                }
            });
            $('.serialNumberInputs').val('');
            $('.serialNumberInputs').slideUp();
            $('.dateInputs').val('');
            $('.dateInputs').slideUp();
            $('#modalLineupType').val('').trigger('change');
            bootstrap.Modal.getOrCreateInstance($('#lineUpModal')).hide();
        });

        function drawLineups() {
            var html = '';
            customerLineups.forEach((lineup) => {
                html += `
                    <div class='row lineup-row'>
                        <div class='col-md-3'>
                            <label style='font-weight: bold;'>Lineup Type</label>
                            <div>${lineup.lineup.name}</div>
                        </div>
                        <div class='col-md-6'>
                            <label style='font-weight: bold;'>Machines</label>
                            <div>
                                ${lineup.machines.map((machine) => {
                                return `
                                    <div class='lineup-item'>
                                        <div>${machine.name} (${machine.code || 'N/A'})</div>
                                        <div>Serial Number: <b>${machine.serialNumber}</b></div>
                                        <div>Register Date: <b>${new Date(machine.registerDate).toLocaleDateString()}</b></div>
                                    </div>`;
                                }).join('')}
                            </div>
                        </div>
                        <div class='col-md-3'>
                            <label style='font-weight: bold;'>Actions</label>
                            <div style='flex'>
                                <button type='button' class='action-btns1 editLineup' data-domid='${lineup.id}'><i class="feather feather-edit text-primary"></i></button>
                                <button type='button' class='action-btns1 deleteLineup' data-domid='${lineup.id}'><i class="feather feather-trash-2 text-danger"></i></button>
                            </div>

                        </div>
                    </div>
                `;
            });
            $('#lineups').html(html);
            $('#lineUpInput').val(JSON.stringify(customerLineups));
        }

        $('body').on('click', '.deleteLineup', function() {
            var _id = $(this).data("domid");
            swal({
                    title: `Are you sure you want to delete this lineup?`,
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var lineup = customerLineups.find((lineup) => lineup.id == _id);
                        customerLineups.splice(customerLineups.indexOf(lineup), 1);
                        drawLineups();
                    }
                });

        });


        $('body').on('click', '.editLineup', function() {
            var _id = $(this).data("domid");
            $('#editLineup').data('domid', _id);
            var lineup = customerLineups.find((lineup) => lineup.id == _id);
            $('#editmodalLineupType').val(lineup.lineup.id).trigger('change');
            $('.editserialNumberInputs').val('');
            $('.editserialNumberInputs').slideUp();
            lineup.machines.forEach((machine) => {
                $('#editonoffswitch' + machine.id).prop('checked', true);
                $('#editserialNumber-' + machine.id).slideDown();
                $('#editserialNumber-' + machine.id).val(machine.serialNumber);
                $('#editmachineDate-' + machine.id).slideDown();
                $('#editmachineDate-' + machine.id).val(machine.registerDate);
            });
            bootstrap.Modal.getOrCreateInstance($('#editlineUpModal')).show();
        });

        $('#editLineup').on('click', function() {

            var _id = $(this).data("domid");
            var lineupType = $('#editmodalLineupType').val();
            var machines = [];
            var emptySerial = false;
            var sameSerial = false;
            var serials = [];
            var serialsAll = customerLineups.flatMap(function(lineup) {
                return lineup.machines.flatMap(function(machine) {
                    if(_id !== lineup.id) return machine.serialNumber;
                });
            });
            $('.editmodalMachineSwitch').each(function() {
                if ($(this).is(':checked')) {
                    var id = $(this).val();
                    var serialNumber = $('#editserialNumber-' + id);
                    var machineDate = $('#editmachineDate-' + id);
                    if (!serialNumber.val()) {
                        emptySerial = true;
                        return;
                    } else {
                        if(serials.indexOf(serialNumber.val()) !== -1 || serialsAll.indexOf(serialNumber.val()) !== -1) {
                            sameSerial = true;
                            return;
                        }
                        serials.push(serialNumber.val());
                    }
                    machines.push({
                        id: id,
                        name: serialNumber.data('name'),
                        code: serialNumber.data('code'),
                        registerDate: machineDate.val(),
                        serialNumber: serialNumber.val()
                    });
                }
            });
            if (emptySerial) {
                swal({
                    title: "Error!",
                    text: "Please enter serial number and register date for all selected machines!",
                    icon: "error",
                    button: "Ok",
                });
                return;
            }
            if (!lineupType) {
                swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please select a lineup type!',
                });
                return false;
            }
            if(sameSerial) {
                swal({
                    title: "Error!",
                    text: "You cannot give same serial number to different machines!",
                    icon: "error",
                    button: "Ok",
                });
                return;
            }
            if (machines.length === 0) {
                swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please select at least one machine!',
                });
                return false;
            }
            var lineup = customerLineups.find((lineup) => lineup.id == _id);
            lineup.lineup = {
                id: lineupType,
                name: $('#editmodalLineupType option:selected').text()
                };
            lineup.machines = machines;
            drawLineups();

            swal({
                icon: 'success',
                title: 'Success',
                text: 'Lineup edited successfully!',
            });

            $('.editmodalMachineSwitch').each(function() {
                if ($(this).is(':checked')) {
                    $(this).prop('checked', false);
                }
            });
            $('.editserialNumberInputs').val('');
            $('.editserialNumberInputs').slideUp();
            $('.editdateInputs').val('');
            $('.editdateInputs').slideUp();
            $('#editmodalLineupType').val('').trigger('change');
            bootstrap.Modal.getOrCreateInstance($('#editlineUpModal')).hide();
        });
    </script>
    <style>
        .lineup-row {
            padding: 15px 0;
        }

        .lineup-row:not(:first-child) {
            border-top: 3px solid rgba(236, 148, 25, 1);
            ;
        }

        .lineup-item {
            padding: 10px 0;
        }

        .lineup-row .lineup-item:not(:first-child) {
            border-top: 1px solid #ccc;
        }
    </style>
@endsection

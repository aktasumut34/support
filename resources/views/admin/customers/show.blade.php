@extends('layouts.adminmaster')

@section('styles')
    <!-- INTERNAL Sweet-Alert css -->
    <link href="{{ asset('assets/plugins/sweet-alert/sweetalert.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />


    <style>
        .modal-xl {
            width: 90%;
            max-width:1200px;
        }
    </style>
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

    <!-- Customer Edit -->
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header border-0">
                <h4 class="card-title">{{ trans('langconvert.admindashboard.editcustomer') }}</h4>
            </div>
            <form method="POST" action="{{ url('/admin/customer/' . $user->id) }}" enctype="multipart/form-data">
                <div class="card-body">
                    @csrf

                    @honeypot
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Company Name</label>
                                <input type="text" class="form-control" name="company_name"
                                    value="{{ $user->company_name, old('company_name') }}">

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
                                <textarea class="form-control" name="company_address" placeholder='Company Address'>{{ $user->company_address, old('company_address') }}</textarea>

                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{ trans('langconvert.admindashboard.firstname') }}</label>
                                <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                                    name="firstname" value="{{ $user->firstname, old('firstname') }}">
                                @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{ trans('langconvert.admindashboard.lastname') }}</label>
                                <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                                    name="lastname" value="{{ $user->lastname, old('lastname') }}">
                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{ trans('langconvert.admindashboard.username') }}</label>
                                <input type="text" class="form-control" name="name" value="{{ $user->username }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label
                                    class="form-label">{{ trans('langconvert.admindashboard.emailaddress') }}</label>
                                <input type="email @error('email') is-invalid @enderror" class="form-control" name="email"
                                    Value="{{ $user->email, old('email') }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">ACTY Contact No</label>
                                <input type="text" class="form-control" name="glass_number"
                                    value="{{ $user->glass_number, old('glass_number') }}">

                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label
                                    class="form-label">{{ trans('langconvert.admindashboard.mobilenumber') }}</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                                    value="{{ $user->phone, old('phone') }}">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">{{ trans('langconvert.admindashboard.status') }}</label>
                                <select class="form-control select2" data-placeholder="Select Status" name="status">
                                    <option label="Select Status"></option>
                                    @if ($user->status === '1')
                                        <option value="{{ $user->status }}"
                                            @if ($user->status === '1') selected @endif>Active</option>
                                        <option value="0">Inactive</option>
                                    @else
                                        <option value="{{ $user->status }}"
                                            @if ($user->status === '0') selected @endif>Inactive</option>
                                        <option value="1">Active</option>
                                    @endif

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 mt-4">
                            <div class="form-group">
                                <h3 class='mb-3'>Customer Line Ups</h3>
                                <input type="hidden" value="{{ $lineups, old('lineups') }}" name="lineups"
                                    id="lineUpInput" value="">
                                <div id='lineups'></div>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#lineUpModal">
                                    Add New Lineup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="form-group float-end">
                        <input type="submit" class="btn btn-secondary"
                            value="{{ trans('langconvert.admindashboard.savechanges') }}"
                            onclick="this.disabled=true;this.form.submit();">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Customer Edit -->

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
                            @foreach ($lineupsToSelect as $lineupToSelect)
                                <option value="{{ $lineupToSelect->id }}">{{ $lineupToSelect->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-12" style="margin-bottom: 1em; border-bottom: 1px solid #f0f0f0; padding-bottom: 1em;">
                        <label class="form-label">{{ trans('langconvert.usermenu.machines') }}</label>
                        <button class="btn btn-primary" id="addMachine">Add Machine</button>
                    </div>
                    <div id="machinesArea"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="addLineup" data-domid='-1'>Add Lineup</button>
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
                            @foreach ($lineupsToSelect as $lineupToSelect)
                                <option value="{{ $lineupToSelect->id }}">{{ $lineupToSelect->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-12" style="margin-bottom: 1em; border-bottom: 1px solid #f0f0f0; padding-bottom: 1em;">
                        <label class="form-label">{{ trans('langconvert.usermenu.machines') }}</label>
                        <button class="btn btn-primary" id="editaddMachine">Add Machine</button>
                    </div>
                    <div id="editmachinesArea"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="editLineup">Update Lineup</button>
                </div>
            </div>
        </div>
    </div>

    <div class='row d-none originalRow'>
        <div class="col-md-4 form-group">
            <label class="form-label">Machine</label>
            <select class="form-control" data-placeholder="Select Machine"
                name="machines[]" id="machineselect-changeme">
                <option label="Select Machine"></option>
                @foreach ($machines as $machine)
                    <option data-name='{{ $machine->name }}' data-code='{{ $machine->code }}' value="{{ $machine->id }}">{{ $machine->name }} ( {{ $machine->code }} )</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 form-group">
            <label class="form-label">Serial Number</label>
            <input type="text" class="form-control serialNumberInputs" id='serial-changeme' placeholder="Serial Number">
        </div>
        <div class="col-md-4 form-group">
            <label class="form-label">Register Date</label>
            <input type="date" class="form-control dateInputs" id='date-changeme' style='margin-top: .5em;' placeholder="Date" value="<?php echo date('Y-m-d'); ?>">
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
            $('.addMachine').each(function() {
                var id = $(this).data('id');
                var serialNumber = $('#serial-' + id);
                var machineDate = $('#date-' + id);
                var machine = $('#machineselect-' + id).val();
                var name = $('#machineselect-' + id).find(':selected').data('name');
                var code = $('#machineselect-' + id).find(':selected').data('code');
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
                    id: machine,
                    name: name,
                    code: code,
                    registerDate: machineDate.val(),
                    serialNumber: serialNumber.val()
                });
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
            $('#modalLineupType').val('').trigger('change');
            $('#machinesArea').html('');
            bootstrap.Modal.getOrCreateInstance($('#lineUpModal')).hide();
        });
        function randomString() {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
            for (var i = 0; i < 16; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));
            return text;
        }

        $("#addMachine").on('click', function() {
            let id = randomString();
            let row = $(".originalRow").clone();
            row.removeClass('d-none');
            row.removeClass('originalRow');
            row.addClass('addMachine');
            row.data('id', id);
            let copyHtml = row.prop('innerHTML');
            copyHtml = copyHtml.replaceAll(/changeme/g, id);
            row.html(copyHtml);
            $('#machinesArea').append(row);
            $('#machineselect-'+id).select2({
                placeholder: "Select Machine",
            });
        })

        function drawLineups() {
            var html = '';
            customerLineups.forEach((lineup) => {
                html += `
                    <div class='row lineup-row'>
                        <div class='col-md-3'>
                            <label style='font-weight: bold;'>Lineup Type</label>
                            <div>${lineup.lineup.name}</div>
                        </div>
                        <div class='col-md-6' >
                            <label style='font-weight: bold; display: flex; gap: 20px; align-items: center;'>Machines</label>
                            <div class='collapse' id='collapse-${lineup.id}'>
                                ${lineup.machines.map((machine) => {
                                return `
                                                        <div class='lineup-item'>
                                                            <div>${machine.name} (${machine.code || 'N/A'})</div>
                                                            <div>Serial Number: <b>${machine.serialNumber}</b></div>
                                                            <div>Register Date: <b>${new Date(machine.registerDate).toLocaleDateString()}</b></div>
                                                        </div>
                                                        `;
                                }).join('')}
                            </div>
                        </div>
                        <div class='col-md-3'>
                            <label style='font-weight: bold;'>Actions</label>
                            <div style='flex'>
                                <button type='button' class='action-btns1 editLineup' data-domid='${lineup.id}'><i class="feather feather-edit text-primary"></i></button>
                                <button type='button' class='action-btns1 deleteLineup' data-domid='${lineup.id}'><i class="feather feather-trash-2 text-danger"></i></button>
                                <a class='action-btns1' type='button' data-bs-toggle='collapse' href='#collapse-${lineup.id}' ><i class="feather feather-eye"></i></a>
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
            $('#editmachinesArea').html('');
            lineup.machines.forEach((machine) => {
                let row = $(".originalRow").clone();
                row.removeClass('d-none');
                row.removeClass('originalRow');
                row.addClass('editMachine');
                row.data('id', machine.id);
                let copyHtml = row.prop('innerHTML');
                copyHtml = copyHtml.replaceAll(/changeme/g, machine.id);
                row.html(copyHtml);
                $('#editmachinesArea').append(row);
                $('#machineselect-'+machine.id).select2({
                    placeholder: "Select Machine",
                });
                $('#machineselect-'+machine.id).val(machine.id).trigger('change');
                $('#date-'+machine.id).val(machine.registerDate);
                $('#serial-'+machine.id).val(machine.serialNumber);
            });
            bootstrap.Modal.getOrCreateInstance($('#editlineUpModal')).show();
        });

        $("#editaddMachine").on('click', function() {
            let id = randomString();
            let row = $(".originalRow").clone();
            row.removeClass('d-none');
            row.removeClass('originalRow');
            row.addClass('editMachine');
            row.data('id', id);
            let copyHtml = row.prop('innerHTML');
            copyHtml = copyHtml.replaceAll(/changeme/g, id);
            row.html(copyHtml);
            $('#editmachinesArea').append(row);
            $('#machineselect-'+id).select2({
                placeholder: "Select Machine",
            });
        })

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
            $('.editMachine').each(function() {
                var id = $(this).data('id');
                var serialNumber = $('#serial-' + id);
                var machineDate = $('#date-' + id);
                var machine = $('#machineselect-' + id).val();
                var name = $('#machineselect-' + id).find(':selected').data('name');
                var code = $('#machineselect-' + id).find(':selected').data('code');
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
                    id: machine,
                    name: name,
                    code: code,
                    registerDate: machineDate.val(),
                    serialNumber: serialNumber.val()
                });
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
            $("#editmachinesArea").html('');
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
        }
        .lineup-item {
            padding: 10px 0;
        }
        .lineup-row .lineup-item:not(:first-child) {
            border-top: 1px solid #ccc;
        }
    </style>
@endsection

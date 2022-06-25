<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\LineupDocuments;
use App\Models\Seosetting;
use App\Models\Pages;
use App\Models\Machines;
use App\Models\Lineups;
use App\Models\SpareParts;
use App\Models\MachineDocuments;
use App\Models\SparePartRequests;
use App\Models\SparePartRequestItems;
use App\Models\MachineSpareParts;
use App\Notifications\SparePartRequestNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use File;
use Image;
use DataTables;

class AdminMachineController extends Controller
{
    public function lineupindex()
    {
        $this->authorize('Lineup Access');

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        if (request()->ajax()) {
            $data = Lineups::get();
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    $button = '<div class = "d-flex">';
                    $button .= '<a href="' . url('/admin/lineups/' . $data->id) . '" class="action-btns1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="feather feather-edit text-primary"></i></a>';
                    $button .= '<a href="javascript:void(0)" class="action-btns1" data-id="' . $data->id . '" id="show-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="feather feather-trash-2 text-danger"></i></a>';
                    $button .= '</div>';
                    return $button;
                })
                ->addColumn('name', function ($data) {
                    return '<div><a href="#" class="h5">' .
                        Str::limit($data->name, '40') .
                        '</a></div>
                    <small class="fs-12 text-muted"> <span class="font-weight-normal1">' .
                        Str::limit($data->code, '40') .
                        '</span></small>';
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'name'])
                ->make(true);
        }

        return view('admin.lineups.index')
            ->with($data)
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function lineupcreate()
    {
        $this->authorize('Lineup Create');

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        return view('admin.lineups.create')
            ->with($data)
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function lineupstore(Request $request)
    {
        $this->authorize('Lineup Create');
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $machine = Lineups::create([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
        ]);

        return redirect('admin/lineups')->with('success', 'Lineup created successfully');
    }
    public function lineupshow($id)
    {
        $this->authorize('Machine Edit');
        $lineup = Lineups::where('id', $id)->first();
        $data['lineup'] = $lineup;

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        return view('admin.lineups.show')->with($data);
    }
    public function lineupupdate(Request $request, $id)
    {
        $this->authorize('Lineup Edit');
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'string|max:255|unique:lineups,code,' . $id,
        ]);

        $machine = Lineups::where('id', $id)->findOrFail($id);
        $machine->name = $request->input('name');
        $machine->code = $request->input('code');

        $machine->update();

        return redirect('/admin/lineups')->with('success', 'Lineup updated successfully');
    }
    public function lineupdelete($id)
    {
        $this->authorize('Machine Delete');
        $lineup = Lineups::findOrFail($id);

        $lineup->delete();
        return response()->json(['error' => 'Lineup deleted successfully.']);
    }
    public function machineindex()
    {
        $this->authorize('Machine Access');

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        if (request()->ajax()) {
            $data = Machines::get();
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    $button = '<div class = "d-flex">';
                    $button .= '<a href="' . url('/admin/machines/' . $data->id) . '" class="action-btns1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="feather feather-edit text-primary"></i></a>';
                    $button .= '<a href="javascript:void(0)" class="action-btns1" data-id="' . $data->id . '" id="show-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="feather feather-trash-2 text-danger"></i></a>';
                    $button .= '</div>';
                    return $button;
                })
                ->addColumn('image', function ($data) {
                    return '<img src="' . $data->image . '" />';
                })
                ->addColumn('name', function ($data) {
                    return '<div><a href="#" class="h5">' .
                        Str::limit($data->name, '40') .
                        '</a></div>
                    <small class="fs-12 text-muted"> <span class="font-weight-normal1">' .
                        Str::limit($data->code, '40') .
                        '</span></small>';
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'image', 'name'])
                ->make(true);
        }

        return view('admin.machines.index')
            ->with($data)
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function machinecreate()
    {
        $this->authorize('Machine Create');

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        return view('admin.machines.create')
            ->with($data)
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function machinestore(Request $request)
    {
        $this->authorize('Machine Create');
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'string|max:255|unique:machines',
        ]);

        $machine = Machines::create([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'image' => 'created',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileArray = ['image' => $file];
            $rules = [
                'image' => 'mimes:jpeg,jpg,png|required',
            ];

            // Now pass the input and rules into the validator
            $validator = Validator::make($fileArray, $rules);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with('error', trans('langconvert.functions.imagevalidatefails'));
            } else {
                $destination = public_path() . '/uploads/machines';
                $image_name = time() . '.' . $file->getClientOriginalExtension();
                $resize_image = Image::make($file->getRealPath());

                $resize_image
                    ->resize(300, 300, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save($destination . '/' . $image_name);

                $destinations = public_path() . '/uploads/machines/' . $machine->image;
                if (File::exists($destinations)) {
                    File::delete($destinations);
                }
                $file = $request->file('image');
                $machine->update(['image' => '/uploads/machines/' . $image_name]);
            }
        }

        return redirect('admin/machines')->with('success', 'Machine created successfully');
    }
    public function machineshow($id)
    {
        $this->authorize('Machine Edit');
        $machine = Machines::where('id', $id)->first();
        $data['machine'] = $machine;

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        return view('admin.machines.show')->with($data);
    }
    public function machineupdate(Request $request, $id)
    {
        $this->authorize('Machine Edit');
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'string|max:255|unique:machines,code,' . $id,
        ]);

        $machine = Machines::where('id', $id)->findOrFail($id);
        $machine->name = $request->input('name');
        $machine->code = $request->input('code');

        $machine->update();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileArray = ['image' => $file];
            $rules = [
                'image' => 'mimes:jpeg,jpg,png|required',
            ];

            // Now pass the input and rules into the validator
            $validator = Validator::make($fileArray, $rules);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with('error', trans('langconvert.functions.imagevalidatefails'));
            } else {
                $destination = public_path() . '/uploads/machines';
                $image_name = time() . '.' . $file->getClientOriginalExtension();
                $resize_image = Image::make($file->getRealPath());

                $resize_image
                    ->resize(300, 300, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save($destination . '/' . $image_name);

                $destinations = public_path() . '/uploads/machines/' . $machine->image;
                if (File::exists($destinations)) {
                    File::delete($destinations);
                }
                $file = $request->file('image');
                $machine->update(['image' => '/uploads/machines/' . $image_name]);
            }
        }

        return redirect('/admin/machines')->with('success', 'Machine updated successfully');
    }
    public function machinedelete($id)
    {
        $this->authorize('Machine Delete');
        $machine = Machines::findOrFail($id);
        foreach ($machine->spare_parts as $spare_part) {
            $spare_part->delete();
        }
        foreach ($machine->documents as $document) {
            $document->delete();
        }

        $machine->delete();
        return response()->json(['error' => 'Machine deleted successfully.']);
    }

    public function sparepartindex()
    {
        $this->authorize('Spare Part Access');

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        if (request()->ajax()) {
            $data = SpareParts::with('machine')->get();
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    $button = '<div class = "d-flex">';
                    $button .= '<a href="' . url('/admin/spare-parts/' . $data->id) . '" class="action-btns1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="feather feather-edit text-primary"></i></a>';
                    $button .= '<a href="javascript:void(0)" class="action-btns1" data-id="' . $data->id . '" id="show-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="feather feather-trash-2 text-danger"></i></a>';
                    $button .= '</div>';
                    return $button;
                })
                ->addColumn('image', function ($data) {
                    return '<img src="' . $data->image . '" />';
                })
                ->addColumn('machine_name', function ($data) {
                    $str = '';
                    foreach($data->machine as $machine) {$str .= '<div><a href="#" class="h5">' .
                        Str::limit($machine->name, '40') .
                        '</a>
                    <small class="fs-12 text-muted">' .
                        Str::limit($machine->code, '40') .
                        '</small></div>';}
                    return $str;
                })
                ->addColumn('name', function ($data) {
                    return '<div><a href="#" class="h5">' .
                        Str::limit($data->name, '40') .
                        '</a></div>
                    <small class="fs-12 text-muted"> <span class="font-weight-normal1">' .
                        Str::limit($data->code, '40') .
                        '</span></small>';
                })
                ->addColumn('size', function ($data) {
                    return '<div class="h5">' .
                        Str::limit($data->size, '40') .
                        '</div>';
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'image', 'name', 'size', 'machine_name'])
                ->make(true);
        }

        return view('admin.spare-parts.index')
            ->with($data)
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function sparepartcreate()
    {
        $this->authorize('Spare Parts Create');

        $title = Apptitle::first();
        $data['title'] = $title;

        $machines = Machines::all();
        $data['machines'] = $machines;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        return view('admin.spare-parts.create')
            ->with($data)
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function sparepartstore(Request $request)
    {
        $this->authorize('Spare Part Create');
        $request->validate([
            'name' => 'required|string|max:255',
            'machine_id' => 'required|array',
            'code' => 'string|max:255|unique:machines',
            'size' => 'string|max:255',
        ]);

        $sparePart = SpareParts::create([
            'name' => $request->input('name'),
            'machine_id' => $request->input('machine_id')[0],
            'code' => $request->input('code'),
            'size' => $request->input('size'),
            'image' => 'created',
        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileArray = ['image' => $file];
            $rules = [
                'image' => 'mimes:jpeg,jpg,png|required',
            ];

            // Now pass the input and rules into the validator
            $validator = Validator::make($fileArray, $rules);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with('error', trans('langconvert.functions.imagevalidatefails'));
            } else {
                $destination = public_path() . '/uploads/spare-parts';
                $image_name = time() . '.' . $file->getClientOriginalExtension();
                $resize_image = Image::make($file->getRealPath());

                $resize_image
                    ->resize(300, 300, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save($destination . '/' . $image_name);

                $destinations = public_path() . '/uploads/spare-parts/' . $sparePart->image;
                if (File::exists($destinations)) {
                    File::delete($destinations);
                }
                $file = $request->file('image');
                $sparePart->update(['image' => '/uploads/spare-parts/' . $image_name]);
            }
        }
        $sparePart->machine()->attach($request->input('machine_id'));
        return redirect('admin/spare-parts')->with('success', 'Spare Part created successfully');
    }
    public function sparepartshow($id)
    {
        $this->authorize('Spare Part Edit');
        $sparePart = SpareParts::where('id', $id)->first();
        $data['sparePart'] = $sparePart;

        $machines = Machines::all();
        $data['machines'] = $machines;

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        return view('admin.spare-parts.show')->with($data);
    }
    public function sparepartupdate(Request $request, $id)
    {
        $this->authorize('Spare Part Edit');

        $request->validate([
            'name' => 'required|string|max:255',
            'machine_id' => 'required|array',
            'code' => 'string|max:255|unique:spare_parts,code,' . $id,
            'size' => 'string|max:255',
        ]);

        $sparePart = SpareParts::where('id', $id)->findOrFail($id);
        $sparePart->name = $request->input('name');
        $sparePart->code = $request->input('code');
        $sparePart->machine_id = $request->input('machine_id')[0];
        $sparePart->size = $request->input('size');

        $sparePart->update();

        $sparePart->machine()->sync($request->input('machine_id'));
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileArray = ['image' => $file];
            $rules = [
                'image' => 'mimes:jpeg,jpg,png|required',
            ];

            // Now pass the input and rules into the validator
            $validator = Validator::make($fileArray, $rules);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with('error', trans('langconvert.functions.imagevalidatefails'));
            } else {
                $destination = public_path() . '/uploads/spare-parts';
                $image_name = time() . '.' . $file->getClientOriginalExtension();
                $resize_image = Image::make($file->getRealPath());

                $resize_image
                    ->resize(300, 300, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save($destination . '/' . $image_name);

                $destinations = public_path() . '/uploads/spare-parts/' . $sparePart->image;
                if (File::exists($destinations)) {
                    File::delete($destinations);
                }
                $file = $request->file('image');
                $sparePart->update(['image' => '/uploads/spare-parts/' . $image_name]);
            }
        }
        return redirect('/admin/spare-parts')->with('success', 'Spare Part updated successfully');
    }
    public function sparepartdelete($id)
    {
        $this->authorize('Spare Part Delete');
        $sparePart = SpareParts::findOrFail($id);
        $sparePart->delete();
        return response()->json(['error' => 'Spare Part deleted successfully.']);
    }

    public function machinedocumentindex()
    {
        $this->authorize('Machine Document Access');

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        if (request()->ajax()) {
            $data = MachineDocuments::with('machine')->get();
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    $button = '<div class = "d-flex">';
                    $button .= '<a href="' . url('/admin/machine-documents/' . $data->id) . '" class="action-btns1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="feather feather-edit text-primary"></i></a>';
                    $button .= '<a href="javascript:void(0)" class="action-btns1" data-id="' . $data->id . '" id="show-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="feather feather-trash-2 text-danger"></i></a>';
                    $button .= '</div>';
                    return $button;
                })
                ->addColumn('machine_name', function ($data) {
                    if ($data->machine) {
                        return '<div><a href="#" class="h5">' .
                            Str::limit($data->machine->name, '40') .
                            '</a></div>
                    <small class="fs-12 text-muted"> <span class="font-weight-normal1">' .
                            Str::limit($data->machine->code, '40') .
                            '</span></small>';
                    } else {
                        return '<div><span class="h5">' . Str::limit('Not Found', '40') . '</span></div>';
                    }
                })
                ->addColumn('path', function ($data) {
                    return '<div><a href="' . $data->path . '" target="_blank" class="h5">' . Str::limit($data->name, '40') . '</a></div>';
                })
                ->addColumn('type', function ($data) {
                    return '<div><span class="h5">' . Str::limit($data->type, '40') . '</span  ></div>';
                })
                ->addColumn('name', function ($data) {
                    return '<div><span class="h5">' . Str::limit($data->name, '40') . '</span></div>';
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'type', 'path', 'name', 'machine_name'])
                ->make(true);
        }

        return view('admin.machine-documents.index')
            ->with($data)
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function machinedocumentcreate()
    {
        $this->authorize('Machine Document Create');

        $title = Apptitle::first();
        $data['title'] = $title;

        $machines = Machines::all();
        $data['machines'] = $machines;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        return view('admin.machine-documents.create')
            ->with($data)
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function machinedocumentstore(Request $request)
    {
        $this->authorize('Machine Document Create');
        $request->validate([
            'name' => 'required|string|max:255',
            'machine_id' => 'required|numeric',
            'type' => 'required|string|max:255',
        ]);

        $document = MachineDocuments::create([
            'name' => $request->input('name'),
            'machine_id' => $request->input('machine_id'),
            'type' => $request->input('type'),
            'path' => 'created',
        ]);

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $fileArray = ['document' => $file];
            $rules = [
                'document' => 'mimes:mp4,pdf,doc,docx,xls,xlsx,qt|required',
            ];

            $validator = Validator::make($fileArray, $rules);

            if ($validator->fails()) {
                return response()->json(['success'=>false, 'error' => 'Document can only be pdf,doc,docx,xls,xlsx,mp4 format']);
            } else {
                $destination = public_path() . '/uploads/documents';
                $path = time() . '.' . $file->getClientOriginalExtension();
                $file->move($destination, $path);

                $document->update(['path' => '/uploads/documents/' . $path]);
            }
        }
        return response()->json(['success'=>true, 'url' => url('/admin/machine-documents/')]);
    }
    public function machinedocumentshow($id)
    {
        $this->authorize('Machine Document Edit');
        $document = MachineDocuments::where('id', $id)->first();
        $data['document'] = $document;

        $machines = Machines::all();
        $data['machines'] = $machines;

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        return view('admin.machine-documents.show')->with($data);
    }
    public function machinedocumentupdate(Request $request, $id)
    {
        $this->authorize('Machine Document Edit');

        $request->validate([
            'name' => 'required|string|max:255',
            'machine_id' => 'required|numeric',
            'type' => 'required|string|max:255'
        ]);

        $document = MachineDocuments::where('id', $id)->findOrFail($id);
        $document->name = $request->input('name');
        $document->type = $request->input('type');
        $document->machine_id = $request->input('machine_id');

        $document->update();

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $fileArray = ['document' => $file];
            $rules = [
                'document' => 'mimes:mp4,pdf,doc,docx,xls,xlsx,qt|required',
            ];

            // Now pass the input and rules into the validator
            $validator = Validator::make($fileArray, $rules);

            if ($validator->fails()) {
                return response()->json(['success'=>false, 'error' => 'Document can only be pdf,doc,docx,xls,xlsx,mp4 format']);
            } else {
                $destination = public_path() . '/uploads/documents';
                $path = time() . '.' . $file->getClientOriginalExtension();
                $file->move($destination, $path);

                $document->update(['path' => '/uploads/documents/' . $path]);
            }
        }

        return response()->json(['success'=>true, 'url' => url('/admin/machine-documents/')]);
    }
    public function machinedocumentdelete($id)
    {
        $this->authorize('Machine Document Delete');
        $machineDocument = MachineDocuments::findOrFail($id);
        $machineDocument->delete();
        return response()->json(['error' => 'Machine Document deleted successfully.']);
    }

    public function sparepartrequestindex()
    {
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        if (request()->ajax()) {
            $data = SparePartRequests::orderBy('updated_at', 'DESC')->get();

            return DataTables::of($data)
                ->addColumn('id', function ($data) {
                    return '<a href="' . route('sparepartrequestshow', $data->id) . '">' . $data->id . '</a>';
                })
                ->addColumn('subject', function ($data) {
                    $subject = '<a href="' . route('sparepartrequestshow', $data->id) . '">' . $data->request_no . '</a>';
                    return $subject;
                })
                ->addColumn('customer', function ($data) {
                    return $data->customer->username . '<br/><small>' . $data->customer->company_name . '</small>';
                })
                ->addColumn('created_at', function ($data) {
                    $created_at = $data->created_at->format(setting('date_format'));
                    return $created_at;
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == 'New') {
                        $status = '<span class="badge badge-burnt-orange"> ' . $data->status . ' </span>';
                    } elseif ($data->status == 'Waiting for Approval') {
                        $status = '<span class="badge badge-info">' . $data->status . '</span>';
                    } elseif ($data->status == 'Approved' || $data->status == 'Shipped') {
                        $status = '<span class="badge badge-success">' . $data->status . '</span>';
                    } else {
                        $status = '<span class="badge badge-danger">' . $data->status . '</span>';
                    }
                    return $status;
                })
                ->addColumn('updated_at', function ($data) {
                    if ($data->updated_at == null) {
                        $updated_at = $data->created_at->diffForHumans();
                    } else {
                        $updated_at = $data->updated_at->diffForHumans();
                    }

                    return $updated_at;
                })
                ->addColumn('action', function ($data) {
                    $button = '<div class = "d-flex">';
                    $button .= '<a href="' . route('sparepartrequestshow', $data->id) . '" class="action-btns1" data-bs-toggle="tooltip" data-placement="top" title="View Request"><i class="feather feather-eye text-primary"></i></a>';
                    $button .= '</div>';
                    return $button;
                })
                ->rawColumns(['action', 'subject', 'status', 'customer', 'created_at', 'updated_at', 'id'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.spare-part-request.index', compact('title', 'footertext'))->with($data);
    }

    public function sparepartrequestshow($id)
    {
        $this->authorize('Spare Part Request Show');
        $sparePartRequest = SparePartRequests::where('id', $id)
            ->with('items.sparePart', 'items.customerLineupMachine.machine', 'customer')
            ->first();
        $data['sparePartRequest'] = $sparePartRequest;

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        return view('admin.spare-part-request.show')->with($data);
    }

    public function sparepartrequestupdate(Request $rq, $id)
    {
        $sparePartRequest = SparePartRequests::where('id', $id)->findOrFail($id);
        if($sparePartRequest->status == 'New' || $sparePartRequest->status == 'Rejected' || $sparePartRequest->status == 'Waiting for Approval'){
            $items = json_decode($rq->items, true);
            foreach($items as $item) {
                $sparePartRequestItem = SparePartRequestItems::find($item['id']);
                $sparePartRequestItem->update([
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
            $sparePartRequest->status = 'Waiting for Approval';
        } else if($sparePartRequest->status == 'Approved'){
            if($rq->tracking_number == '') {
                return redirect()->back()->with('error', 'Please enter valid tracking number');
            }
            $sparePartRequest->status = 'Shipped - Tracking Number: ' . $rq->tracking_number;
        } else {
            return redirect()->back()->with('error', 'You can not update this request');
        }
        $sparePartRequest->update();
        $customer = $sparePartRequest->customer;
        $customer->notify(new SparePartRequestNotification($sparePartRequest));
        return redirect('/admin/spare-part-requests')->with('success', 'Spare Part Request updated successfully');
    }



    public function lineupdocumentindex()
    {
        $this->authorize('Lineup Document Access');

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        if (request()->ajax()) {
            $data = LineupDocuments::with('lineup')->get();
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    $button = '<div class = "d-flex">';
                    $button .= '<a href="' . url('/admin/lineup-documents/' . $data->id) . '" class="action-btns1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="feather feather-edit text-primary"></i></a>';
                    $button .= '<a href="javascript:void(0)" class="action-btns1" data-id="' . $data->id . '" id="show-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="feather feather-trash-2 text-danger"></i></a>';
                    $button .= '</div>';
                    return $button;
                })
                ->addColumn('lineup_name', function ($data) {
                    if ($data->lineup) {
                        return '<div><a href="#" class="h5">' .
                            Str::limit($data->lineup->name, '40') .
                            '</a></div>
                    <small class="fs-12 text-muted"> <span class="font-weight-normal1">' .
                            Str::limit($data->lineup->code, '40') .
                            '</span></small>';
                    } else {
                        return '<div><span class="h5">' . Str::limit('Not Found', '40') . '</span></div>';
                    }
                })
                ->addColumn('path', function ($data) {
                    return '<div><a href="' . $data->path . '" target="_blank" class="h5">' . Str::limit($data->name, '40') . '</a></div>';
                })
                ->addColumn('type', function ($data) {
                    return '<div><span class="h5">' . Str::limit($data->type, '40') . '</span  ></div>';
                })
                ->addColumn('name', function ($data) {
                    return '<div><span class="h5">' . Str::limit($data->name, '40') . '</span></div>';
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'type', 'path', 'name', 'lineup_name'])
                ->make(true);
        }

        return view('admin.lineup-documents.index')
            ->with($data)
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function lineupdocumentcreate()
    {
        $this->authorize('Lineup Document Create');

        $title = Apptitle::first();
        $data['title'] = $title;

        $lineups = Lineups::all();
        $data['lineups'] = $lineups;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        return view('admin.lineup-documents.create')
            ->with($data)
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function lineupdocumentstore(Request $request)
    {
        $this->authorize('Lineup Document Create');
        $request->validate([
            'name' => 'required|string|max:255',
            'lineup_id' => 'required|numeric',
            'type' => 'required|string|max:255',
        ]);

        $document = LineupDocuments::create([
            'name' => $request->input('name'),
            'lineup_id' => $request->input('lineup_id'),
            'type' => $request->input('type'),
            'path' => 'created',
        ]);

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $fileArray = ['document' => $file];
            $rules = [
                'document' => 'mimes:mp4,pdf,doc,docx,xls,xlsx,qt|required',
            ];

            // Now pass the input and rules into the validator
            $validator = Validator::make($fileArray, $rules);

            if ($validator->fails()) {
                return response()->json(['success'=>false, 'error' => 'Document can only be pdf,doc,docx,xls,xlsx,mp4 format']);
            } else {
                $destination = public_path() . '/uploads/documents';
                $path = time() . '.' . $file->getClientOriginalExtension();
                $file->move($destination, $path);

                $document->update(['path' => '/uploads/documents/' . $path]);
            }
        }
        return response()->json(['success'=>true, 'url' => url('/admin/lineup-documents/')]);
    }
    public function lineupdocumentshow($id)
    {
        $this->authorize('Lineup Document Edit');
        $document = LineupDocuments::where('id', $id)->first();
        $data['document'] = $document;

        $lineups = Lineups::all();
        $data['lineups'] = $lineups;

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        return view('admin.lineup-documents.show')->with($data);
    }
    public function lineupdocumentupdate(Request $request, $id)
    {
        $this->authorize('Lineup Document Edit');

        $request->validate([
            'name' => 'required|string|max:255',
            'lineup_id' => 'required|numeric',
            'type' => 'required|string|max:255'
        ]);

        $document = LineupDocuments::where('id', $id)->findOrFail($id);
        $document->name = $request->input('name');
        $document->type = $request->input('type');
        $document->lineup_id = $request->input('lineup_id');

        $document->update();

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $fileArray = ['document' => $file];
            $rules = [
                'document' => 'mimes:mp4,pdf,doc,docx,xls,xlsx,qt|required',
            ];

            // Now pass the input and rules into the validator
            $validator = Validator::make($fileArray, $rules);

            if ($validator->fails()) {
                return response()->json(['success'=>false, 'error' => 'Document can only be pdf,doc,docx,xls,xlsx,mp4 format']);
            } else {
                $destination = public_path() . '/uploads/documents';
                $path = time() . '.' . $file->getClientOriginalExtension();
                $file->move($destination, $path);

                $document->update(['path' => '/uploads/documents/' . $path]);
            }
        }

        return response()->json(['success'=>true, 'url' => url('/admin/lineup-documents/')]);
    }
    public function lineupdocumentdelete($id)
    {
        $this->authorize('Lineup Document Delete');
        $lineupDocument = LineupDocuments::findOrFail($id);
        $lineupDocument->delete();
        return response()->json(['error' => 'Lineup Document deleted successfully.']);
    }
}

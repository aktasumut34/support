<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use App\Models\CustomerLineups;
use App\Models\CustomerLineupMachines;
use App\Models\SparePartRequests;
use App\Models\SparePartRequestItems;
use App\Models\User;
use App\Notifications\SparePartRequestNotification;
use Auth;

use DataTables;
use Str;
use Validator;

class SparePartController extends Controller
{
    public function index()
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
            $data = SparePartRequests::where('customer_id', Auth::guard('customer')->user()->id)
                ->orderBy('updated_at', 'DESC')
                ->get();

            return DataTables::of($data)
                ->addColumn('id', function ($data) {
                    return '<a href="' . route('spare-part-request-show', $data->id) . '">' . $data->id . '</a>';
                })
                ->addColumn('subject', function ($data) {
                    $subject = '<a href="' . route('spare-part-request-show', $data->id) . '">' . $data->request_no . '</a>';
                    return $subject;
                })
                ->addColumn('created_at', function ($data) {
                    $created_at = $data->created_at->format(setting('date_format'));
                    return $created_at;
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == 'New') {
                        $status = '<span class="badge badge-burnt-orange"> ' . $data->status . ' </span>';
                    } elseif ($data->status == 'Preparing') {
                        $status = '<span class="badge badge-teal">' . $data->status . '</span> ';
                    } elseif ($data->status == 'Shipped') {
                        $status = '<span class="badge badge-info">' . $data->status . '</span>';
                    } elseif ($data->status == 'Completed') {
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
                    $button .= '<a href="' . route('spare-part-request-show', $data->id) . '" class="action-btns1" data-bs-toggle="tooltip" data-placement="top" title="View Request"><i class="feather feather-eye text-primary"></i></a>';
                    $button .= '</div>';
                    return $button;
                })
                ->rawColumns(['action', 'subject', 'status', 'created_at', 'updated_at', 'id'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('user.spare-part-request', compact('title', 'footertext'))->with($data);
    }
    public function new()
    {
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        $lineups = CustomerLineups::where('customer_id', Auth::guard('customer')->user()->id)
            ->with('machines.spare_parts')
            ->with('lineups')
            ->get();
        $lineUpArray = [];

        foreach ($lineups as $lineup) {
            if (isset($lineUpArray[$lineup->lineups->id])) $lineUpArray[$lineup->lineups->id]++;
            else $lineUpArray[$lineup->lineups->id] = 1;
            $lineup->name = $lineup->lineups->name . ' - ' . $lineUpArray[$lineup->lineups->id];
            $lineup->term = '';
            $lineup->show = $lineups[0] == $lineup;
            foreach ($lineup->machines as $machine) {
                $machine->show = $lineup->machines[0] == $machine;
                foreach ($machine->spare_parts as $spare_part) {
                    $spare_part->quantity = 1;
                }
            }
        }
        $data['lineups'] = $lineups;

        return view('user.spare-part-request-new', compact('title', 'footertext'))->with($data);
    }
    public function store(Request $rq)
    {
        $cart = json_decode($rq->cart);
        $rules = [
            'machine.*.pivot.customer_lineup_id' => 'required|numeric',
            'machine.*.pivot.machine_id' => 'required|numeric',
            'spare_parts.*.id' => 'required|numeric',
            'spare_parts.*.quantity' => 'required|numeric',
        ];
        $validator = Validator::make($cart, $rules);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator);
        }

        $sparePartRequest = SparePartRequests::create([
            'customer_id' => Auth::guard('customer')->user()->id,
            'request_no' => Str::upper(Str::random(12)),
            'status' => 'New',
        ]);
        foreach ($cart as $item) {
            $lineupMachine = CustomerLineupMachines::where('customer_lineup_id', $item->machine->pivot->customer_lineup_id)
                ->where('machine_id', $item->machine->pivot->machine_id)
                ->first();
            foreach ($item->spare_parts as $sparePart) {
                $spri = SparePartRequestItems::create([
                    'spare_part_request_id' => $sparePartRequest->id,
                    'customer_lineup_machine_id' => $lineupMachine->id,
                    'spare_part_id' => $sparePart->id,
                    'quantity' => $sparePart->quantity,
                ]);
            }
        }
        $admins = User::get();
        foreach ($admins as $admin) {
            $admin->notify(new SparePartRequestNotification($sparePartRequest));
        }
        return redirect()
            ->route('spare-part-request')
            ->with('success', 'Spare Part Request Created Successfully');
    }
    public function show($id)
    {
        $sparePartRequest = SparePartRequests::where('id', $id)
            ->where('customer_id', Auth::guard('customer')->user()->id)
            ->with('items.sparePart', 'items.customerLineupMachine.machine')
            ->first();
        if ($sparePartRequest == null) {
            return redirect()
                ->route('spare-part-request')
                ->with('error', 'Spare Part Request Not Found');
        }
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        $data['sparePartRequest'] = $sparePartRequest;

        return view('user.spare-part-request-show', compact('title', 'footertext'))->with($data);
    }
    public function update(Request $rq, $id) {
        $sparePartRequest = SparePartRequests::where('id', $id)
            ->where('customer_id', Auth::guard('customer')->user()->id)
            ->first();
        if ($sparePartRequest == null) {
            return redirect()
                ->route('spare-part-request')
                ->with('error', 'Spare Part Request Not Found');
        }
        if($rq->status == 'Approve') $sparePartRequest->status = 'Approved';
        else if($rq->status == 'Reject') $sparePartRequest->status = 'Rejected';
        else if($rq->status == 'Cancel') $sparePartRequest->status = 'Cancelled';
        $sparePartRequest->save();
        $admins = User::get();
        foreach ($admins as $admin) {
            $admin->notify(new SparePartRequestNotification($sparePartRequest));
        }
        return redirect()
            ->route('spare-part-request')
            ->with('success', 'Spare Part Request Updated Successfully');
    }
}

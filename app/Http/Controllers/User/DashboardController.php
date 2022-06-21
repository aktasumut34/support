<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Hash;
use AuthenticatesUsers;
use App\Models\User;
use App\Models\Ticket\Ticket;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use App\Models\CustomerLineups;
use App\Models\LineupDocuments;
use App\Models\Lineups;
use App\Models\Machines;
use App\Models\MachineDocuments;
use DataTables;
use Str;

class DashboardController extends Controller
{
    public function userTickets()
    {
        $tickets = Ticket::where('cust_id', Auth::guard('customer')->user()->id)->get();

        $active = Ticket::where('cust_id', Auth::guard('customer')->user()->id)
            ->whereIn('status', ['New', 'Re-Open'])
            ->get();

        $closed = Ticket::where('cust_id', Auth::guard('customer')->user()->id)
            ->where('status', 'Closed')
            ->get();

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        if (request()->ajax()) {
            $data = Ticket::where('cust_id', Auth::guard('customer')->user()->id)
                ->latest('updated_at')
                ->get();

            return DataTables::of($data)

                ->addColumn('ticket_id', function ($data) {
                    return '<a href="' . route('loadmore.load_data', $data->ticket_id) . '">' . $data->ticket_id . '</a>';
                })
                ->addColumn('subject', function ($data) {
                    $subject = '<a href="' . route('loadmore.load_data', $data->ticket_id) . '">' . Str::limit($data->subject, '10') . '</a>';
                    return $subject;
                })
                ->addColumn('priority', function ($data) {
                    if ($data->priority != null) {
                        if ($data->priority == 'Low') {
                            $priority = '<span class="badge badge-success-light">' . $data->priority . '</span>';
                        } elseif ($data->priority == 'High') {
                            $priority = '<span class="badge badge-danger-light">' . $data->priority . '</span>';
                        } elseif ($data->priority == 'Critical') {
                            $priority = '<span class="badge badge-danger-dark">' . $data->priority . '</span>';
                        } else {
                            $priority = '<span class="badge badge-warning-light">' . $data->priority . '</span>';
                        }
                    } else {
                        $priority = '~';
                    }
                    return $priority;
                })
                ->addColumn('created_at', function ($data) {
                    $created_at = $data->created_at->format(setting('date_format'));
                    return $created_at;
                })
                ->addColumn('category_id', function ($data) {
                    if ($data->category_id != null) {
                        $category_id = Str::limit($data->category->name, '10');
                        return $category_id;
                    } else {
                        return '~';
                    }
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == 'New') {
                        $status = '<span class="badge badge-burnt-orange"> ' . $data->status . ' </span>';
                    } elseif ($data->status == 'Re-Open') {
                        $status = '<span class="badge badge-teal">' . $data->status . '</span> ';
                    } elseif ($data->status == 'Inprogress') {
                        $status = '<span class="badge badge-info">' . $data->status . '</span>';
                    } elseif ($data->status == 'On-Hold') {
                        $status = '<span class="badge badge-warning">' . $data->status . '</span>';
                    } else {
                        $status = '<span class="badge badge-danger">' . $data->status . '</span>';
                    }

                    return $status;
                })
                ->addColumn('last_reply', function ($data) {
                    if ($data->last_reply == null) {
                        $last_reply = $data->created_at->diffForHumans();
                    } else {
                        $last_reply = $data->last_reply->diffForHumans();
                    }

                    return $last_reply;
                })
                ->addColumn('action', function ($data) {
                    $button = '<div class = "d-flex">';
                    $button .=
                        '<a href="' .
                        route('loadmore.load_data', $data->ticket_id) .
                        '" class="action-btns1" data-bs-toggle="tooltip" data-placement="top" title="View Ticket"><i class="feather feather-edit text-primary"></i></a>';
                    $button .= '</div>';
                    return $button;
                })
                ->addColumn('checkbox', '<input type="checkbox" name="student_checkbox[]" class="checkall" value="{{ $id }}" />')
                ->rawColumns(['action', 'subject', 'status', 'priority', 'created_at', 'last_reply', 'ticket_id', 'checkbox'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('user.dashboard', compact('tickets', 'active', 'closed', 'title', 'footertext'))->with($data);
    }

    public function notify()
    {
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;
        return view('user.notification')->with($data);
    }

    public function markNotification(Request $request)
    {
        auth()
            ->guard('customer')
            ->user()
            ->unreadNotifications->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();

        return response()->noContent();
    }

    public function machines()
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
            ->with('machines')
            ->with('lineups')
            ->get();
        $lineUpArray = [];
        foreach ($lineups as $lineup) {
            if (isset($lineUpArray[$lineup->lineups->id])) $lineUpArray[$lineup->lineups->id]++;
            else $lineUpArray[$lineup->lineups->id] = 1;
            $lineup->name = $lineup->lineups->name . ' - ' . $lineUpArray[$lineup->lineups->id];
            $lineup->id = $lineup->lineups->id;
        }
        $data['lineups'] = $lineups;

        return view('user.machines', compact('title', 'footertext'))->with($data);
    }

    public function singlemachine(Request $rq)
    {
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        $machine = Machines::where('id', $rq->id)->first();

        $data['machine'] = $machine;

        $data['documents'] = MachineDocuments::where('machine_id', $rq->id)
            ->where('type', 'document')
            ->get();
        $data['videos'] = MachineDocuments::where('machine_id', $rq->id)
            ->where('type', 'video')
            ->get();
        return view('user.machine', compact('title', 'footertext'))->with($data);
    }
    public function singlelineup(Request $rq)
    {
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        $lineup = Lineups::where('id', $rq->id)->first();

        $data['lineup'] = $lineup;

        $data['documents'] = LineupDocuments::where('lineup_id', $rq->id)
            ->where('type', 'document')
            ->get();
        $data['videos'] = LineupDocuments::where('lineup_id', $rq->id)
            ->where('type', 'video')
            ->get();
        return view('user.lineup', compact('title', 'footertext'))->with($data);
    }
}

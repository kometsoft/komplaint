<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\{Complaint, ActionStatus};
use App\Notifications\NewComplaintNotification;
use App\Http\Requests\{StoreComplaintRequest, UpdateComplaintRequest};

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $complaints = Complaint::query()
            ->with('action.action_status')
            ->when(isset($request->filter['title']), function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->filter['title'] . '%');
            })
            ->when(isset($request->filter['created_at']), function ($query) use ($request) {
                $date = Carbon::createFromFormat('d/m/Y', $request->filter['created_at'])->format('Y-m-d');
                $query->whereDate('created_at', '=', $date);
            })
            ->when(isset($request->filter['action_status_id']), function ($query) use ($request) {
                $query->whereHas('action', function ($query) use ($request) {
                    $query->where('action_status_id', $request->filter['action_status_id']);
                });
            })
            ->latest()
            ->paginate(10);

        $action_statuses = ActionStatus::select('id', 'name')->get();

        return view('complaints.index', compact('complaints', 'action_statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $complaint = new Complaint();

        return view('complaints.create', compact('complaint'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComplaintRequest $request)
    {
        $complaint = Complaint::create([
            'uuid' => Str::uuid(),
            'title' => $request->title,
            'body' => $request->body,
        ]);

        $complaint->actions()->create([
            'action_status_id' => ActionStatus::PENDING,
            'description' => 'Complaint will be reviewed',
            'complaint_id' => $complaint->id,
        ]);

        $request->hasFile('attachment') && $complaint
            ->addMediaFromRequest('attachment')
            ->toMediaCollection();

        User::where('email', 'user@domain.com')
            ->first()
            ->notify(new NewComplaintNotification($complaint));

        return to_route('complaints.edit', $complaint)->with('success', 'Record has been saved!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Complaint $complaint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complaint $complaint)
    {
        $action_statuses = ActionStatus::select('id', 'name')->whereIn('id', [2, 3])->get();

        return view('complaints.edit', compact('complaint', 'action_statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComplaintRequest $request, Complaint $complaint)
    {
        $complaint->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        if ($request->hasFile('attachment')) {
            $complaint->clearMediaCollection();
            $complaint
                ->addMediaFromRequest('attachment')
                ->toMediaCollection();
            $complaint->touch();
        }

        return back()->with('success', 'Record has been saved!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint)
    {
        $complaint->delete();

        return to_route('complaints.index')->with('success', 'Record has been deleted!');
    }
}

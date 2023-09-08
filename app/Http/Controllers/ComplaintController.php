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
    public function index(Request $r)
    {
        $complaints = Complaint::query()
            ->with('action.action_status')
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
            'created_by' => auth()->id()
        ]);

        $request->hasFile('attachment') && $complaint
            ->addMediaFromRequest('attachment')
            ->toMediaCollection();

        $complaint->actions()->create([
            'complaint_id' => $complaint->id,
            'action_status_id' => ActionStatus::PENDING,
            'description' => 'Complaint will be reviewed',
        ]);

        // User::where('email', 'user@domain.com')
        //     ->first()
        //     ->notify(new NewComplaintNotification($complaint));

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
            'updated_by' => auth()->id()
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

<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Support\Str;
use App\Models\ComplaintType;
use App\Http\Requests\StoreComplaintRequest;
use App\Http\Requests\UpdateComplaintRequest;
use App\Models\ActionStatus;
use App\Notifications\NewComplaintNotification;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $complaints = Complaint::latest()->paginate(20);

        return view('complaints.index', compact('complaints'));
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

        // \App\Models\User::where('email', 'user@domain.com')->first()->notify(new NewComplaintNotification($complaint));

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
        $action_statuses = ActionStatus::whereIn('id', [2, 3])->get();

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
        }

        return back()->with('success', 'Record has been saved!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint)
    {
        //
    }
}

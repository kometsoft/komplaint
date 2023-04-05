<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Support\Str;
use App\Models\ComplaintType;
use App\Http\Requests\StoreComplaintRequest;
use App\Http\Requests\UpdateComplaintRequest;
use App\Notifications\NewComplaintNotification;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $complaints = Complaint::paginate(20);

        return view('complaints.index', compact('complaints'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $complaint = new Complaint();
        $complaint_types = ComplaintType::all();

        return view('complaints.create', compact('complaint', 'complaint_types'));
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
            'complaint_type_id' => $request->complaint_type_id,
        ]);

        $complaint->actions()->create([
            'status' => 'Pending',
            'description' => 'Complaint will be reviewed',
            'complaint_id' => $complaint->id,
        ]);

        \App\Models\User::where('email', 'user@domain.com')->first()->notify(new NewComplaintNotification($complaint));

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
        $complaint_types = ComplaintType::all();
        $action_statuses = collect([
            (object) ['name' => 'In Progress'],
            (object) ['name' => 'Completed'],
        ]);

        return view('complaints.edit', compact('complaint', 'complaint_types', 'action_statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComplaintRequest $request, Complaint $complaint)
    {
        $complaint->update([
            'title' => $request->title,
            'body' => $request->body,
            'complaint_type_id' => $request->complaint_type_id,
        ]);

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
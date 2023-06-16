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
            ->when($r->filled('filter.title'), function ($q) use ($r) {
                $q->where('title', 'LIKE', '%' . $r->input('filter.title') . '%');
            })
            ->when($r->filled('filter.created_at'), function ($q) use ($r) {
                $date = Carbon::createFromFormat('d/m/Y', $r->input('filter.created_at'))->format('Y-m-d');
                $q->whereDate('created_at', '=', $date);
            })
            ->when($r->filled('filter.action_status_id'), function ($q) use ($r) {
                $q->whereHas('action', function ($q) use ($r) {
                    $q->where('action_status_id', $r->input('filter.action_status_id'));
                });
            })
            ->when($r->filled('filter.deleted'), function ($q) use ($r) {
                $q
                    ->when($r->input('filter.deleted') === 'with', fn ($q) => $q->withTrashed())
                    ->when($r->input('filter.deleted') === 'only', fn ($q) => $q->onlyTrashed());
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

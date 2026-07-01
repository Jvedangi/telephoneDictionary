<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $contacts = $user->contacts()
            ->with('group')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('phone_number', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('company', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('contacts._table_body', compact('contacts'))->render(),
                'pagination' => (string) $contacts->appends(request()->input())->links(),
            ]);
        }

        return view('contacts.index', compact('contacts'));
    }

    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $contactGroups = $user->contactGroups()->latest()->get();

        if ($contactGroups->isEmpty()) {
            return redirect()->route('contact-groups.create')
                ->with('warning', 'Please create at least one contact group first.');
        }

        return view('contacts.create', compact('contactGroups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|unique:contacts',
            'email' => 'nullable|email|max:255',
            'group_id' => 'required|exists:contact_groups,id',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->contacts()->create($validated);

        return redirect()->route('contacts.index')
            ->with('success', 'Contact created successfully.');
    }

    public function show(Contact $contact)
    {
        if (! Gate::allows('view', $contact)) {
            abort(403);
        }

        return view('contacts.show', compact('contact'));
    }

    public function edit(Contact $contact)
    {
        if (! Gate::allows('update', $contact)) {
            abort(403);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $contactGroups = $user->contactGroups()->latest()->get();

        return view('contacts.edit', compact('contact', 'contactGroups'));
    }

    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|unique:contacts,phone_number,' . $contact->id,
            'email' => 'nullable|email|max:255',
            'group_id' => 'required|exists:contact_groups,id',
        ]);

        $contact->update($validated);

        return redirect()->route('contacts.index')
            ->with('success', 'Contact updated successfully.');
    }

    public function destroy(Contact $contact)
    {
        if (! Gate::allows('delete', $contact)) {
            abort(403);
        }

        $contact->delete();

        return redirect()->route('contacts.index')
            ->with('success', 'Contact deleted successfully.');
    }

    public function getTestResults()
    {
        $results = DB::table('test_case_results')->get();

        return view('test_results', ['results' => $results]);
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No contacts selected.'], 400);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Ensure the user owns all the contacts being deleted
        $count = $user->contacts()->whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true, 
            'message' => "Successfully deleted {$count} contacts."
        ]);
    }
}

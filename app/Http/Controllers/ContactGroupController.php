<?php

namespace App\Http\Controllers;

use App\Models\ContactGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ContactGroupController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $contactGroups = $user->contactGroups()->latest()->paginate(10);
        return view('groups.index', compact('contactGroups'));
    }

    public function create()
    {
        return view('groups.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'group_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->contactGroups()->create($validated);

        return redirect()->route('contact-groups.index')
            ->with('success', 'Contact group created successfully.');
    }

    public function edit(ContactGroup $contactGroup)
    {
        if (! Gate::allows('update', $contactGroup)) {
            abort(403);
        }
        return view('groups.edit', compact('contactGroup'));
    }

    public function update(Request $request, ContactGroup $contactGroup)
    {
        if (! Gate::allows('update', $contactGroup)) {
            abort(403);
        }

        $validated = $request->validate([
            'group_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $contactGroup->update($validated);

        return redirect()->route('contact-groups.index')
            ->with('success', 'Contact group updated successfully.');
    }

    public function destroy(ContactGroup $contactGroup)
    {
        if (! Gate::allows('delete', $contactGroup)) {
            abort(403);
        }

        $contactGroup->delete();

        return redirect()->route('contact-groups.index')
            ->with('success', 'Contact group deleted successfully.');
    }
}

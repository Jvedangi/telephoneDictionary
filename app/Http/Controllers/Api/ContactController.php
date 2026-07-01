<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ContactController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $contacts = $user->contacts()->with('group')->latest()->get();

        return ContactResource::collection($contacts);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'group_id' => 'required|exists:contact_groups,id',
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'alternate_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'favorite' => 'nullable|boolean',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $contact = $user->contacts()->create($validated);

        return new ContactResource($contact);
    }

    public function show(Contact $contact)
    {
        if (! Gate::allows('view', $contact)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return new ContactResource($contact);
    }

    public function update(Request $request, Contact $contact)
    {
        if (! Gate::allows('update', $contact)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'group_id' => 'required|exists:contact_groups,id',
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'alternate_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'favorite' => 'nullable|boolean',
        ]);

        $contact->update($validated);

        return new ContactResource($contact);
    }

    public function destroy(Contact $contact)
    {
        if (! Gate::allows('delete', $contact)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $contact->delete();

        return response()->json(['message' => 'Contact deleted successfully']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ImportExportController extends Controller
{
    public function index()
    {
        return view('import_export');
    }

    public function export()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $contacts = $user->contacts()->with('group')->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=contacts_" . date('Y-m-d_H-i-s') . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Name', 'Phone Number', 'Alternate Number', 'Email', 'Company', 'Group', 'Address', 'Notes', 'Favorite'];

        $callback = function() use($contacts, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($contacts as $contact) {
                fputcsv($file, [
                    $contact->name,
                    $contact->phone_number,
                    $contact->alternate_number,
                    $contact->email,
                    $contact->company,
                    $contact->group->group_name,
                    $contact->address,
                    $contact->notes,
                    $contact->favorite ? 'Yes' : 'No',
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Ensure at least one group exists
        $defaultGroup = $user->contactGroups()->firstOrCreate(
            ['group_name' => 'Default'],
            ['description' => 'Automatically created for imports']
        );

        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');
        
        // Skip header
        $header = fgetcsv($handle);
        
        $count = 0;
        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < 2) continue; // Skip empty rows or rows without name/phone

            $user->contacts()->create([
                'name' => $row[0] ?? 'Unknown',
                'phone_number' => $row[1] ?? '',
                'alternate_number' => $row[2] ?? null,
                'email' => $row[3] ?? null,
                'company' => $row[4] ?? null,
                'group_id' => $defaultGroup->id, // Assign to default group
                'address' => $row[6] ?? null,
                'notes' => $row[7] ?? null,
                'favorite' => ($row[8] ?? 'No') === 'Yes' ? 1 : 0,
            ]);
            $count++;
        }
        
        fclose($handle);

        return redirect()->route('contacts.index')
            ->with('success', "Successfully imported {$count} contacts into the 'Default' group.");
    }
}

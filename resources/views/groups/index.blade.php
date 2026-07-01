<x-app-layout>
    <div class="container-fluid">
        <!-- Page Title & Add Button -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Contact Groups</h1>
            <a href="{{ route('contact-groups.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle-fill me-2"></i>
                Add Group
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-primary">All Groups</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Group Name</th>
                                <th scope="col">Description</th>
                                <th scope="col" class="text-center">Contacts</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($contactGroups as $group)
                                <tr>
                                    <td>
                                        <h6 class="mb-0 fw-bold">{{ $group->group_name }}</h6>
                                    </td>
                                    <td>{{ Str::limit($group->description, 70) ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-primary rounded-pill">{{ $group->contacts_count }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('contact-groups.edit', $group) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <form action="{{ route('contact-groups.destroy', $group) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">No groups found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-center">
                {{ $contactGroups->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

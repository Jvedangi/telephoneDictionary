<x-app-layout>
    <div class="container-fluid">
        <!-- Page Title & Add Button -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Contacts</h1>
            <a href="{{ route('contacts.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle-fill me-2"></i>
                Add Contact
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
                <div class="row g-3 align-items-center">
                    <!-- Search Form -->
                    <div class="col-md-8">
                        <form action="{{ route('contacts.index') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search by name, phone, email..." value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <!-- Group Filter -->
                    <div class="col-md-4 text-md-end">
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-funnel-fill me-2"></i> Filter by Group
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('contacts.index') }}">All Groups</a></li>
                                <!-- Group loop would go here -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Email</th>
                                <th scope="col">Group</th>
                                <th scope="col" class="text-center">Favorite</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($contacts as $contact)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://i.pravatar.cc/40?u={{ $contact->id }}" class="rounded-circle me-3" alt="Avatar" width="40" height="40">
                                            <div>
                                                <h6 class="mb-0 fw-bold">{{ $contact->name }}</h6>
                                                <small class="text-muted">{{ $contact->company ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $contact->phone_number }}</td>
                                    <td>{{ $contact->email ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $contact->group->group_name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($contact->favorite)
                                            <i class="bi bi-star-fill text-warning fs-5"></i>
                                        @else
                                            <i class="bi bi-star text-muted fs-5"></i>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('contacts.show', $contact) }}" class="btn btn-sm btn-outline-secondary me-1" title="View">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
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
                                    <td colspan="6" class="text-center py-4">No contacts found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-center">
                {{ $contacts->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="container-fluid">
        <!-- Page Title & Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Contact Profile</h1>
            <div>
                <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-primary me-2">
                    <i class="bi bi-pencil-square me-2"></i>Edit Contact
                </a>
                <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash-fill me-2"></i>Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="row">
            <!-- Left Column: Profile Picture and Basic Info -->
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4 text-center">
                    <div class="card-body">
                        <img src="https://i.pravatar.cc/150?u={{ $contact->id }}" class="rounded-circle mb-3" alt="Avatar" width="120" height="120">
                        <h4 class="card-title fw-bold">{{ $contact->name }}</h4>
                        <p class="text-muted">{{ $contact->company ?? 'No company information' }}</p>
                        @if($contact->favorite)
                            <span class="badge bg-warning text-dark"><i class="bi bi-star-fill me-1"></i> Favorite</span>
                        @endif
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 fw-bold text-primary">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <a href="tel:{{ $contact->phone_number }}" class="btn btn-success w-100 mb-2">
                            <i class="bi bi-telephone-fill me-2"></i> Call Now
                        </a>
                        <a href="mailto:{{ $contact->email }}" class="btn btn-info w-100 text-white">
                            <i class="bi bi-envelope-fill me-2"></i> Send Email
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column: Detailed Information -->
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 fw-bold text-primary">Contact Information</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="fw-bold">Phone Number:</span>
                                <span>{{ $contact->phone_number }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="fw-bold">Alternate Number:</span>
                                <span>{{ $contact->alternate_number ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="fw-bold">Email Address:</span>
                                <span>{{ $contact->email ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="fw-bold">Contact Group:</span>
                                <span class="badge bg-primary">{{ $contact->group->group_name ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item d-flex flex-column align-items-start px-0">
                                <span class="fw-bold mb-2">Address:</span>
                                <p class="text-muted mb-0">{{ $contact->address ?? 'No address provided.' }}</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 fw-bold text-primary">Notes</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-0">{{ $contact->notes ?? 'No notes for this contact.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

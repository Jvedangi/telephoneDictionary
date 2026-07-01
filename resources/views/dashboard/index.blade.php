<x-app-layout>
    <div class="container-fluid">
        <!-- Page Title -->
        <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

        <!-- Statistics Cards -->
        <div class="row">
            <!-- Total Contacts -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Contacts</div>
                                <div class="h5 mb-0 fw-bold text-gray-800">{{ $totalContacts ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-people-fill fs-2 text-primary opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Groups -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs fw-bold text-success text-uppercase mb-1">Total Groups</div>
                                <div class="h5 mb-0 fw-bold text-gray-800">{{ $totalGroups ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-collection-fill fs-2 text-success opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Favorite Contacts -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs fw-bold text-warning text-uppercase mb-1">Favorite Contacts</div>
                                <div class="h5 mb-0 fw-bold text-gray-800">{{ $favoriteContacts ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-star-fill fs-2 text-warning opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recently Added -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs fw-bold text-info text-uppercase mb-1">Recently Added</div>
                                <div class="h5 mb-0 fw-bold text-gray-800">{{ $recentlyAdded ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-clock-history fs-2 text-info opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Contacts Table -->
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-primary">Recently Added Contacts</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Group</th>
                                <th>Added On</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentContacts as $contact)
                                <tr>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->phone_number }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td><span class="badge bg-secondary">{{ $contact->group->group_name ?? 'N/A' }}</span></td>
                                    <td>{{ $contact->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No recent contacts found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-admin-layout>
    <div class="space-y-8">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Shipments</h1>
                <p class="text-slate-500 font-medium">Monitor and manage all logistics activity in real-time.</p>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="flex flex-col lg:flex-row gap-6 items-center justify-between">
            <div class="flex gap-3 w-full lg:w-auto">
                <div class="relative flex-grow lg:flex-initial">
                    <select id="statusFilter" class="w-full appearance-none rounded-xl border-slate-200 text-sm font-bold text-slate-600 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 bg-white pl-6 pr-12 py-3 shadow-sm transition-all cursor-pointer">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="ready_to_ship" {{ request('status') === 'ready_to_ship' ? 'selected' : '' }}>Ready to Ship</option>
                        <option value="picked_up" {{ request('status') === 'picked_up' ? 'selected' : '' }}>Picked Up</option>
                        <option value="in_transit" {{ request('status') === 'in_transit' ? 'selected' : '' }}>In Transit</option>
                        <option value="arrived_at_branch" {{ request('status') === 'arrived_at_branch' ? 'selected' : '' }}>Arrived At Branch</option>
                        <option value="out_for_delivery" {{ request('status') === 'out_for_delivery' ? 'selected' : '' }}>Out For Delivery</option>
                        <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>
            </div>
            
            <div class="relative w-full lg:w-[450px]">
                <div class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input type="text" id="searchInput" placeholder="Search tracking number, sender, receiver..." 
                       class="w-full pl-14 pr-6 py-3.5 rounded-xl border-slate-100 bg-white text-sm font-medium text-slate-700 placeholder:text-slate-400 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 shadow-sm transition-all">
                
                <!-- Loading Spinner -->
                <div id="searchLoader" class="absolute right-5 top-1/2 -translate-y-1/2 hidden">
                    <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Table Container -->
        <div id="shipmentsTable" class="transition-all duration-300">
            @include('shipments.partials.table')
        </div>
    </div>


    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let searchTimer;
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const searchLoader = document.getElementById('searchLoader');
            const shipmentsTable = document.getElementById('shipmentsTable');
            
            function performSearch() {
                const search = searchInput.value;
                const status = statusFilter.value;
                
                // Update URL without reloading
                const url = new URL(window.location);
                if (search) url.searchParams.set('search', search); else url.searchParams.delete('search');
                if (status) url.searchParams.set('status', status); else url.searchParams.delete('status');
                url.searchParams.delete('page'); // Reset to page 1 on new filter
                window.history.pushState({}, '', url);

                searchLoader.classList.remove('hidden');
                shipmentsTable.style.opacity = '0.5';

                fetch(url.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    shipmentsTable.innerHTML = html;
                    shipmentsTable.style.opacity = '1';
                    searchLoader.classList.add('hidden');
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    shipmentsTable.style.opacity = '1';
                    searchLoader.classList.add('hidden');
                });
            }

            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    clearTimeout(searchTimer);
                    searchTimer = setTimeout(performSearch, 500);
                });
            }

            if (statusFilter) {
                statusFilter.addEventListener('change', performSearch);
            }
            
            // Handle pagination clicks within the table via AJAX
            document.addEventListener('click', function(e) {
                const link = e.target.closest('#shipmentsTable .pagination a');
                if (link) {
                    e.preventDefault();
                    searchLoader.classList.remove('hidden');
                    shipmentsTable.style.opacity = '0.5';
                    
                    window.history.pushState({}, '', link.href);

                    fetch(link.href, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        shipmentsTable.innerHTML = html;
                        shipmentsTable.style.opacity = '1';
                        searchLoader.classList.add('hidden');
                    });
                }
            });
            
            // Delete Confirmation
            document.addEventListener('submit', function(e) {
                if (e.target && e.target.classList.contains('delete-form')) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Delete shipment?',
                        text: "This action cannot be undone.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#4f46e5',
                        cancelButtonColor: '#f43f5e',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            e.target.submit();
                        }
                    });
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>

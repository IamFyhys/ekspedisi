<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Shipment - Expedition Online</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">
    <nav class="bg-white shadow-sm border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">E</div>
                <span class="text-xl font-bold text-slate-900 tracking-tight">Expedition <span class="text-indigo-600">Online</span></span>
            </div>
            <a href="/login" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition">Staff Login</a>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 py-12">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-slate-900 mb-4">Track Your Shipment</h1>
            <p class="text-slate-600 text-lg">Enter your tracking number below to see the current status of your package.</p>
        </div>

        <div class="glass rounded-3xl p-8 shadow-xl mb-12">
            <form action="{{ route('tracking.search') }}" method="POST" class="flex flex-col sm:flex-row gap-4">
                @csrf
                <div class="flex-grow relative">
                    <input type="text" name="tracking_number" placeholder="Enter Tracking Number (e.g. EXP-12345)" 
                        value="{{ ($shipment ?? null)?->tracking_number }}"
                        class="w-full px-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition text-lg font-medium text-slate-700">
                </div>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-8 rounded-2xl shadow-lg shadow-indigo-200 transition transform hover:-translate-y-0.5 active:translate-y-0">
                    Track Now
                </button>
            </form>
            @if(session('error'))
                <p class="mt-4 text-red-500 text-sm font-medium">{{ session('error') }}</p>
            @endif
        </div>

        @if(isset($shipment))
            <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
                <!-- Status Card -->
                <div class="bg-white rounded-3xl p-8 shadow-md border border-slate-100">
                    <div class="flex flex-wrap justify-between items-start gap-4 mb-8">
                        <div>
                            <span class="text-xs font-bold text-indigo-500 uppercase tracking-widest mb-1 block">Current Status</span>
                            <h2 class="text-3xl font-bold text-slate-900">{{ ucfirst(str_replace('_', ' ', $shipment->status)) }}</h2>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1 block">Tracking Number</span>
                            <span class="text-lg font-mono font-bold text-slate-700">{{ $shipment->tracking_number }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 py-8 border-y border-slate-50">
                        <div>
                            <p class="text-sm font-medium text-slate-400 mb-1">Origin</p>
                            <p class="text-lg font-bold text-slate-800">{{ $shipment->originLocation->name ?? $shipment->originBranch->name ?? '-' }}</p>
                            <p class="text-sm text-slate-500">{{ $shipment->originLocation->province ?? $shipment->originBranch->city ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-400 mb-1">Destination</p>
                            <p class="text-lg font-bold text-slate-800">{{ $shipment->destinationLocation->name ?? $shipment->destinationBranch->name ?? '-' }}</p>
                            <p class="text-sm text-slate-500">{{ $shipment->destinationLocation->province ?? $shipment->destinationBranch->city ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="bg-white rounded-3xl p-8 shadow-md border border-slate-100">
                    <h3 class="text-xl font-bold text-slate-900 mb-8">Shipment History</h3>
                    <div class="relative space-y-8 before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">
                        
                        @foreach($shipment->trackings()->orderBy('tracked_at', 'desc')->get() as $tracking)
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-100 group-hover:bg-indigo-500 group-hover:text-white transition-all duration-300 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            </div>
                            <div class="w-[calc(100%-4rem)] md:w-[45%] p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:border-indigo-200 transition-colors">
                                <div class="flex items-center justify-between space-x-2 mb-1">
                                    <div class="font-bold text-slate-800">{{ $tracking->location }}</div>
                                    <time class="text-xs font-medium text-indigo-500 uppercase">{{ $tracking->tracked_at->format('M d, H:i') }}</time>
                                </div>
                                <div class="text-slate-600 text-sm">{{ $tracking->description }}</div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        @endif
    </main>

    <footer class="mt-24 py-12 bg-white border-t border-slate-100 text-center">
        <p class="text-slate-400 text-sm">© 2026 Expedition Online. All rights reserved.</p>
    </footer>
</body>
</html>

<x-admin-layout>
    @section('title_breadcrumb', 'Performa Saya')

    <div class="space-y-6 animate-reveal">
        {{-- Filter --}}
        <div style="display:flex;gap:8px;margin-bottom:20px;">
            @foreach(['today'=>'Hari Ini','week'=>'Minggu Ini','month'=>'Bulan Ini'] as $key=>$label)
            <a href="?filter={{ $key }}" style="
                padding: 8px 18px;
                border-radius: 10px;
                font-size: 13px;
                font-weight: 600;
                text-decoration: none;
                background: {{ $filter === $key ? '#185FA5' : '#fff' }};
                color: {{ $filter === $key ? '#fff' : '#64748b' }};
                border: 1.5px solid {{ $filter === $key ? '#185FA5' : '#e5e7eb' }};
            ">{{ $label }}</a>
            @endforeach
        </div>

        {{-- Alert selisih paket --}}
        @if($tripsSelisih > 0)
        <div style="
            background: #fee2e2;
            border: 1px solid #fca5a5;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: #dc2626;
            font-weight: 600;
        ">
            <svg width="18" height="18" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2">
                <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94
                        a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/>
                <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
            Ada {{ $tripsSelisih }} trip dengan selisih paket —
            segera laporkan ke Manager!
        </div>
        @endif

        {{-- Stat Cards --}}
        <div style="
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        ">
            @foreach([
                ['label'=>'Trip Selesai','value'=>$totalTrips,'color'=>'#185FA5','icon'=>'🚛'],
                ['label'=>'Paket Dibawa','value'=>$totalDibawa,'color'=>'#374151','icon'=>'📦'],
                ['label'=>'Paket Sampai','value'=>$totalSampai,'color'=>'#16a34a','icon'=>'✓'],
                ['label'=>'Accuracy','value'=>$accuracy.'%','color'=>$accuracy>=95?'#16a34a':($accuracy>=85?'#d97706':'#dc2626'),'icon'=>'📊'],
            ] as $card)
            <div style="
                background: #fff;
                border-radius: 14px;
                padding: 18px;
                border: 1px solid #e8edf2;
            ">
                <div style="font-size:20px;margin-bottom:8px;">
                    {{ $card['icon'] }}
                </div>
                <div style="font-size:11px;font-weight:700;
                            color:#94a3b8;margin-bottom:6px;">
                    {{ strtoupper($card['label']) }}
                </div>
                <div style="font-size:26px;font-weight:800;
                            color:{{ $card['color'] }};">
                    {{ $card['value'] }}
                </div>
            </div>
            @endforeach
        </div>

        {{-- Progress Bars --}}
        <div style="
            background: #fff;
            border-radius: 16px;
            padding: 22px 24px;
            border: 1px solid #e8edf2;
            margin-bottom: 20px;
        ">
            <div style="font-size:11px;font-weight:700;
                        color:#94a3b8;margin-bottom:18px;">
                RINGKASAN PERFORMA TRANSIT
            </div>

            {{-- Manifest Accuracy --}}
            <div style="margin-bottom:18px;">
                <div style="display:flex;justify-content:space-between;
                            margin-bottom:6px;">
                    <span style="font-size:13px;font-weight:600;color:#374151;">
                        Manifest Accuracy
                    </span>
                    <span style="font-size:13px;font-weight:700;
                                color:{{ $accuracy>=95?'#16a34a':($accuracy>=85?'#d97706':'#dc2626') }};">
                        {{ $accuracy }}%
                        {{ $accuracy >= 95 ? '✓ Baik' : '⚠️ Perlu Perhatian' }}
                    </span>
                </div>
                <div style="height:10px;background:#f1f5f9;border-radius:99px;overflow:hidden;">
                    <div style="
                        height:100%;width:{{ $accuracy }}%;
                        background:{{ $accuracy>=95?'#16a34a':($accuracy>=85?'#d97706':'#dc2626') }};
                        border-radius:99px;transition:width 1s ease;
                    "></div>
                </div>
                <div style="font-size:11px;color:#94a3b8;margin-top:4px;">
                    {{ $totalSampai }} dari {{ $totalDibawa }} paket sampai dengan selamat
                    | Target: minimal 95%
                </div>
            </div>

            {{-- Rata-rata Durasi --}}
            <div>
                <div style="display:flex;justify-content:space-between;
                            margin-bottom:6px;">
                    <span style="font-size:13px;font-weight:600;color:#374151;">
                        Rata-rata Durasi Trip
                    </span>
                    <span style="font-size:13px;font-weight:700;color:#185FA5;">
                        {{ $avgJam }} jam {{ $avgMenit }} menit
                    </span>
                </div>
                <div style="height:10px;background:#f1f5f9;border-radius:99px;overflow:hidden;">
                    <div style="
                        height:100%;
                        width:{{ min(($avgJam/12)*100, 100) }}%;
                        background:#185FA5;border-radius:99px;
                    "></div>
                </div>
                <div style="font-size:11px;color:#94a3b8;margin-top:4px;">
                    Berdasarkan {{ $totalTrips }} trip yang sudah diselesaikan
                </div>
            </div>
        </div>

        {{-- Tabel Trip --}}
        <div style="
            background: #fff;
            border-radius: 16px;
            padding: 22px 24px;
            border: 1px solid #e8edf2;
        ">
            <div style="font-size:11px;font-weight:700;
                        color:#94a3b8;margin-bottom:16px;">
                RIWAYAT TRIP
            </div>

            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="border-bottom:1px solid #f1f5f9;">
                        @foreach(['Rute','Berangkat','Tiba','Durasi','Paket','Status'] as $h)
                        <th style="
                            font-size:11px;font-weight:700;color:#94a3b8;
                            padding:0 12px 12px 0;text-align:left;
                            white-space:nowrap;
                        ">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($trips as $trip)
                    @php
                        $selisih  = $trip->total_packages - ($trip->total_received ?? 0);
                        $durMenit = $trip->arrived_at
                            ? \Carbon\Carbon::parse($trip->departed_at)
                                ->diffInMinutes($trip->arrived_at)
                            : 0;
                        $durJam   = floor($durMenit / 60);
                        $durSisa  = $durMenit % 60;
                    @endphp
                    <tr style="border-bottom:1px solid #f8fafc;">
                        <td style="padding:12px 12px 12px 0;font-size:13px;font-weight:600;color:#1e2d4a;">
                            {{ $trip->originBranch->city ?? '?' }}
                            →
                            {{ $trip->destinationBranch->city ?? '?' }}
                        </td>
                        <td style="padding:12px 12px 12px 0;font-size:12px;color:#64748b;white-space:nowrap;">
                            {{ \Carbon\Carbon::parse($trip->departed_at)->format('d M, H.i') }}
                        </td>
                        <td style="padding:12px 12px 12px 0;font-size:12px;color:#64748b;white-space:nowrap;">
                            {{ $trip->arrived_at
                                ? \Carbon\Carbon::parse($trip->arrived_at)->format('d M, H.i')
                                : '-' }}
                        </td>
                        <td style="padding:12px 12px 12px 0;font-size:12px;color:#64748b;white-space:nowrap;">
                            {{ $durJam }}j {{ $durSisa }}m
                        </td>
                        <td style="padding:12px 12px 12px 0;">
                            <span style="
                                font-size:13px;font-weight:700;
                                color:{{ $selisih > 0 ? '#dc2626' : '#16a34a' }};
                            ">
                                {{ $trip->total_received ?? 0 }}/{{ $trip->total_packages }}
                                @if($selisih > 0)
                                <span style="font-size:11px;">(-{{ $selisih }})</span>
                                @endif
                            </span>
                        </td>
                        <td style="padding:12px 0;">
                            @if($selisih > 0)
                            <span style="
                                background:#fee2e2;color:#dc2626;
                                padding:4px 10px;border-radius:6px;
                                font-size:11px;font-weight:700;
                            ">⚠️ Selisih</span>
                            @else
                            <span style="
                                background:#dcfce7;color:#16a34a;
                                padding:4px 10px;border-radius:6px;
                                font-size:11px;font-weight:700;
                            ">✓ Sesuai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;
                                            padding:32px;color:#94a3b8;
                                            font-size:13px;">
                            Belum ada trip yang selesai
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>

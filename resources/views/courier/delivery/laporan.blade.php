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

        {{-- Stat Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 mb-5">

            @foreach([
                ['label'=>'Berhasil','value'=>$delivered,'color'=>'#16a34a','bg'=>'#dcfce7'],
                ['label'=>'Jemput','value'=>$pickupCount,'color'=>'#8b5cf6','bg'=>'#f5f3ff'],
                ['label'=>'Gagal','value'=>$failed,'color'=>'#dc2626','bg'=>'#fee2e2'],
                ['label'=>'Total','value'=>$total,'color'=>'#185FA5','bg'=>'#dbeafe'],
            ] as $card)
            <div style="
                background: #fff;
                border-radius: 14px;
                padding: 18px;
                border: 1px solid #e8edf2;
            ">
                <div style="font-size:11px;font-weight:700;
                            color:#94a3b8;margin-bottom:8px;">
                    {{ strtoupper($card['label']) }}
                </div>
                <div style="
                    font-size: 28px;
                    font-weight: 800;
                    color: {{ $card['color'] }};
                ">{{ $card['value'] }}</div>
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
                RINGKASAN PERFORMA
            </div>

            {{-- Success Rate --}}
            <div style="margin-bottom:18px;">
                <div style="display:flex;justify-content:space-between;
                            margin-bottom:6px;">
                    <span style="font-size:13px;font-weight:600;color:#374151;">
                        Success Rate
                    </span>
                    <span style="font-size:13px;font-weight:700;
                                color:{{ $successRate >= 80 ? '#16a34a' : ($successRate >= 60 ? '#d97706' : '#dc2626') }};">
                        {{ $successRate }}%
                    </span>
                </div>
                <div style="height:10px;background:#f1f5f9;border-radius:99px;overflow:hidden;">
                    <div style="
                        height: 100%;
                        width: {{ $successRate }}%;
                        background: {{ $successRate >= 80 ? '#16a34a' : ($successRate >= 60 ? '#d97706' : '#dc2626') }};
                        border-radius: 99px;
                        transition: width 1s ease;
                    "></div>
                </div>
                <div style="font-size:11px;color:#94a3b8;margin-top:4px;">
                    {{ $delivered }} berhasil dari {{ $total }} total pengiriman
                </div>
            </div>

            {{-- Retur Rate --}}
            <div style="margin-bottom:18px;">
                <div style="display:flex;justify-content:space-between;
                            margin-bottom:6px;">
                    <span style="font-size:13px;font-weight:600;color:#374151;">
                        Retur Rate
                        @if($returRate > 10)
                        <span style="color:#dc2626;">⚠️</span>
                        @endif
                    </span>
                    <span style="font-size:13px;font-weight:700;
                                color:{{ $returRate <= 5 ? '#16a34a' : ($returRate <= 10 ? '#d97706' : '#dc2626') }};">
                        {{ $returRate }}%
                    </span>
                </div>
                <div style="height:10px;background:#f1f5f9;border-radius:99px;overflow:hidden;">
                    <div style="
                        height: 100%;
                        width: {{ $returRate }}%;
                        background: {{ $returRate <= 5 ? '#16a34a' : ($returRate <= 10 ? '#d97706' : '#dc2626') }};
                        border-radius: 99px;
                    "></div>
                </div>
                <div style="font-size:11px;color:#94a3b8;margin-top:4px;">
                    Target: di bawah 5% | Sekarang: {{ $returRate }}%
                </div>
            </div>

            {{-- Rata-rata waktu --}}
            <div>
                <div style="display:flex;justify-content:space-between;
                            margin-bottom:6px;">
                    <span style="font-size:13px;font-weight:600;color:#374151;">
                        Rata-rata Waktu Antar
                    </span>
                    <span style="font-size:13px;font-weight:700;color:#185FA5;">
                        {{ $avgTime }} menit/paket
                    </span>
                </div>
                <div style="height:10px;background:#f1f5f9;border-radius:99px;overflow:hidden;">
                    <div style="
                        height: 100%;
                        width: {{ min(($avgTime / 60) * 100, 100) }}%;
                        background: #185FA5;
                        border-radius: 99px;
                    "></div>
                </div>
                <div style="font-size:11px;color:#94a3b8;margin-top:4px;">
                    Target: di bawah 30 menit per paket
                </div>
            </div>
        </div>

        {{-- Tabel Riwayat --}}
        <div class="bg-white rounded-2xl p-4 md:p-6 border border-slate-100">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
                <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    RIWAYAT PENGIRIMAN
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach(['all'=>'Semua','delivered'=>'Berhasil','failed_delivery'=>'Gagal'] as $key=>$label)
                    <a href="?filter={{ $filter }}&status={{ $key }}" 
                       class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ (request('status','all') === $key) ? 'bg-primary text-white shadow-md' : 'bg-slate-50 text-slate-500 hover:bg-slate-100' }}">
                        {{ $label }}
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                <thead>
                    <tr style="border-bottom:1px solid #f1f5f9;">
                        @foreach(['No Resi','Penerima','Alamat','Waktu','Status'] as $h)
                        <th style="
                            font-size:11px;font-weight:700;
                            color:#94a3b8;padding:0 12px 12px 0;
                            text-align:left;white-space:nowrap;
                        ">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    {{-- 1. Delivery Rows --}}
                    @foreach($shipments->when(request('status') && request('status') !== 'all',
                        fn($c) => $c->whereIn('status', request('status') === 'failed_delivery' ? ['failed_delivery', 'returned_to_warehouse'] : [request('status')])
                    ) as $s)
                    <tr style="border-bottom:1px solid #f8fafc;">
                        <td style="padding:12px 12px 12px 0;font-size:13px;
                                font-weight:600;color:#185FA5;">
                            {{ $s->tracking_number }}
                        </td>
                        <td style="padding:12px 12px 12px 0;font-size:13px;color:#374151;">
                            {{ $s->receiver_name }}
                        </td>
                        <td style="padding:12px 12px 12px 0;font-size:12px;
                                color:#64748b;max-width:160px;">
                            {{ Str::limit($s->receiver_address, 30) }}
                        </td>
                        <td style="padding:12px 12px 12px 0;font-size:12px;
                                color:#64748b;white-space:nowrap;">
                            {{ \Carbon\Carbon::parse($s->updated_at)->format('H.i') }} WIB
                        </td>
                        <td style="padding:12px 0;">
                            @if($s->status === 'delivered')
                            <span style="
                                background:#dcfce7;color:#16a34a;
                                padding:4px 10px;border-radius:6px;
                                font-size:11px;font-weight:700;
                            ">✓ Berhasil</span>
                            @else
                            <span style="
                                background:#fee2e2;color:#dc2626;
                                padding:4px 10px;border-radius:6px;
                                font-size:11px;font-weight:700;
                            ">✗ Gagal</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach

                    {{-- 2. Pickup Rows --}}
                    @foreach($pickups as $p)
                    <tr style="border-bottom:1px solid #f8fafc;">
                        <td style="padding:12px 12px 12px 0;font-size:13px;
                                font-weight:600;color:#8b5cf6;">
                            #{{ $p->pickup_code }}
                        </td>
                        <td style="padding:12px 12px 12px 0;font-size:13px;color:#374151;">
                            {{ $p->sender_name }}
                        </td>
                        <td style="padding:12px 12px 12px 0;font-size:12px;
                                color:#64748b;max-width:160px;">
                            {{ Str::limit($p->sender_address, 30) }}
                        </td>
                        <td style="padding:12px 12px 12px 0;font-size:12px;
                                color:#64748b;white-space:nowrap;">
                            {{ \Carbon\Carbon::parse($p->updated_at)->format('H.i') }} WIB
                        </td>
                        <td style="padding:12px 0;">
                            <span style="
                                background:#f5f3ff;color:#8b5cf6;
                                padding:4px 10px;border-radius:6px;
                                font-size:11px;font-weight:700;
                            ">✓ Jemput</span>
                        </td>
                    </tr>
                    @endforeach

                    @if($shipments->isEmpty() && $pickups->isEmpty())
                    <tr>
                        <td colspan="5" style="text-align:center;
                                            padding:32px;color:#94a3b8;
                                            font-size:13px;">
                            Belum ada data pengiriman/penjemputan
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>

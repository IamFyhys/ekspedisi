@extends('layouts.premium')

@section('title', 'Lacak Kiriman — Expedition')

@section('styles')
<style>
    .tracking-page { padding-top: 140px; padding-bottom: 80px; }
    
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(16px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Scroll ke posisi terakhir otomatis */
    .timeline-latest {
        scroll-margin-top: 20px;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-10px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>
@endsection

@section('content')
<div class="tracking-page">
    <div class="container" style="max-width: 680px; margin: 0 auto;">
        
        <!-- Bagian 1 — Search Bar -->
        <div style="
            background: linear-gradient(135deg, #1e2d4a, #185FA5);
            border-radius: 20px;
            padding: 32px 28px;
            margin-bottom: 24px;
        ">
            <div style="
                font-size: 22px;
                font-weight: 800;
                color: #fff;
                margin-bottom: 4px;
            ">Lacak Paket Kamu</div>
            <div style="
                font-size: 13px;
                color: rgba(255,255,255,0.6);
                margin-bottom: 20px;
            ">Masukkan nomor resi untuk melacak status pengiriman</div>

            <form method="GET" action="{{ route('tracking') }}"
                  style="display:flex;gap:10px;">
                <div style="
                    flex: 1;
                    display: flex;
                    align-items: center;
                    background: #fff;
                    border-radius: 12px;
                    padding: 0 16px;
                    gap: 10px;
                ">
                    <!-- Icon search SVG -->
                    <svg width="18" height="18" viewBox="0 0 24 24"
                         fill="none" stroke="#94a3b8" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.35-4.35"/>
                    </svg>
                    <input type="text" name="resi"
                        value="{{ request('resi') }}"
                        placeholder="Contoh: EXP-2026-ARRIV01"
                        style="
                            flex: 1;
                            height: 48px;
                            border: none;
                            outline: none;
                            font-size: 14px;
                            font-family: inherit;
                            background: transparent;
                        ">
                </div>
                <button type="submit" style="
                    height: 48px;
                    padding: 0 28px;
                    background: #fff;
                    color: #185FA5;
                    border: none;
                    border-radius: 12px;
                    font-size: 14px;
                    font-weight: 700;
                    cursor: pointer;
                    font-family: inherit;
                    white-space: nowrap;
                ">Lacak</button>
            </form>
        </div>

        @if(isset($notFound) && $notFound)
        <!-- Tampilan Jika Resi Tidak Ditemukan -->
        <div style="
            background: #fff;
            border-radius: 16px;
            border: 1px solid #fee2e2;
            padding: 40px 24px;
            text-align: center;
        ">
            <div style="font-size:48px;margin-bottom:16px;">📦</div>
            <div style="font-size:16px;font-weight:700;
                        color:#1e2d4a;margin-bottom:8px;">
                Nomor Resi Tidak Ditemukan
            </div>
            <div style="font-size:13px;color:#94a3b8;margin-bottom:4px;">
                Resi <strong>{{ $searchedResi }}</strong>
                tidak ada di sistem kami.
            </div>
            <div style="font-size:13px;color:#94a3b8;">
                Pastikan nomor resi sudah benar dan coba lagi.
            </div>
        </div>
        @endif

        @if(isset($shipment) && $shipment)
            <!-- Bagian 2 — Info Resi & Status -->
            <div style="
                background: #fff;
                border-radius: 16px;
                overflow: hidden;
                border: 1px solid #e8edf2;
                margin-bottom: 14px;
                animation: fadeUp 0.4s ease forwards;
            ">
                <!-- Header resi -->
                <div style="padding: 20px 24px 16px;">
                    <div style="
                        display: flex;
                        justify-content: space-between;
                        align-items: flex-start;
                        margin-bottom: 8px;
                    ">
                        <div style="
                            font-size: 22px;
                            font-weight: 800;
                            color: #1e2d4a;
                            letter-spacing: .5px;
                        ">{{ $shipment->tracking_number }}</div>

                        <!-- Badge status -->
                        @php
                        $badge = match($shipment->status) {
                            'pending'        => ['Diterima','#f1f5f9','#64748b'],
                            'ready_to_ship'  => ['Siap Dikirim','#fff7ed','#ea580c'],
                            'in_transit'     => ['Transit','#dbeafe','#1d4ed8'],
                            'arrived_at_hub' => ['Di Hub','#ede9fe','#7c3aed'],
                            'arrived_at_branch' => ['Di Cabang','#ede9fe','#7c3aed'],
                            'assigned'       => ['Siap Diantar','#dbeafe','#1d4ed8'],
                            'out_for_delivery'=> ['Kurir Jalan','#dbeafe','#1d4ed8'],
                            'delivered'      => ['Terkirim','#dcfce7','#16a34a'],
                            'failed_delivery'=> ['Gagal','#fee2e2','#dc2626'],
                            'returned_to_warehouse' => ['Retur','#fef2f2','#991b1b'],
                            default          => ['Diproses','#f1f5f9','#64748b'],
                        };
                        @endphp
                        <span style="
                            background: {{ $badge[1] }};
                            color: {{ $badge[2] }};
                            padding: 6px 14px;
                            border-radius: 8px;
                            font-size: 12px;
                            font-weight: 700;
                            display: flex;
                            align-items: center;
                            gap: 6px;
                        ">
                            <span style="
                                width: 7px; height: 7px;
                                background: {{ $badge[2] }};
                                border-radius: 50%;
                                display: inline-block;
                            "></span>
                            {{ $badge[0] }}
                        </span>
                    </div>

                    <div style="font-size:13px;color:#94a3b8;">
                        {{ \Carbon\Carbon::parse($shipment->created_at)
                           ->translatedFormat('d F Y, H.i') }} WIB
                        &nbsp;•&nbsp; Layanan Regular
                    </div>
                </div>

                <!-- Divider -->
                <div style="height:1px;background:#f1f5f9;"></div>

                <!-- Info grid -->
                <div style="
                    display: grid;
                    grid-template-columns: 1fr 1fr 1fr;
                    padding: 16px 24px;
                    gap: 16px;
                ">
                    <div>
                        <div style="font-size:11px;color:#94a3b8;
                                    font-weight:600;margin-bottom:4px;">
                            ONGKIR
                        </div>
                        <div style="font-size:15px;font-weight:700;
                                    color:#1e2d4a;">
                            Rp {{ number_format($shipment->total_price ?? 0,0,',','.') }}
                        </div>
                    </div>
                    <div>
                        <div style="font-size:11px;color:#94a3b8;
                                    font-weight:600;margin-bottom:4px;">
                            BERAT
                        </div>
                        <div style="font-size:15px;font-weight:700;
                                    color:#1e2d4a;">
                            {{ $shipment->weight }} kg
                        </div>
                    </div>
                    <div>
                        <div style="font-size:11px;color:#94a3b8;
                                    font-weight:600;margin-bottom:4px;">
                            PEMBAYARAN
                        </div>
                        <div style="font-size:15px;font-weight:700;
                                    color:#1e2d4a;">
                            {{ strtoupper($shipment->payment_method) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian 3 — Pengirim & Penerima -->
            <div style="
                background: #fff;
                border-radius: 16px;
                border: 1px solid #e8edf2;
                overflow: hidden;
                margin-bottom: 14px;
                animation: fadeUp 0.4s 0.1s ease forwards;
                opacity: 0;
            ">
                <div style="
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                ">
                    <!-- Pengirim -->
                    <div style="padding: 20px 24px;">
                        <div style="
                            font-size: 11px;
                            font-weight: 700;
                            color: #94a3b8;
                            letter-spacing: .08em;
                            margin-bottom: 12px;
                            display: flex;
                            align-items: center;
                            gap: 6px;
                        ">
                            <svg width="14" height="14" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 2 11 13M22 2 15 22 11 13 2 9l20-7z"/>
                            </svg>
                            PENGIRIM
                        </div>
                        <div style="font-size:15px;font-weight:700;
                                    color:#1e2d4a;margin-bottom:4px;">
                            {{ $shipment->sender_name }}
                        </div>
                        <div style="font-size:13px;color:#64748b;
                                    line-height:1.6;margin-bottom:8px;">
                            {{ $shipment->originLocation->name ?? $shipment->sender_address ?? '-' }}
                        </div>
                        <div style="
                            font-size:13px;color:#185FA5;
                            font-weight:500;display:flex;
                            align-items:center;gap:6px;
                        ">
                            <svg width="13" height="13" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 01-2.18 2
                                         19.79-19.79 0 01-8.63-3.07
                                         19.5 19.5 0 01-6-6
                                         19.79 19.79 0 01-3.07-8.67
                                         A2 2 0 014.11 2h3a2 2 0 012 1.72
                                         12.84 12.84 0 00.7 2.81
                                         2 2 0 01-.45 2.11L8.09 9.91
                                         a16 16 0 006 6l1.27-1.27
                                         a2 2 0 012.11-.45
                                         12.84 12.84 0 002.81.7
                                         A2 2 0 0122 16.92z"/>
                            </svg>
                            {{ $shipment->sender_phone }}
                        </div>
                    </div>

                    <!-- Divider vertikal -->
                    <div style="
                        border-left: 1px solid #f1f5f9;
                        padding: 20px 24px;
                    ">
                        <div style="
                            font-size: 11px;
                            font-weight: 700;
                            color: #94a3b8;
                            letter-spacing: .08em;
                            margin-bottom: 12px;
                            display: flex;
                            align-items: center;
                            gap: 6px;
                        ">
                            <svg width="14" height="14" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13
                                         a9 9 0 0118 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            PENERIMA
                        </div>
                        <div style="font-size:15px;font-weight:700;
                                    color:#1e2d4a;margin-bottom:4px;">
                            {{ $shipment->receiver_name }}
                        </div>
                        <div style="font-size:13px;color:#64748b;
                                    line-height:1.6;margin-bottom:8px;">
                            {{ $shipment->receiver_address }}, {{ $shipment->destinationLocation->name ?? '-' }}
                        </div>
                        <div style="
                            font-size:13px;color:#185FA5;
                            font-weight:500;display:flex;
                            align-items:center;gap:6px;
                        ">
                            <svg width="13" height="13" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 01-2.18 2
                                         19.79-19.79 0 01-8.63-3.07
                                         19.5 19.5 0 01-6-6
                                         19.79 19.79 0 01-3.07-8.67
                                         A2 2 0 014.11 2h3a2 2 0 012 1.72
                                         12.84 12.84 0 00.7 2.81
                                         2 2 0 01-.45 2.11L8.09 9.91
                                         a16 16 0 006 6l1.27-1.27
                                         a2 2 0 012.11-.45
                                         12.84 12.84 0 002.81.7
                                         A2 2 0 0122 16.92z"/>
                            </svg>
                            {{ $shipment->receiver_phone }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian 4 — Timeline Histori -->
            <div class="timeline-latest" style="
                background: #fff;
                border-radius: 16px;
                border: 1px solid #e8edf2;
                padding: 24px;
                margin-bottom: 14px;
                animation: fadeUp 0.4s 0.2s ease forwards;
                opacity: 0;
            ">
                <div style="
                    font-size: 11px;
                    font-weight: 700;
                    color: #94a3b8;
                    letter-spacing: .08em;
                    margin-bottom: 24px;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                ">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v10l4 2"/><circle cx="12" cy="12" r="10"/></svg>
                    HISTORI PENGIRIMAN
                </div>

                @if($shipment->trackings && $shipment->trackings->count() > 0)
                    @foreach($shipment->trackings as $index => $log)
                    <div style="display: flex; gap: 16px; position: relative; animation: slideIn 0.3s ease-out forwards; animation-delay: {{ $index * 0.1 }}s; opacity: 0;">
                        <!-- Garis & titik -->
                        <div style="display: flex; flex-direction: column; align-items: center; flex-shrink: 0;">
                            <!-- Titik -->
                            <div style="
                                width: 28px; height: 28px;
                                border-radius: 50%;
                                background: {{ $index === 0 ? '#185FA5' : '#fff' }};
                                border: 2px solid {{ $index === 0 ? '#dbeafe' : '#e2e8f0' }};
                                color: {{ $index === 0 ? '#fff' : '#94a3b8' }};
                                z-index: 1;
                                flex-shrink: 0;
                                display: flex; align-items: center; justify-content: center;
                            ">
                                @if($index === 0)
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
                                @else
                                    <div style="width: 6px; height: 6px; background: currentColor; border-radius: 50%;"></div>
                                @endif
                            </div>
                            <!-- Garis -->
                            @if(!$loop->last)
                            <div style="width: 2px; flex: 1; background: #e8edf2; margin: 4px 0; min-height: 40px;"></div>
                            @endif
                        </div>

                        <!-- Konten -->
                        <div style="padding-bottom: {{ $loop->last ? '0' : '24px' }}; flex: 1;">
                            @if($index === 0)
                            <span style="background: #dbeafe; color: #1d4ed8; font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 6px; display: inline-block; margin-bottom: 8px; letter-spacing: 0.5px;">STATUS TERBARU</span>
                            @endif

                            <div style="font-size: 15px; font-weight: {{ $index === 0 ? '800' : '600' }}; color: {{ $index === 0 ? '#1e2d4a' : '#475569' }}; margin-bottom: 4px;">
                                {{ $log->description ?? 'Status diperbarui' }}
                            </div>

                            <div style="font-size: 12px; color: #94a3b8; display: flex; align-items: center; gap: 12px;">
                                <div style="display: flex; align-items: center; gap: 4px;">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    {{ $log->location ?? 'Transit' }}
                                </div>
                                <div style="display: flex; align-items: center; gap: 4px;">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                                    {{ $log->created_at->translatedFormat('d M Y, H:i') }} WIB
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div style="text-align: center; padding: 20px; color: #94a3b8; font-size: 13px; background: #f8fafc; border-radius: 12px; border: 1px dashed #e2e8f0;">
                        Belum ada histori pengiriman untuk nomor resi ini.
                    </div>
                @endif
            </div>

            <!-- Bagian 5 — Info Kurir -->
            @if($shipment->courier)
            <div style="
                background: #fff;
                border-radius: 16px;
                border: 1px solid #e8edf2;
                padding: 20px 24px;
                margin-bottom: 14px;
                animation: fadeUp 0.4s 0.3s ease forwards;
                opacity: 0;
            ">
                <div style="
                    font-size: 11px;
                    font-weight: 700;
                    color: #94a3b8;
                    letter-spacing: .08em;
                    margin-bottom: 16px;
                ">INFO KURIR</div>

                <div style="display:flex;align-items:center;gap:14px;">
                    <!-- Avatar inisial -->
                    <div style="
                        width: 48px; height: 48px;
                        border-radius: 50%;
                        background: #185FA5;
                        color: #fff;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 16px;
                        font-weight: 800;
                        flex-shrink: 0;
                    ">
                        {{ strtoupper(substr($shipment->courier->name, 0, 1)) }}
                        {{ strtoupper(substr(strrchr($shipment->courier->name, ' ') ?: '', 1, 1)) }}
                    </div>

                    <!-- Info -->
                    <div style="flex:1;">
                        <div style="font-size:15px;font-weight:700;
                                    color:#1e2d4a;margin-bottom:2px;">
                            {{ $shipment->courier->name }}
                        </div>
                        <div style="font-size:12px;color:#94a3b8;">
                            Kurir Delivery
                            &nbsp;•&nbsp;
                            {{ $shipment->branch->city ?? '' }}
                        </div>
                    </div>

                    <!-- Tombol kontak -->
                    <div style="display:flex;gap:8px;">
                        <a href="tel:{{ $shipment->courier->phone }}" style="
                            width: 40px; height: 40px;
                            background: #f0f7ff;
                            border-radius: 10px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            text-decoration: none;
                            color: #185FA5;
                        ">
                            <svg width="18" height="18" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 01-2.18 2
                                         19.79-19.79 0 01-8.63-3.07
                                         19.5 19.5 0 01-6-6
                                         19.79 19.79 0 01-3.07-8.67
                                         A2 2 0 014.11 2h3a2 2 0 012 1.72
                                         12.84 12.84 0 00.7 2.81
                                         2 2 0 01-.45 2.11L8.09 9.91
                                         a16 16 0 006 6l1.27-1.27
                                         a2 2 0 012.11-.45
                                         12.84 12.84 0 002.81.7
                                         A2 2 0 0122 16.92z"/>
                            </svg>
                        </a>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $shipment->courier->phone) }}"
                           target="_blank" style="
                            width: 40px; height: 40px;
                            background: #dcfce7;
                            border-radius: 10px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            text-decoration: none;
                            color: #16a34a;
                        ">
                            <svg width="18" height="18" viewBox="0 0 24 24"
                                 fill="currentColor">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967
                                         -.273-.099-.471-.148-.67.15
                                         -.197.297-.767.966-.94 1.164
                                         -.173.199-.347.223-.644.075
                                         -.297-.15-1.255-.463-2.39-1.475
                                         -.883-.788-1.48-1.761-1.653-2.059
                                         -.173-.297-.018-.458.13-.606
                                         .134-.133.298-.347.446-.52
                                         .149-.174.198-.298.298-.497
                                         .099-.198.05-.371-.025-.52
                                         -.075-.149-.669-1.612-.916-2.207
                                         -.242-.579-.487-.5-.669-.51
                                         -.173-.008-.371-.01-.57-.01
                                         -.198 0-.52.074-.792.372
                                         -.272.297-1.04 1.016-1.04 2.479
                                         0 1.462 1.065 2.875 1.213 3.074
                                         .149.198 2.096 3.2 5.077 4.487
                                         .709.306 1.262.489 1.694.625
                                         .712.227 1.36.195 1.871.118
                                         .571-.085 1.758-.719 2.006-1.413
                                         .248-.694.248-1.289.173-1.413
                                         -.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004
                                         a9.87 9.87 0 01-5.031-1.378l-.361-.214
                                         -3.741.982.998-3.648-.235-.374
                                         a9.86 9.86 0 01-1.51-5.26
                                         c.001-5.45 4.436-9.884 9.888-9.884
                                         2.64 0 5.122 1.03 6.988 2.898
                                         a9.825 9.825 0 012.893 6.994
                                         c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297
                                         A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892
                                         c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654
                                         a11.882 11.882 0 005.683 1.448h.005
                                         c6.554 0 11.89-5.335 11.893-11.893
                                         a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Bagian 6 — Bukti Pengiriman -->
            @if($shipment->status === 'delivered' || $shipment->status === 'failed_delivery')
            <div style="
                background: #fff;
                border-radius: 16px;
                border: 1px solid #e8edf2;
                padding: 20px 24px;
                animation: fadeUp 0.4s 0.4s ease forwards;
                opacity: 0;
            ">
                <div style="
                    font-size: 11px;
                    font-weight: 700;
                    color: #94a3b8;
                    letter-spacing: .08em;
                    margin-bottom: 16px;
                ">BUKTI PENGIRIMAN</div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">

                    <!-- Foto bukti -->
                    <div>
                        <div style="font-size:12px;font-weight:600;
                                    color:#64748b;margin-bottom:8px;">
                            Foto Paket
                        </div>
                        @if($shipment->proof_photo || $shipment->failed_photo)
                        @php $photo = $shipment->proof_photo ?? $shipment->failed_photo; @endphp
                        <a href="{{ Storage::url($photo) }}"
                           target="_blank">
                            <img src="{{ Storage::url($photo) }}"
                                 style="
                                     width:100%;height:160px;
                                     object-fit:cover;
                                     border-radius:12px;
                                     border:1px solid #e8edf2;
                                     transition:transform .2s;
                                 "
                                 onmouseover="this.style.transform='scale(1.02)'"
                                 onmouseout="this.style.transform='scale(1)'">
                        </a>
                        @else
                        <div style="
                            width:100%;height:160px;
                            background:#f8fafc;
                            border-radius:12px;
                            border:1px dashed #cbd5e1;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            color:#94a3b8;
                            font-size:13px;
                        ">Tidak ada foto</div>
                        @endif
                    </div>

                    <!-- Tanda tangan -->
                    <div>
                        <div style="font-size:12px;font-weight:600;
                                    color:#64748b;margin-bottom:8px;">
                            Tanda Tangan Penerima
                        </div>
                        @if($shipment->digital_signature)
                        <img src="{{ $shipment->digital_signature }}"
                             style="
                                 width:100%;height:160px;
                                 object-fit:contain;
                                 border-radius:12px;
                                 border:1px solid #e8edf2;
                                 background:#fafafa;
                             ">
                        @else
                        <div style="
                            width:100%;height:160px;
                            background:#f8fafc;
                            border-radius:12px;
                            border:1px dashed #cbd5e1;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            color:#94a3b8;
                            font-size:13px;
                        ">Tidak ada tanda tangan</div>
                        @endif
                    </div>

                </div>

                <!-- Diterima oleh -->
                @if($shipment->received_by || $shipment->receiver_relation)
                <div style="
                    margin-top: 14px;
                    padding: 12px 16px;
                    background: #f0fdf4;
                    border-radius: 10px;
                    border: 1px solid #bbf7d0;
                    font-size: 13px;
                    color: #166534;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                ">
                    <svg width="16" height="16" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 6L9 17l-5-5"/>
                    </svg>
                    Diterima oleh
                    <strong>{{ $shipment->received_by ?? $shipment->receiver_name }}</strong>
                    ({{ $shipment->receiver_relation ?? 'Penerima' }})
                    &nbsp;—&nbsp;
                    {{ \Carbon\Carbon::parse($shipment->delivered_at)
                       ->translatedFormat('d M Y, H.i') }} WIB
                </div>
                @endif
                
                <!-- Gagal Kirim -->
                @if($shipment->status === 'failed_delivery')
                <div style="
                    margin-top: 14px;
                    padding: 12px 16px;
                    background: #fef2f2;
                    border-radius: 10px;
                    border: 1px solid #fecaca;
                    font-size: 13px;
                    color: #991b1b;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                ">
                    <svg width="16" height="16" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    Pengiriman Gagal: 
                    <strong>{{ $shipment->failed_reason }}</strong>
                    ({{ $shipment->failed_note ?? 'Tidak ada catatan tambahan' }})
                </div>
                @endif
            </div>
            @endif
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
// Scroll otomatis ke posisi terakhir
document.addEventListener('DOMContentLoaded', function() {
    const latest = document.querySelector('.timeline-latest');
    if (latest) {
        setTimeout(() => {
            latest.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 600);
    }
});
</script>
@endpush

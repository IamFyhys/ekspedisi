<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resi Pengiriman - {{ $shipment->tracking_number }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: #185FA5;
            --slate-900: #0f172a;
            --slate-500: #64748b;
            --slate-200: #e2e8f0;
        }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            color: var(--slate-900);
        }

        .receipt-card {
            background: white;
            width: 100%;
            max-width: 500px;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.05);
            position: relative;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 25px;
            border-bottom: 2px dashed var(--slate-200);
        }

        .brand-logo {
            font-size: 24px;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -1px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .brand-tagline {
            font-size: 11px;
            color: var(--slate-500);
            font-weight: 600;
        }

        .info-grid {
            display: grid;
            grid-template-cols: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-label {
            font-size: 9px;
            font-weight: 800;
            color: var(--slate-500);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 13px;
            font-weight: 600;
        }

        .tracking-box {
            background: #f8fafc;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 30px;
            border: 1px solid var(--slate-200);
        }

        .tracking-number {
            font-size: 18px;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: 1px;
        }

        .address-section {
            margin-bottom: 30px;
        }

        .address-card {
            padding: 15px 0;
        }

        .address-card:not(:last-child) {
            border-bottom: 1px solid var(--slate-200);
        }

        .participant-name {
            font-size: 14px;
            font-weight: 800;
            margin-bottom: 2px;
        }

        .participant-phone {
            font-size: 12px;
            color: var(--slate-500);
            margin-bottom: 6px;
        }

        .participant-address {
            font-size: 11px;
            line-height: 1.5;
            color: var(--slate-500);
        }

        .details-table {
            width: 100%;
            margin-bottom: 30px;
        }

        .details-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 13px;
        }

        .total-box {
            background: var(--slate-900);
            color: white;
            padding: 20px;
            border-radius: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .total-label {
            font-size: 12px;
            font-weight: 600;
            opacity: 0.7;
        }

        .total-amount {
            font-size: 20px;
            font-weight: 800;
        }

        .qr-section {
            text-align: center;
        }

        .qr-code {
            width: 120px;
            height: 120px;
            margin-bottom: 15px;
        }

        .footer-note {
            text-align: center;
            font-size: 10px;
            color: var(--slate-500);
            margin-top: 30px;
            line-height: 1.6;
        }

        @media print {
            body { background: white; padding: 0; }
            .receipt-card { box-shadow: none; border: none; max-width: 100%; }
            @page { margin: 0; }
        }
    </style>
</head>
<body>
    <div class="receipt-card">
        <div class="header">
            <div class="brand-logo">SKYNET LOGISTICS</div>
            <div class="brand-tagline">Fast & Reliable Logistic Solutions</div>
        </div>

        <div class="tracking-box">
            <div class="info-label">Nomor Resi</div>
            <div class="tracking-number">{{ $shipment->tracking_number }}</div>
        </div>

        <div class="info-grid">
            <div>
                <div class="info-label">Tanggal</div>
                <div class="info-value">{{ $shipment->created_at->format('d M Y, H:i') }}</div>
            </div>
            <div style="text-align: right;">
                <div class="info-label">Kasir</div>
                <div class="info-value">{{ $shipment->cashier->name ?? 'System' }}</div>
            </div>
        </div>

        <div class="address-section">
            <div class="address-card">
                <div class="info-label">Pengirim</div>
                <div class="participant-name">{{ $shipment->sender_name }}</div>
                <div class="participant-phone">{{ $shipment->sender_phone }}</div>
                <div class="participant-address">{{ $shipment->originLocation->name ?? '-' }}</div>
            </div>
            <div class="address-card">
                <div class="info-label">Penerima</div>
                <div class="participant-name">{{ $shipment->receiver_name }}</div>
                <div class="participant-phone">{{ $shipment->receiver_phone }}</div>
                <div class="participant-address">
                    {{ $shipment->receiver_address }}<br>
                    <strong>{{ $shipment->destinationLocation->name ?? '-' }}</strong>
                </div>
            </div>
        </div>

        <div class="details-table">
            <div class="details-row">
                <span style="color: var(--slate-500)">Berat Paket</span>
                <span class="info-value">{{ number_format($shipment->weight / 1000, 2) }} Kg</span>
            </div>
            <div class="details-row">
                <span style="color: var(--slate-500)">Metode Bayar</span>
                <span class="info-value">{{ strtoupper($shipment->payment_method) }}</span>
            </div>
            <div class="details-row">
                <span style="color: var(--slate-500)">Status Bayar</span>
                <span class="info-value" style="color: {{ $shipment->payment_status === 'paid' ? '#10b981' : '#f59e0b' }}">
                    {{ strtoupper($shipment->payment_status) }}
                </span>
            </div>
        </div>

        <div class="total-box">
            <span class="total-label">TOTAL BIAYA</span>
            <span class="total-amount">Rp {{ number_format($shipment->total_price, 0, ',', '.') }}</span>
        </div>

        <div class="qr-section">
            <div class="info-label" style="margin-bottom: 10px;">Scan untuk Lacak</div>
            @php
                $trackingUrl = route('tracking.get', ['tracking_number' => $shipment->tracking_number]);
                $qrCodeSrc = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($trackingUrl);
            @endphp
            <img src="{{ $qrCodeSrc }}" class="qr-code" alt="QR Tracking">
            <div class="brand-tagline">www.skynet-logistics.com</div>
        </div>

        <div class="footer-note">
            Terima kasih telah mempercayakan pengiriman Anda kepada kami.<br>
            Syarat & Ketentuan berlaku. Simpan resi ini sebagai bukti sah.
        </div>
    </div>

    <script>
        window.onload = function() {
            setTimeout(() => {
                window.print();
            }, 500);
        }
    </script>
</body>
</html>

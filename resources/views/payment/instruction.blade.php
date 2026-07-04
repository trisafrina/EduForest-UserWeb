<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap');

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            padding-bottom: 50px;
            font-family: 'Montserrat', Arial, sans-serif;
            color: #142238;
            background: linear-gradient(180deg, #eef8f2 0%, #f7faf8 45%, #f3f4f6 100%);
        }

        svg {
            display: block;
            flex-shrink: 0;
        }

        .payment-topbar {
            position: sticky;
            top: 0;
            z-index: 50;
            width: min(92%, 1320px);
            margin: 22px auto 28px;
            min-height: 78px;
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 26px;
            border-radius: 28px;
            border: 1px solid rgba(255,255,255,.75);
            background: #cdefdc;
            box-shadow: 0 22px 60px rgba(45, 90, 67, .13);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 16px;
            color: #1b3045;
            text-decoration: none;
            font-weight: 900;
            letter-spacing: 8px;
        }

        .brand img {
            width: 56px;
            height: 44px;
            object-fit: contain;
        }

        .nav {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 24px;
            flex: 1;
        }

        .nav a {
            color: #1b3045;
            text-decoration: none;
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 5px;
            text-transform: uppercase;
        }

        .logout {
            border: 0;
            border-radius: 999px;
            padding: 14px 28px;
            background: #fff;
            color: #1b3045;
            font-weight: 900;
            letter-spacing: 4px;
            cursor: pointer;
            box-shadow: 0 8px 18px rgba(32, 88, 61, .12);
        }

        .page-wrap {
            width: min(92%, 720px);
            margin: 0 auto;
        }

        .page-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 18px;
        }

        .back-btn {
            border: 1px solid #c9ead6;
            border-radius: 999px;
            padding: 12px 22px;
            background: rgba(255,255,255,.85);
            color: #1b3045;
            font-size: 14px;
            font-weight: 900;
            cursor: pointer;
            box-shadow: 0 8px 18px rgba(32, 88, 61, .08);
        }

        .page-title {
            margin: 0;
            color: #1b3045;
            font-size: 20px;
            font-weight: 900;
        }

        .payment-card {
            padding: 28px;
            border: 1px solid #f0f2f1;
            border-radius: 30px;
            background: #fff;
            box-shadow: 0 14px 40px rgba(32, 88, 61, .08);
        }

        .error-box {
            margin-bottom: 20px;
            padding: 14px 16px;
            border: 1px solid #fecaca;
            border-radius: 18px;
            background: #fef2f2;
            color: #dc2626;
            font-size: 13px;
            font-weight: 800;
        }

        .summary-card {
            padding: 34px 24px;
            text-align: center;
            border: 1px solid rgba(255,255,255,.85);
            border-radius: 32px;
            background:
                radial-gradient(circle at top left, rgba(204,235,216,.95), transparent 42%),
                radial-gradient(circle at bottom right, rgba(255,255,255,.95), transparent 38%),
                rgba(255,255,255,.75);
            box-shadow: 0 24px 70px rgba(32, 88, 61, .16);
        }

        .icon-box {
            width: 64px;
            height: 64px;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 22px;
            border: 1px solid rgba(255,255,255,.85);
            background: rgba(238,248,242,.92);
            color: #2d5a43;
            box-shadow: 0 14px 35px rgba(32, 88, 61, .16);
        }

        .icon-box svg {
            width: 32px;
            height: 32px;
        }

        .summary-label {
            margin: 0;
            color: #64748b;
            font-size: 14px;
            font-weight: 700;
        }

        .amount {
            margin: 8px 0 0;
            color: #123f28;
            font-size: clamp(38px, 7vw, 56px);
            line-height: 1;
            font-weight: 900;
            letter-spacing: -1px;
        }

        .package-pill {
            display: inline-flex;
            align-items: center;
            margin-top: 22px;
            padding: 10px 22px;
            border: 1px solid #c9ead6;
            border-radius: 999px;
            background: rgba(255,255,255,.78);
            color: #2d5a43;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .section {
            margin-top: 28px;
        }

        .section-title {
            margin: 0 0 16px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 18px;
            font-weight: 900;
        }

        .detail-list {
            display: grid;
            gap: 13px;
            font-size: 14px;
        }

        .detail-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .detail-row span:first-child {
            color: #9ca3af;
            font-weight: 700;
        }

        .detail-row span:last-child {
            color: #020617;
            text-align: right;
            font-weight: 900;
        }

        .reference-value {
            color: #2d5a43 !important;
            font-family: Consolas, monospace;
            letter-spacing: 1px;
        }

        .info-box {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            padding: 15px 16px;
            border: 1px solid rgba(203,223,247,.75);
            border-radius: 18px;
            background: #e6f0fa;
            color: #1e4e8c;
            font-size: 13px;
            line-height: 1.7;
            font-weight: 700;
        }

        .info-box svg {
            width: 20px;
            height: 20px;
            margin-top: 3px;
        }

        .divider {
            margin: 26px 0;
            border-top: 1px dashed #e5e7eb;
        }

        .upload-title {
            display: block;
            margin-bottom: 12px;
            color: #64748b;
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .drop-zone {
            display: block;
            cursor: pointer;
        }

        .drop-zone-box {
            padding: 34px 18px;
            text-align: center;
            border: 2px dashed #dfe4ea;
            border-radius: 20px;
            background: #f8fafc;
            transition: .2s ease;
        }

        .drop-zone-box:hover,
        .drop-zone-box.is-selected {
            border-color: #2d5a43;
            background: #f0f7f3;
        }

        .drop-zone-box svg {
            width: 36px;
            height: 36px;
            margin: 0 auto 12px;
            color: #94a3b8;
        }

        .file-name {
            margin: 0;
            color: #64748b;
            font-size: 14px;
            font-weight: 700;
        }

        .file-note {
            margin: 8px 0 0;
            color: #9ca3af;
            font-size: 12px;
        }

        .hidden-input {
            display: none;
        }

        .submit-btn,
        .home-btn {
            display: block;
            width: 100%;
            padding: 17px 24px;
            border: 0;
            border-radius: 18px;
            background: #2d5a43;
            color: #fff;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            font-weight: 900;
            cursor: pointer;
            box-shadow: 0 12px 24px rgba(32, 88, 61, .18);
            transition: .2s ease;
        }

        .submit-btn {
            margin-top: 22px;
        }

        .submit-btn:hover,
        .home-btn:hover {
            background: #1e3522;
        }

        .modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 18px;
            background: rgba(27, 48, 69, .35);
            backdrop-filter: blur(5px);
        }

        .modal-card {
            width: min(100%, 460px);
            padding: 30px;
            text-align: center;
            border: 1px solid rgba(255,255,255,.85);
            border-radius: 32px;
            background: #fff;
            box-shadow: 0 28px 90px rgba(32, 88, 61, .22);
        }

        .modal-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: #eaf6ef;
            color: #2d5a43;
            box-shadow: 0 12px 28px rgba(32, 88, 61, .12);
        }

        .modal-icon svg {
            width: 42px;
            height: 42px;
        }

        .modal-title {
            margin: 20px 0 0;
            color: #1e3522;
            font-size: 26px;
            font-weight: 900;
        }

        .modal-text {
            margin: 12px 0 0;
            color: #64748b;
            font-size: 14px;
            line-height: 1.8;
            font-weight: 600;
        }

        .modal-note {
            display: flex;
            gap: 12px;
            margin-top: 20px;
            padding: 16px;
            text-align: left;
            border: 1px solid rgba(203,223,247,.75);
            border-radius: 18px;
            background: #e6f0fa;
            color: #1e4e8c;
            font-size: 14px;
            line-height: 1.6;
            font-weight: 700;
        }

        .modal-note svg {
            width: 20px;
            height: 20px;
            margin-top: 2px;
        }

        .modal-summary {
            margin-top: 20px;
            padding: 16px;
            border: 1px solid #f1f5f9;
            border-radius: 20px;
            background: rgba(248,250,252,.85);
            font-size: 14px;
        }

        .modal-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-top: 12px;
        }

        .modal-row:first-child {
            margin-top: 0;
        }

        .modal-row span:first-child {
            color: #9ca3af;
            font-weight: 800;
        }

        .modal-row span:last-child {
            color: #1e3522;
            text-align: right;
            font-weight: 900;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 6px 12px;
            border: 1px solid #fde68a;
            border-radius: 999px;
            background: #fffbeb;
            color: #92400e !important;
            font-size: 12px;
            font-weight: 900;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 999px;
            background: #f59e0b;
        }

        @media (max-width: 920px) {
            .payment-topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .nav {
                width: 100%;
                flex-wrap: wrap;
                justify-content: flex-start;
                gap: 14px;
            }
        }

        @media (max-width: 560px) {
            .payment-card {
                padding: 20px;
            }

            .detail-row,
            .modal-row {
                align-items: flex-start;
                flex-direction: column;
                gap: 5px;
            }

            .detail-row span:last-child,
            .modal-row span:last-child {
                text-align: left;
            }
        }
    </style>
</head>

<body>
    <header class="payment-topbar">
        <a href="{{ route('home') }}" class="brand">
            <img src="https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/EDUFOREST%20LOGO/eduforest_logo-removebg-preview.png" alt="EduForest">
            <span>EDUFOREST</span>
        </a>

        <nav class="nav">
            <a href="{{ route('activities.list') }}">Activities</a>
            <a href="{{ route('packages.index') }}">Packages</a>
            <a href="{{ route('maps.index') }}">Map</a>
            <a href="{{ route('booking.categories') }}">Booking</a>
            <a href="{{ route('my-bookings') }}">My Bookings</a>
        </nav>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout">Logout</button>
        </form>
    </header>

    <main class="page-wrap">
        <div class="page-heading">
            <button onclick="history.back()" type="button" class="back-btn">&larr; Back</button>
            <h1 class="page-title">Payment</h1>
        </div>

        <div class="payment-card">
            @if ($errors->any())
                <div class="error-box">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="summary-card">
                <div class="icon-box">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z"/>
                    </svg>
                </div>

                <p class="summary-label">Total Payment</p>

                <h2 class="amount">
                    @if(strtolower($booking->selected_category ?? '') === 'international') USD @else RM @endif
                    {{ number_format($booking->total_amount ?? 0, 2) }}
                </h2>

                <div class="package-pill">
                    {{ $packageName }} &bull; {{ $booking->total_pax ?? 1 }} Pax
                </div>
            </div>

            <section class="section">
                <h3 class="section-title">Bank Transfer Details</h3>

                <div class="detail-list">
                    <div class="detail-row">
                        <span>Bank Name</span>
                        <span>Malayan Banking Berhad (Maybank)</span>
                    </div>

                    <div class="detail-row">
                        <span>Account Name</span>
                        <span>UPSI Edu-Forest</span>
                    </div>

                    <div class="detail-row">
                        <span>Account Number</span>
                        <span>1234567890</span>
                    </div>

                    <div class="detail-row">
                        <span>Reference</span>
                        <span class="reference-value">{{ $booking->reference_number }}</span>
                    </div>

                    <div class="detail-row">
                        <span>Amount</span>
                        <span>
                            @if(strtolower($booking->selected_category ?? '') === 'international') USD @else RM @endif
                            {{ number_format($booking->total_amount ?? 0, 2) }}
                        </span>
                    </div>
                </div>
            </section>

            <div class="info-box">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 1 1 1.056 1.056L10.5 14.25M12 7.5h.008v.008H12V7.5ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>

                <p>Please include the reference number when making the payment. After paying, upload your receipt for admin approval.</p>
            </div>

            <div class="divider"></div>

            <form action="{{ route('payment.submit', $booking->reference_number) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <label class="upload-title">Upload Payment Receipt (PDF, JPG, PNG)</label>

                <label for="receiptInput" class="drop-zone">
                    <div id="dropZone" class="drop-zone-box">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z"/>
                        </svg>

                        <p class="file-name" id="file_name_display">Klik atau seret fail resit ke sini</p>
                        <p class="file-note">Format: PDF, JPG, PNG (Maks 5MB)</p>
                    </div>

                    <input type="file" id="receiptInput" name="payment_receipt" accept="application/pdf,image/png,image/jpeg,image/jpg" required class="hidden-input">
                </label>

                @error('payment_receipt')
                    <p class="error-box">{{ $message }}</p>
                @enderror

                <button type="submit" class="submit-btn">Submit Receipt</button>
            </form>
        </div>
    </main>

    @if (session('receipt_submitted'))
        <div class="modal-backdrop">
            <div class="modal-card">
                <div class="modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.9" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>

                <h2 class="modal-title">Receipt Submitted!</h2>

                <p class="modal-text">
                    Your payment receipt has been successfully uploaded and is now pending admin approval.
                </p>

                <div class="modal-note">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 1 1 1.056 1.056L10.5 14.25M12 7.5h.008v.008H12V7.5ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>

                    <p>The invoice will be uploaded after admin approval.</p>
                </div>

                <div class="modal-summary">
                    <div class="modal-row">
                        <span>Reference No.</span>
                        <span>{{ $booking->reference_number }}</span>
                    </div>

                    <div class="modal-row">
                        <span>Package</span>
                        <span>{{ $packageName }}</span>
                    </div>

                    <div class="modal-row">
                        <span>Status</span>
                        <span class="status-pill">
                            <span class="status-dot"></span>
                            Pending Approval
                        </span>
                    </div>
                </div>

                <a href="{{ route('home') }}" class="home-btn" style="margin-top: 22px;">
                    Back to Homepage
                </a>
            </div>
        </div>
    @endif

    <script>
        document.getElementById('receiptInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const display = document.getElementById('file_name_display');
            const zone = document.getElementById('dropZone');

            if (file) {
                if (file.size > 5 * 1024 * 1024) {
                    alert('Fail terlalu besar (maks 5MB).');
                    this.value = '';
                    return;
                }

                display.textContent = file.name;
                display.style.color = '#2d5a43';
                display.style.fontWeight = '900';
                zone.classList.add('is-selected');
            }
        });
    </script>
</body>
</html>
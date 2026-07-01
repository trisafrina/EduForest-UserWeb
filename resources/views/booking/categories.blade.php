<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Packages Categories</title>
</head>
<body style="margin: 0; padding: 0; background-color: #ffffff; font-family: sans-serif;">

    <!-- Container Utama: Ditukar ke 100% lebar tanpa had (Edge-to-Edge) mengikut imej pertama -->
    <div style="width: 100%; min-height: 100vh; display: flex; flex-direction: column; background-color: #ffffff;">
        
        <!-- Header Section: Sekarang penuh 100% rapat ke tepi skrin -->
        <div style="background-color: #2d6a4f; padding: 18px 24px; display: flex; align-items: center; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <a href="{{ route('home') }}" style="color: #ffffff; text-decoration: none; display: flex; align-items: center; justify-content: center; background-color: rgba(255, 255, 255, 0.15); width: 44px; height: 44px; border-radius: 50%;">
                <svg style="width: 22px; height: 22px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 style="font-size: 20px; font-weight: 700; text-align: center; flex: 1; color: #ffffff; margin: 0; padding-right: 44px; letter-spacing: 0.5px;">Packages Categories</h1>
        </div>

        <!-- Logo & Subtitle Section -->
        <div style="text-align: center; padding: 40px 20px 10px 20px;">
            <img src="https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/EDUFOREST%20LOGO/eduforest_logo-removebg-preview.png" alt="EduForest Logo" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #edf4f1;">
            <h2 style="margin: 16px 0 6px 0; font-size: 22px; font-weight: 800; color: #2d6a4f;">Please select a category</h2>
            <p style="margin: 0; font-size: 13px; color: #6b7280; font-weight: 500;">Choose a package category to continue</p>
        </div>

        <!-- CSS untuk menyamakan reka bentuk dan mengekalkan susunan mendatar -->
        <style>
            .grid-layout {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 20px;
                padding: 40px 50px; /* Jarak padding tepi yang seimbang */
                max-width: 1400px;  /* Mengekalkan kad grid tidak terlalu kembang di skrin ultra-lebar */
                margin: 0 auto;
                width: calc(100% - 100px);
            }
            .subtle-card {
                background-color: #edf4f1; 
                border: 1px solid #e2ece9;
                border-radius: 16px;
                padding: 35px 20px;
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                text-decoration: none;
                box-shadow: 0 2px 4px rgba(0,0,0,0.02);
                transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
                min-height: 240px;
            }
            .subtle-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 8px 16px rgba(45, 106, 79, 0.08);
                background-color: #e2ece9;
            }
            .circle-icon-bg {
                width: 80px;
                height: 80px;
                background-color: #ffffff;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 2px 5px rgba(0,0,0,0.03);
                margin-bottom: 24px;
            }
            .card-title {
                font-weight: 800; 
                color: #1e4634; 
                font-size: 14px; 
                margin: 0 0 10px 0; 
                letter-spacing: 0.3px;
            }
            .card-desc {
                font-size: 12px; 
                color: #4b5563; 
                font-weight: 500; 
                margin: 0; 
                line-height: 1.4;
            }
            /* Responsif untuk paparan skrin kecil / telefon bimbit */
            @media (max-width: 1024px) {
                .grid-layout { grid-template-columns: repeat(2, 1fr); padding: 20px; width: calc(100% - 40px); }
            }
            @media (max-width: 600px) {
                .grid-layout { grid-template-columns: 1fr; padding: 15px; width: calc(100% - 30px); }
            }
        </style>

        <!-- Grid Container -->
        <div class="grid-layout">
            
            <!-- 1. UPSI COMMUNITY -->
            <a href="{{ route('packages.index', ['category' => 'upsi']) }}" class="subtle-card">
                <div class="circle-icon-bg">
                    <img src="https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/CATEGORIES/UPSI%20COMMUNITY/upsi%20community.jpg" alt="UPSI" style="width: 52px; height: 52px; object-fit: contain;">
                </div>
                <h3 class="card-title">UPSI COMMUNITY</h3>
                <p class="card-desc">Special package for Universiti Pendidikan Sultan Idris members</p>
            </a>

            <!-- 2. GOVERNMENT AGENCY -->
            <a href="{{ route('packages.index', ['category' => 'gov']) }}" class="subtle-card">
                <div class="circle-icon-bg">
                    <img src="https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/CATEGORIES/GOVERNMENT%20AGENCIES/government.gif" alt="Gov" style="width: 52px; height: 52px; object-fit: contain;">
                </div>
                <h3 class="card-title">GOVERNMENT AGENCY</h3>
                <p class="card-desc">Package for government agencies and statutory bodies</p>
            </a>

            <!-- 3. PUBLIC -->
            <a href="{{ route('packages.index', ['category' => 'public']) }}" class="subtle-card">
                <div class="circle-icon-bg">
                    <img src="https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/CATEGORIES/PUBLIC/public.webp" alt="Public" style="width: 44px; height: 44px; object-fit: contain;">
                </div>
                <h3 class="card-title">PUBLIC</h3>
                <p class="card-desc">Package for public participants</p>
            </a>

            <!-- 4. INTERNATIONAL -->
            <a href="{{ route('packages.index', ['category' => 'international']) }}" class="subtle-card">
                <div class="circle-icon-bg">
                    <img src="https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/CATEGORIES/INTERNATIONAL/international.png" alt="International" style="width: 44px; height: 44px; object-fit: contain;">
                </div>
                <h3 class="card-title">INTERNATIONAL</h3>
                <p class="card-desc">Package for international participants</p>
            </a>

        </div>
    </div>

</body>
</html>
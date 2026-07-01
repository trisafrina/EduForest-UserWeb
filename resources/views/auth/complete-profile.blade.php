<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapkan Profil</title>
    <!-- Guna Tailwind CSS untuk styling cepat & cantik -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">

    <!-- Bekas utama (Reka bentuk seakan skrin telefon) -->
    <div class="w-full max-w-md bg-white rounded-3xl shadow-sm p-6 border border-gray-100">
        
        <!-- Header: Ada butang kembali & ikon edit macam image_7c4ab0.png -->
        <div class="flex items-center justify-between mb-8">
            <button onclick="window.history.back()" class="text-gray-700 hover:text-gray-900">
                <!-- Ikon Anak Panah Kiri -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </button>
            <h1 class="text-xl font-bold text-gray-800 text-center flex-1">Profile</h1>
            <div class="text-gray-700">
                <!-- Ikon Edit Kanan -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
            </div>
        </div>

        <p class="text-sm text-gray-500 mb-6 text-center">Sila lengkapkan maklumat anda sebelum meneruskan ke sistem tempahan.</p>

        <!-- Borang Mula -->
        <form action="{{ route('profile.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- 1. Input Nama Penuh -->
            <div>
                <label class="block text-sm font-bold text-gray-800 mb-2">Full Name</label>
                <input type="text" name="full_name" placeholder="Hafiz Ahmad" required
                    class="w-full bg-[#F5F5F5] text-gray-700 placeholder-gray-400 rounded-2xl px-4 py-4 border-none focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">
            </div>

            <!-- 2. Input No Telefon -->
            <div>
                <label class="block text-sm font-bold text-gray-800 mb-2">Phone</label>
                <input type="text" name="phone_number" placeholder="+6012-3456789" required
                    class="w-full bg-[#F5F5F5] text-gray-700 placeholder-gray-400 rounded-2xl px-4 py-4 border-none focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">
            </div>

            <!-- 3. Input Kategori Pengguna (Dropdown bergaya kad) -->
            <div>
                <label class="block text-sm font-bold text-gray-800 mb-2">User Category</label>
                <select name="user_category" required
                    class="w-full bg-[#F5F5F5] text-gray-700 rounded-2xl px-4 py-4 border-none focus:outline-none focus:ring-2 focus:ring-emerald-500 transition appearance-none">
                    <option value="" disabled selected hidden>Pilih kategori anda</option>
                    <option value="public">Awam (Public)</option>
                    <option value="upsi">Pelajar/Staf UPSI</option>
                    <option value="government">Kerajaan (Government)</option>
                    <option value="international">Antarabangsa (International)</option>
                </select>
            </div>

            <!-- 4. Input Asal / Negeri -->
            <div>
                <label class="block text-sm font-bold text-gray-800 mb-2">Origin (Negeri/Asal)</label>
                <input type="text" name="origin" placeholder="Perak" required
                    class="w-full bg-[#F5F5F5] text-gray-700 placeholder-gray-400 rounded-2xl px-4 py-4 border-none focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">
            </div>

            <!-- 5. Butang Simpan (Gaya moden rounded) -->
            <div class="pt-4">
                <button type="submit" 
                    class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-4 rounded-2xl shadow-md transition-all active:scale-[0.98]">
                    Simpan & Teruskan
                </button>
            </div>
        </form>
        <!-- Borang Tamat -->

    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Montserrat', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-stone-50 via-white to-emerald-50 antialiased">

    <nav class="bg-[#2D5A27] text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center relative justify-center">
            
            <a href="{{ route('profile.show') }}" class="absolute left-6 inline-flex items-center justify-center w-12 h-12 rounded-full bg-white/10 hover:bg-white/25 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-5 h-5 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </a>

            <h1 class="text-xl font-semibold tracking-wide text-white">Edit Profile</h1>
        </div>
    </nav>

    <main class="max-w-xl w-full mx-auto px-6 py-10">
        
        <div class="bg-white border border-stone-200 rounded-3xl p-6 shadow-xs">
            
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') {{-- Menggunakan method PUT untuk kemas kini data --}}

                <div class="space-y-5">
                    
                    <div class="flex flex-col items-center border-b border-stone-100 pb-5 mb-2">
                        <label class="block text-[11px] font-bold tracking-wider text-stone-400 uppercase mb-3">Profile Picture</label>
                        <div class="flex items-center space-x-5">
                            <img src="{{ $profile->profile_image_url ?? 'https://ui-avatars.com/api/?name='.urlencode($profile->full_name).'&background=EFEFEF&color=A0A0A0' }}" 
                                 class="w-20 h-20 rounded-full object-cover border-2 border-stone-200 shadow-xs" id="profile-preview">
                            
                            <input type="file" name="profile_image" id="profile_image_input" accept="image/*" 
                                   class="text-xs text-stone-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-stone-100 file:text-stone-700 hover:file:bg-stone-200 file:transition cursor-pointer">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-[11px] font-bold tracking-wider text-stone-400 uppercase">Full Name</label>
                        <input type="text" name="full_name" value="{{ old('full_name', $profile->full_name) }}" 
                            class="w-full mt-1.5 px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm font-medium text-stone-800 focus:outline-none focus:border-[#2D5A27] focus:bg-white transition" required>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold tracking-wider text-stone-400 uppercase">Phone Number</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number', $profile->phone_number) }}" 
                            class="w-full mt-1.5 px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm font-medium text-stone-800 focus:outline-none focus:border-[#2D5A27] focus:bg-white transition" required>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold tracking-wider text-stone-400 uppercase">User Category</label>
                        <select name="user_category" class="w-full mt-1.5 px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm font-medium text-stone-800 focus:outline-none focus:border-[#2D5A27] focus:bg-white transition" required>
                            <option value="upsi_community" {{ $profile->user_category == 'upsi_community' ? 'selected' : '' }}>UPSI Community</option>
                            <option value="government_agency" {{ $profile->user_category == 'government_agency' ? 'selected' : '' }}>Government Agency</option>
                            <option value="public" {{ $profile->user_category == 'public' ? 'selected' : '' }}>Public / Individual</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold tracking-wider text-stone-400 uppercase">Origin / Organization</label>
                        <input type="text" name="origin" value="{{ old('origin', $profile->origin) }}" 
                            class="w-full mt-1.5 px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm font-medium text-stone-800 focus:outline-none focus:border-[#2D5A27] focus:bg-white transition" required>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-4 bg-[#2D5A27] hover:bg-[#22441D] text-white font-bold text-sm rounded-xl transition shadow-md tracking-wide uppercase cursor-pointer">
                            Save Changes
                        </button>
                    </div>

                </div>
            </form>

        </div>

    </main>

    <script>
        document.getElementById('profile_image_input').onchange = evt => {
            const [file] = document.getElementById('profile_image_input').files;
            if (file) {
                // Mengubah sumber imej preview kepada fail yang baru dipilih
                document.getElementById('profile-preview').src = URL.createObjectURL(file);
            }
        }
    </script>

</body>
</html>
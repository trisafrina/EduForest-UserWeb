<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        // 1. Tangkap parameter ?category=, default ialah 'upsi' jika tiada
        $categoryInput = $request->query('category', 'upsi');

        // 2. Tentukan nama kolum harga dan nama tajuk secara dinamik berdasarkan kategori URL
        switch ($categoryInput) {
            case 'gov':
                $priceColumn = 'price_gov'; 
                $categoryTitle = 'Government Agency';
                $currency = 'RM';
                break;
            case 'public':
                $priceColumn = 'price_public'; 
                $categoryTitle = 'Public Participant';
                $currency = 'RM';
                break;
            case 'international':
                $priceColumn = 'price_international'; 
                $categoryTitle = 'International Participant';
                $currency = 'USD';
                break;
            case 'upsi':
            default:
                $priceColumn = 'price_upsi';
                $categoryTitle = 'UPSI Student / Staff';
                $currency = 'RM';
                break;
        }

        // 3. Tarik semua data pakej dari table 'packages' di Supabase
        $packages = DB::table('packages')->get();

        // 4. Hantar data ke fail blade 'packages.blade.php'
        return view('packages', compact('packages', 'priceColumn', 'categoryTitle', 'currency'));
    }
} 
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\Agency;

class TravelController extends Controller
{
    public function index()
    {
        $destinations = Destination::where('is_active', true)->get();
        
        // Récupérer toutes les agences sans filtrer par is_active
        $agencies = Agency::all(); // Au lieu de ::where('is_active', true)->get()
        
        return view('travel.index', compact('destinations', 'agencies'));
    }
}
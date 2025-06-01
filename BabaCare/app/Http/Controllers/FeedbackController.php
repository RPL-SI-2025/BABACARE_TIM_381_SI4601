<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    public function create()
    {
        return view('feedback.form');
    }

    // Simpan data
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'satisfaction' => 'required|in:puas,tidak_puas',
            'comment' => 'required|string',
        ], [
            'name.required' => 'Nama Pasien tidak boleh kosong.',
            'satisfaction.required' => 'Silakan pilih tingkat kepuasan.',
            'comment.required' => 'Komentar tidak boleh kosong.',
        ]);

        Feedback::create($request->only('name', 'satisfaction', 'comment'));

        return back()->with('success', 'Terima kasih atas feedback Anda!');
    }

    public function index()
    {
        $feedback = Feedback::latest()->get();
        return view('admin.feedback.index', compact('feedback'));
    }

    public function dashboard()
    {
        // Get total feedback count
        $totalFeedback = Feedback::count();
        
        // Get satisfaction statistics
        $satisfactionStats = Feedback::select('satisfaction', DB::raw('count(*) as total'))
            ->groupBy('satisfaction')
            ->get();
            
        // Get all feedback with pagination
        $feedbackList = Feedback::latest()->paginate(10);
        
        return view('admin.feedback.dashboard', compact(
            'totalFeedback',
            'satisfactionStats',
            'feedbackList'
        ));
    }
}

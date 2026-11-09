<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Generate and stream a PDF document for all users.
     */
    public function generateAllPdf(): Response
    {
        $users = User::query()
            ->with('roles')
            ->orderBy('name')
            ->get()
            ->map(static fn (User $user): array => [
                $user->name,
                $user->email,
                $user->roles->pluck('name')->join(', ') ?: '-',
                $user->created_at?->translatedFormat('d F Y H:i') ?? '-',
            ]);

        return Pdf::loadView('print.catalog', [
            'title' => 'Daftar Pengguna',
            'headers' => ['Nama Pengguna', 'Alamat Email', 'Peran', 'Ditambahkan Pada'],
            'rows' => $users,
            'printedAt' => now()->translatedFormat('d F Y H:i'),
        ])
            ->setPaper('a4', 'landscape')
            ->stream('pengguna.pdf');
    }
}

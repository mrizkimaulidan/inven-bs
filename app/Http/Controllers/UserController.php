<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;

/**
 * Handle PDF reporting actions for user records.
 */
class UserController extends Controller
{
    /**
     * Generate and stream a PDF document containing all users and their roles.
     */
    public function generateAllPdf(): Response
    {
        $rows = User::query()
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
            'rows' => $rows,
            'printedAt' => now()->translatedFormat('d F Y H:i'),
        ])
            ->setPaper('a4', 'landscape')
            ->stream('pengguna.pdf');
    }
}

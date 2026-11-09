<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    /**
     * Generate and stream a PDF document for all roles.
     */
    public function generateAllPdf(): Response
    {
        $roles = Role::query()
            ->withCount('permissions', 'users')
            ->orderBy('name')
            ->get()
            ->map(static fn (Role $role): array => [
                $role->name,
                $role->permissions_count,
                $role->users_count,
            ]);

        return Pdf::loadView('print.catalog', [
            'title' => 'Daftar Peran dan Hak Akses',
            'headers' => ['Nama Peran', 'Jumlah Hak Akses', 'Jumlah Pengguna'],
            'rows' => $roles,
            'printedAt' => now()->translatedFormat('d F Y H:i'),
        ])
            ->setPaper('a4', 'landscape')
            ->stream('peran-dan-hak-akses.pdf');
    }
}

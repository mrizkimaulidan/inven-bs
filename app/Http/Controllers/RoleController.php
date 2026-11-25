<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

/**
 * Handle PDF reporting actions for role records.
 */
class RoleController extends Controller
{
    /**
     * Generate and stream a PDF document containing all roles and relation counts.
     */
    public function generateAllPdf(): Response
    {
        $rows = Role::query()
            ->withCount(['permissions', 'users'])
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
            'rows' => $rows,
            'printedAt' => now()->translatedFormat('d F Y H:i'),
        ])
            ->setPaper('a4', 'landscape')
            ->stream('peran-dan-hak-akses.pdf');
    }
}

<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Columns\Column;
use Maatwebsite\Excel\Columns\Number;
use Maatwebsite\Excel\Columns\Text;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumns;
use Spatie\Permission\Models\Role;

class RolesExport implements FromCollection, WithColumns
{
    use Exportable;

    /**
     * Retrieve the data source for the export.
     *
     * @return Collection<int, Role>
     */
    public function collection(): Collection
    {
        return Role::query()
            ->with('permissions')
            ->withCount('permissions', 'users')
            ->orderBy('name')
            ->get()
            ->values()
            ->map(function (Role $role, int $index) {
                $role->row_number = $index + 1;

                return $role;
            });
    }

    /**
     * Define the columns and their data types.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Number::make('No', 'row_number'),
            Text::make('Nama Peran', 'name'),
            Text::make('Hak Akses', fn (Role $role) => $role->permissions->pluck('name')->implode(', ')),
            Number::make('Jumlah Hak Akses', 'permissions_count'),
            Number::make('Jumlah Pengguna', 'users_count'),
        ];
    }
}

<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Columns\Column;
use Maatwebsite\Excel\Columns\DateTime;
use Maatwebsite\Excel\Columns\Number;
use Maatwebsite\Excel\Columns\Text;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumns;

/**
 * Export user records along with their assigned roles and creation timestamps.
 */
class UsersExport implements FromCollection, WithColumns
{
    use Exportable;

    /**
     * Retrieve the data source for the export.
     *
     * @return Collection<int, User>
     */
    public function collection(): Collection
    {
        return User::query()
            ->with('roles')
            ->orderBy('name')
            ->get()
            ->map(function (User $user, int $index): User {
                $user->row_number = $index + 1;

                return $user;
            });
    }

    /**
     * Define the export columns and their data types.
     *
     * @return list<Column>
     */
    public function columns(): array
    {
        return [
            Number::make('No', 'row_number'),
            Text::make('Nama Pengguna', 'name'),
            Text::make('Alamat Email', 'email'),
            Text::make('Peran', fn (User $user): string => $user->roles->pluck('name')->implode(', ')),
            DateTime::make('Ditambahkan Pada', 'created_at'),
        ];
    }
}

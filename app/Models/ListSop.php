<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class ListSop extends Model
{
    protected $table = 'list_sops';

    public const WORK_UNIT_OPTIONS = [
        'Akademik',
        'Aset',
        'Bendahara Penerimaan',
        'Kearsipan',
        'Kepegawaian',
        'SPMI',
        'P3M',
        'Perencanaan',
    ];

    public const WORK_UNIT_CODES = [
        'Akademik' => 'AK',
        'Aset' => 'SP',
        'Bendahara Penerimaan' => 'KU',
        'Kearsipan' => 'KA',
        'Kepegawaian' => 'KP',
        'SPMI' => 'OT',
        'P3M' => 'LT',
        'Perencanaan' => 'PR',
    ];

    protected $fillable = [
        'work_unit',
        'position_number',
        'position_name',
        'date',
        'description',
        'pic',
    ];

    protected $casts = [
        'date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function workUnitOptions(): array
    {
        return self::WORK_UNIT_OPTIONS;
    }

    public static function workUnitSlug(string $workUnit): string
    {
        return str_replace(' ', '-', strtolower($workUnit));
    }

    public static function getWorkUnitFromSlug(string $slug): ?string
    {
        foreach (self::workUnitOptions() as $workUnit) {
            if (self::workUnitSlug($workUnit) === $slug) {
                return $workUnit;
            }
        }

        return null;
    }

    public static function sortUrl(string $column, string $currentSort, string $currentDirection): string
    {
        $newDirection = ($currentSort === $column && $currentDirection === 'asc') ? 'desc' : 'asc';
        return url()->current() . '?' . http_build_query(array_merge(request()->query(), ['sort' => $column, 'direction' => $newDirection]));
    }

    public static function sortIndicator(string $column, string $currentSort, string $currentDirection): string
    {
        if ($currentSort !== $column) {
            return '';
        }
        return $currentDirection === 'asc' ? ' ▲' : ' ▼';
    }

    public static function nextNumber(?string $workUnit = null): string
    {
        $query = self::query();
        if ($workUnit !== null) {
            $query->where('work_unit', $workUnit);
        }

        $max = $query->get()
            ->map(function ($sop) {
                if (preg_match('/(\d+)$/', $sop->number, $matches)) {
                    return intval(ltrim($matches[1], '0') ?: '0');
                }
                return 0;
            })
            ->max();

        return str_pad(($max ?? 0) + 1, 2, '0', STR_PAD_LEFT);
    }

    public static function workUnitCode(string $workUnit): string
    {
        return self::WORK_UNIT_CODES[$workUnit] ?? 'XX';
    }

    public static function monthToRoman(?string $dateString): string
    {
        $date = $dateString ? Carbon::parse($dateString) : Carbon::now();
        $number = (int) $date->format('n');
        $map = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII',
        ];

        return $map[$number] ?? 'I';
    }

    public static function generatePositionNumber(string $number, string $workUnit, ?string $dateString = null): string
    {
        $baseNumber = preg_replace('/[^0-9]/', '', $number);
        $baseNumber = $baseNumber === '' ? '01' : str_pad(ltrim($baseNumber, '0') ?: '0', 2, '0', STR_PAD_LEFT);
        $code = self::workUnitCode($workUnit);
        $romanMonth = self::monthToRoman($dateString);
        $year = $dateString ? Carbon::parse($dateString)->format('Y') : Carbon::now()->format('Y');

        return sprintf('%s/POLSUB/%s/%s/%s', $baseNumber, $code, $romanMonth, $year);
    }
}

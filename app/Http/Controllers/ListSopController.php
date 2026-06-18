<?php

namespace App\Http\Controllers;

use App\Models\ListSop;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListSopController extends Controller
{
    /**
     * Display a listing of all list sops.
     */
    public function index()
    {
        $sort = request('sort', 'created_at');
        $direction = request('direction', 'desc');
        $validColumns = ['number', 'work_unit', 'position_name', 'date', 'created_at'];
        
        if (!in_array($sort, $validColumns)) {
            $sort = 'created_at';
        }
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        $perPage = intval(request('per_page', 10));
        $allowed = [10,25,50,100];
        if (! in_array($perPage, $allowed)) {
            $perPage = 10;
        }

        $listSops = ListSop::orderBy($sort, $direction)->paginate($perPage)->appends(request()->query());
        $workUnits = ListSop::workUnitOptions();
        
        return view('list_sops.index', compact('listSops', 'workUnits', 'sort', 'direction'));
    }

    public function unit(string $workUnitSlug)
    {
        $workUnit = ListSop::getWorkUnitFromSlug($workUnitSlug);
        if (! $workUnit) {
            abort(404);
        }

        $sort = request('sort', 'number');
        $direction = request('direction', 'asc');
        $validColumns = ['number', 'work_unit', 'position_name', 'date', 'created_at'];
        
        if (!in_array($sort, $validColumns)) {
            $sort = 'number';
        }
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'asc';
        }

        $perPage = intval(request('per_page', 10));
        $allowed = [10,25,50,100];
        if (! in_array($perPage, $allowed)) {
            $perPage = 10;
        }

        $listSops = ListSop::where('work_unit', $workUnit)->orderBy($sort, $direction)->paginate($perPage)->appends(request()->query());
        $workUnits = ListSop::workUnitOptions();

        return view('list_sops.unit', compact('listSops', 'workUnit', 'workUnits', 'sort', 'direction'));
    }

    /**
     * Show the form for creating a new list sop.
     */
    public function create()
    {
        $workUnits = ListSop::workUnitOptions();
        return view('list_sops.create', compact('workUnits'));
    }

    /**
     * Store a newly created list sop in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'work_unit' => ['required', 'string', Rule::in(ListSop::workUnitOptions())],
            'position_name' => 'required|string|max:255',
            'date' => 'nullable|date',
            'description' => 'nullable|string',
            'pic' => 'nullable|string|max:255',
        ]);

        $validated['number'] = ListSop::nextNumber($validated['work_unit']);
        $validated['position_number'] = ListSop::generatePositionNumber($validated['number'], $validated['work_unit'], $validated['date'] ?? null);

        $sop = new ListSop($validated);
        $sop->number = $validated['number'];
        $sop->save();

        return redirect()->route('list_sop.index')->with('success', "SOP berhasil dibuat dengan nomor {$validated['number']}.");
    }

    /**
     * Display the specified list sop.
     */
    public function show(ListSop $listSop)
    {
        return view('list_sops.show', compact('listSop'));
    }

    /**
     * Show the form for editing the specified list sop.
     */
    public function edit(ListSop $listSop)
    {
        $workUnits = ListSop::workUnitOptions();
        return view('list_sops.edit', compact('listSop', 'workUnits'));
    }

    /**
     * Update the specified list sop in storage.
     */
    public function update(Request $request, ListSop $listSop)
    {
        $validated = $request->validate([
            'work_unit' => ['required', 'string', Rule::in(ListSop::workUnitOptions())],
            'position_name' => 'required|string|max:255',
            'date' => 'nullable|date',
            'description' => 'nullable|string',
            'pic' => 'nullable|string|max:255',
        ]);

        $validated['position_number'] = ListSop::generatePositionNumber($listSop->number, $validated['work_unit'], $validated['date'] ?? null);

        $listSop->update($validated);

        return redirect()->route('list_sop.show', $listSop)->with('success', 'SOP berhasil diperbarui.');
    }

    /**
     * Resolve a sequential number from raw user input.
     */
    private function resolveSequentialNumber(string $rawNumber, ListSop $existing = null): string
    {
        $rawNumber = trim($rawNumber);
        if ($rawNumber === '') {
            return $rawNumber;
        }

        if (preg_match('/^(.*?)(\d+)$/', $rawNumber, $matches)) {
            $prefix = $matches[1];
            $requestedNumber = $rawNumber;
            if ($existing && $existing->number === $requestedNumber) {
                return $requestedNumber;
            }
            if (!ListSop::where('number', $requestedNumber)->exists()) {
                return $requestedNumber;
            }
            $nextLength = strlen($matches[2]);
        } else {
            $prefix = $rawNumber;
            $nextLength = 3;
        }

        $maxSequence = ListSop::where('number', 'like', $prefix . '%')
            ->get()
            ->map(function ($sop) use ($prefix) {
                $suffix = substr($sop->number, strlen($prefix));
                return preg_match('/^(\d+)$/', $suffix, $matches) ? intval(ltrim($matches[1], '0') ?: '0') : 0;
            })
            ->max();

        $nextSequence = ($maxSequence ?? 0) + 1;
        return $prefix . str_pad($nextSequence, $nextLength, '0', STR_PAD_LEFT);
    }

    /**
     * Remove the specified list sop from storage.
     */
    public function destroy(ListSop $listSop)
    {
        $listSop->delete();

        return redirect()->route('list_sop.index')->with('success', 'SOP berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\DataGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class DataGuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cacheKey = 'data_guru_index_' . md5($request->fullUrl());

        $dataGuru = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($request) {
            $query = DataGuru::query();

            // Search by NIP or name
            if ($request->filled('search')) {
                $query->where('nip', 'like', '%' . $request->search . '%')
                      ->orWhere('nama_guru', 'like', '%' . $request->search . '%');
            }

            return $query->latest()->paginate(10);
        });
        
        return view('data-guru.index', compact('dataGuru'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('data-guru.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:data_gurus,nip',
            'nama_guru' => 'required|string|max:255',
            'email' => 'required|email|unique:data_gurus,email',
            'alamat' => 'nullable|string'
        ]);

        DataGuru::create($request->all());

        Cache::flush(); // Clear cache after adding new data

        return redirect()->route('data-guru.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DataGuru $dataGuru)
    {
        return view('data-guru.show', compact('dataGuru'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataGuru $dataGuru)
    {
        return view('data-guru.edit', compact('dataGuru'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataGuru $dataGuru)
    {
        $request->validate([
            'nip' => 'required|unique:data_gurus,nip,' . $dataGuru->id,
            'nama_guru' => 'required|string|max:255',
            'email' => 'required|email|unique:data_gurus,email,' . $dataGuru->id,
            'alamat' => 'nullable|string'
        ]);

        $dataGuru->update($request->all());

        Cache::flush(); // Clear cache after updating data

        return redirect()->route('data-guru.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataGuru $dataGuru)
    {
        $dataGuru->delete();

        Cache::flush(); // Clear cache after deleting data

        return redirect()->route('data-guru.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }

    /**
     * Show the form for importing data from CSV.
     */
    public function importForm()
    {
        return view('data-guru.import');
    }

    /**
     * Import data from CSV file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048'
        ]);

        $file = $request->file('csv_file');
        $csvData = array_map('str_getcsv', file($file->getRealPath()));
        $header = array_shift($csvData);

        $errors = [];
        $successCount = 0;

        DB::beginTransaction();
        try {
            foreach ($csvData as $index => $row) {
                $rowNumber = $index + 2; // +2 because we removed header and array is 0-indexed
                
                // Check if row has minimum required columns
                if (count($row) < 3) {
                    $errors[] = "Baris {$rowNumber}: Data tidak lengkap (minimal 3 kolom: NIP, Nama Guru, Email)";
                    continue;
                }

                // Prepare data with detailed field mapping
                $data = [
                    'nip' => isset($row[0]) ? trim($row[0]) : '',
                    'nama_guru' => isset($row[1]) ? trim($row[1]) : '',
                    'email' => isset($row[2]) ? trim($row[2]) : '',
                    'alamat' => isset($row[3]) ? trim($row[3]) : null
                ];

                // Check for empty required fields
                $missingFields = [];
                if (empty($data['nip'])) $missingFields[] = 'NIP';
                if (empty($data['nama_guru'])) $missingFields[] = 'Nama Guru';
                if (empty($data['email'])) $missingFields[] = 'Email';

                if (!empty($missingFields)) {
                    $errors[] = "Baris {$rowNumber}: Kolom wajib kosong - " . implode(', ', $missingFields);
                    continue;
                }

                // Validate data with detailed error messages
                $validator = Validator::make($data, [
                    'nip' => 'required|unique:data_gurus,nip',
                    'nama_guru' => 'required|string|max:255',
                    'email' => 'required|email|unique:data_gurus,email',
                    'alamat' => 'nullable|string'
                ], [
                    'nip.required' => 'NIP wajib diisi',
                    'nip.unique' => 'NIP sudah ada dalam database',
                    'nama_guru.required' => 'Nama Guru wajib diisi',
                    'nama_guru.max' => 'Nama Guru maksimal 255 karakter',
                    'email.required' => 'Email wajib diisi',
                    'email.email' => 'Format email tidak valid',
                    'email.unique' => 'Email sudah ada dalam database',
                ]);

                if ($validator->fails()) {
                    $fieldErrors = [];
                    foreach ($validator->errors()->all() as $error) {
                        $fieldErrors[] = $error;
                    }
                    $errors[] = "Baris {$rowNumber}: " . implode(', ', $fieldErrors);
                    continue;
                }

                DataGuru::create($data);
                $successCount++;
            }

            DB::commit();

            $message = "Import berhasil! {$successCount} data berhasil diimpor.";
            if (!empty($errors)) {
                $message .= " Terdapat " . count($errors) . " baris dengan error.";
            }

            return redirect()->route('data-guru.index')
                ->with('success', $message)
                ->with('import_errors', $errors);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('data-guru.import.form')
                ->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete multiple teachers.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'selected_ids' => 'required|array|min:1',
            'selected_ids.*' => 'exists:data_gurus,id'
        ]);

        $count = DataGuru::whereIn('id', $request->selected_ids)->delete();

        return redirect()->route('data-guru.index')
            ->with('success', "Berhasil menghapus {$count} data guru.");
    }
}

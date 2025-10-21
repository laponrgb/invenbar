<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DataSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DataSiswa::query();

        // Search by NIS
        if ($request->filled('search')) {
            $query->where('nis', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_siswa', 'like', '%' . $request->search . '%');
        }

        // Filter by kelas
        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        // Filter by jenis kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $dataSiswa = $query->latest()->paginate(10);
        
        // Get unique classes for filter dropdown
        $kelasList = DataSiswa::select('kelas')->distinct()->orderBy('kelas')->pluck('kelas');
        
        return view('data-siswa.index', compact('dataSiswa', 'kelasList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('data-siswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:data_siswas,nis',
            'nama_siswa' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'email' => 'required|email|unique:data_siswas,email',
            'alamat' => 'nullable|string'
        ]);

        DataSiswa::create($request->all());

        return redirect()->route('data-siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DataSiswa $dataSiswa)
    {
        return view('data-siswa.show', compact('dataSiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataSiswa $dataSiswa)
    {
        return view('data-siswa.edit', compact('dataSiswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataSiswa $dataSiswa)
    {
        $request->validate([
            'nis' => 'required|unique:data_siswas,nis,' . $dataSiswa->id,
            'nama_siswa' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'email' => 'required|email|unique:data_siswas,email,' . $dataSiswa->id,
            'alamat' => 'nullable|string'
        ]);

        $dataSiswa->update($request->all());

        return redirect()->route('data-siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataSiswa $dataSiswa)
    {
        $dataSiswa->delete();

        return redirect()->route('data-siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }

    /**
     * Show the form for importing data from CSV.
     */
    public function importForm()
    {
        return view('data-siswa.import');
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
                if (count($row) < 5) {
                    $errors[] = "Baris {$rowNumber}: Data tidak lengkap (minimal 5 kolom: NIS, Nama, Kelas, Jenis Kelamin, Email)";
                    continue;
                }

                // Prepare data with detailed field mapping
                $data = [
                    'nis' => isset($row[0]) ? trim($row[0]) : '',
                    'nama_siswa' => isset($row[1]) ? trim($row[1]) : '',
                    'kelas' => isset($row[2]) ? trim($row[2]) : '',
                    'jenis_kelamin' => isset($row[3]) ? strtoupper(trim($row[3])) : '',
                    'email' => isset($row[4]) ? trim($row[4]) : '',
                    'alamat' => isset($row[5]) ? trim($row[5]) : null
                ];

                // Check for empty required fields
                $missingFields = [];
                if (empty($data['nis'])) $missingFields[] = 'NIS';
                if (empty($data['nama_siswa'])) $missingFields[] = 'Nama Siswa';
                if (empty($data['kelas'])) $missingFields[] = 'Kelas';
                if (empty($data['jenis_kelamin'])) $missingFields[] = 'Jenis Kelamin';
                if (empty($data['email'])) $missingFields[] = 'Email';

                if (!empty($missingFields)) {
                    $errors[] = "Baris {$rowNumber}: Kolom wajib kosong - " . implode(', ', $missingFields);
                    continue;
                }

                // Validate data with detailed error messages
                $validator = Validator::make($data, [
                    'nis' => 'required|unique:data_siswas,nis',
                    'nama_siswa' => 'required|string|max:255',
                    'kelas' => 'required|string|max:50',
                    'jenis_kelamin' => 'required|in:L,P',
                    'email' => 'required|email|unique:data_siswas,email',
                    'alamat' => 'nullable|string'
                ], [
                    'nis.required' => 'NIS wajib diisi',
                    'nis.unique' => 'NIS sudah ada dalam database',
                    'nama_siswa.required' => 'Nama Siswa wajib diisi',
                    'nama_siswa.max' => 'Nama Siswa maksimal 255 karakter',
                    'kelas.required' => 'Kelas wajib diisi',
                    'kelas.max' => 'Kelas maksimal 50 karakter',
                    'jenis_kelamin.required' => 'Jenis Kelamin wajib diisi',
                    'jenis_kelamin.in' => 'Jenis Kelamin harus L atau P',
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

                DataSiswa::create($data);
                $successCount++;
            }

            DB::commit();

            $message = "Import berhasil! {$successCount} data berhasil diimpor.";
            if (!empty($errors)) {
                $message .= " Terdapat " . count($errors) . " baris dengan error.";
            }

            return redirect()->route('data-siswa.index')
                ->with('success', $message)
                ->with('import_errors', $errors);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('data-siswa.import.form')
                ->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete multiple students.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'selected_ids' => 'required|array|min:1',
            'selected_ids.*' => 'exists:data_siswas,id'
        ]);

        $count = DataSiswa::whereIn('id', $request->selected_ids)->delete();

        return redirect()->route('data-siswa.index')
            ->with('success', "Berhasil menghapus {$count} data siswa.");
    }

}

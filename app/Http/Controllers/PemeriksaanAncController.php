<?php

namespace App\Http\Controllers;

use App\Models\IbuHamil;
use App\Models\PemeriksaanAnc;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemeriksaanAncController extends Controller
{
    public function create(Request $request)
    {
        $ibuHamilId = $request->query('ibu_hamil_id');
        if (! $ibuHamilId) {
            return redirect()->route('ibu-hamil.index')->with('error', 'Silakan pilih pasien terlebih dahulu.');
        }

        $ibuHamil = IbuHamil::findOrFail($ibuHamilId);

        return view('pemeriksaan-anc.create', compact('ibuHamil'));
    }

    private function getValidationRules($isDraft = false)
    {
        $req = $isDraft ? 'nullable' : 'required';
        $numericRule = [$req, 'string', 'regex:/^([0-9.]+|\-)$/'];

        return [
            'tanggal_pemeriksaan' => 'required|date',
            'waktu_pemeriksaan' => 'required|date_format:H:i',
            'trimester' => "$req|string",
            'keluhan_utama' => "$req|string",
            'berat_badan' => $numericRule,
            'tinggi_badan' => $numericRule,
            'tekanan_darah' => "$req|string",
            'lingkar_lengan_atas' => $numericRule,
            'tinggi_fundus_uteri' => $numericRule,
            'letak_janin' => "$req|string|in:Kepala,Sungsang,Lintang,-",
            'denyut_jantung_janin' => $numericRule,
            'status_imunisasi_tt' => "$req|string|in:T1,T2,T3,T4,T5,-",
            'jumlah_tablet_darah' => $numericRule,
            'risiko_anemia' => "$req|string|in:Ringan,Sedang,Tinggi,-",
            // Lab fields are only required if rujuk_laboratorium is checked
            'lab_hb' => ['exclude_unless:rujuk_laboratorium,1', $req, 'string', 'regex:/^([0-9.]+|\-)$/'],
            'lab_protein_urine' => ['exclude_unless:rujuk_laboratorium,1', $req, 'string', 'in:Negatif (-),Positif (+),Positif (++),Positif (+++),-'],
            'lab_golongan_darah' => ['exclude_unless:rujuk_laboratorium,1', $req, 'string', 'in:A,B,AB,O,-'],
            'lab_hiv' => ['exclude_unless:rujuk_laboratorium,1', $req, 'string', 'in:Non Reaktif,Reaktif,-'],
            'lab_sifilis' => ['exclude_unless:rujuk_laboratorium,1', $req, 'string', 'in:Non Reaktif,Reaktif,-'],
            'lab_hepatitis_b' => ['exclude_unless:rujuk_laboratorium,1', $req, 'string', 'in:Non Reaktif,Reaktif,-'],
            'catatan_lab' => ['exclude_unless:rujuk_laboratorium,1', 'nullable', 'string'],
            'hasil_usg' => "$req|string",
            'tatalaksana_kasus' => "$req|string",
            'konseling' => "$req|string",
            'skrining_jiwa' => "$req|string",
        ];
    }

    private function mapEmptyValues($validated)
    {
        $numericFields = [
            'berat_badan', 'tinggi_badan', 'lingkar_lengan_atas',
            'tinggi_fundus_uteri', 'denyut_jantung_janin',
            'jumlah_tablet_darah', 'lab_hb',
        ];

        foreach ($numericFields as $field) {
            if (isset($validated[$field]) && $validated[$field] === '-') {
                $validated[$field] = null;
            }
        }

        return $validated;
    }

    public function store(Request $request)
    {
        $action = $request->input('action');
        $isDraft = in_array($action, ['draft', 'draft_print']);

        $rules = $this->getValidationRules($isDraft);
        $rules['ibu_hamil_id'] = 'required|exists:ibu_hamils,id';

        $validated = $request->validate($rules, [
            'regex' => 'Kolom :attribute hanya boleh berisi angka atau strip (-).',
        ]);

        $validated = $this->mapEmptyValues($validated);

        // Handle booleans
        $validated['diberikan_imunisasi_tt'] = $request->has('diberikan_imunisasi_tt');
        $validated['diberikan_tablet_tambah_darah'] = $request->has('diberikan_tablet_tambah_darah');
        $validated['rujuk_laboratorium'] = $request->has('rujuk_laboratorium');
        $validated['ditemukan_risiko'] = $request->has('ditemukan_risiko');
        $action = $request->input('action');
        $validated['status'] = in_array($action, ['draft', 'draft_print']) ? 'draft' : 'selesai';

        $anc = PemeriksaanAnc::create($validated);

        if ($validated['status'] === 'selesai' && $validated['ditemukan_risiko']) {
            $ibuHamil = IbuHamil::find($anc->ibu_hamil_id);
            if ($ibuHamil) {
                $ibuHamil->status_risiko_kehamilan = 'Sangat Tinggi';
                $ibuHamil->tindakan_medis = $validated['tatalaksana_kasus'] ?? null;
                $ibuHamil->save();
            }

            return redirect()->route('rujukan.index')
                ->with('success', 'Data Pemeriksaan ANC disimpan. Karena ditemukan risiko, pasien langsung diteruskan ke daftar Rujukan Sangat Tinggi.');
        }

        if ($validated['status'] === 'draft') {
            if ($action === 'draft_print') {
                return redirect()->route('ibu-hamil.show', $anc->ibu_hamil_id)
                    ->with('warning', 'Pemeriksaan ANC disimpan sebagai Draft dan Surat Rujukan sedang diunduh.')
                    ->with('print_lab_id', $anc->id);
            }

            return redirect()->route('ibu-hamil.show', $anc->ibu_hamil_id)
                ->with('warning', 'Pemeriksaan ANC berhasil disimpan sebagai Draft.');
        }

        return redirect()->route('ibu-hamil.show', $anc->ibu_hamil_id)
            ->with('success', 'Data Pemeriksaan ANC berhasil disimpan.');
    }

    public function edit($id)
    {
        $anc = PemeriksaanAnc::with('ibuHamil')->findOrFail($id);

        if ($anc->status === 'selesai') {
            return redirect()->route('ibu-hamil.show', $anc->ibu_hamil_id)->with('error', 'Pemeriksaan yang sudah selesai tidak dapat diubah.');
        }

        $ibuHamil = $anc->ibuHamil;

        return view('pemeriksaan-anc.edit', compact('anc', 'ibuHamil'));
    }

    public function update(Request $request, $id)
    {
        $anc = PemeriksaanAnc::findOrFail($id);

        if ($anc->status === 'selesai') {
            return redirect()->route('ibu-hamil.show', $anc->ibu_hamil_id)->with('error', 'Pemeriksaan yang sudah selesai tidak dapat diubah.');
        }

        $action = $request->input('action');
        $isDraft = in_array($action, ['draft', 'draft_print']);

        $validated = $request->validate($this->getValidationRules($isDraft), [
            'regex' => 'Kolom :attribute hanya boleh berisi angka atau strip (-).',
        ]);

        $validated = $this->mapEmptyValues($validated);

        $validated['diberikan_imunisasi_tt'] = $request->has('diberikan_imunisasi_tt');
        $validated['diberikan_tablet_tambah_darah'] = $request->has('diberikan_tablet_tambah_darah');
        $validated['rujuk_laboratorium'] = $request->has('rujuk_laboratorium');
        $validated['ditemukan_risiko'] = $request->has('ditemukan_risiko');
        $action = $request->input('action');
        $validated['status'] = in_array($action, ['draft', 'draft_print']) ? 'draft' : 'selesai';

        $anc->update($validated);

        if ($validated['status'] === 'selesai' && $validated['ditemukan_risiko']) {
            $ibuHamil = IbuHamil::find($anc->ibu_hamil_id);
            if ($ibuHamil) {
                $ibuHamil->status_risiko_kehamilan = 'Sangat Tinggi';
                $ibuHamil->tindakan_medis = $validated['tatalaksana_kasus'] ?? null;
                $ibuHamil->save();
            }

            return redirect()->route('rujukan.index')
                ->with('success', 'Data Pemeriksaan ANC disimpan. Karena ditemukan risiko, pasien langsung diteruskan ke daftar Rujukan Sangat Tinggi.');
        }

        if ($validated['status'] === 'draft') {
            if ($action === 'draft_print') {
                return redirect()->route('ibu-hamil.show', $anc->ibu_hamil_id)
                    ->with('warning', 'Pemeriksaan ANC diperbarui sebagai Draft dan Surat Rujukan sedang diunduh.')
                    ->with('print_lab_id', $anc->id);
            }

            return redirect()->route('ibu-hamil.show', $anc->ibu_hamil_id)
                ->with('warning', 'Pemeriksaan ANC berhasil disimpan sebagai Draft.');
        }

        return redirect()->route('ibu-hamil.show', $anc->ibu_hamil_id)
            ->with('success', 'Data Pemeriksaan ANC berhasil disimpan.');
    }

    public function destroy($id)
    {
        $anc = PemeriksaanAnc::findOrFail($id);
        $ibuHamilId = $anc->ibu_hamil_id;
        $anc->delete();

        return redirect()->route('ibu-hamil.show', $ibuHamilId)->with('success', 'Riwayat Pemeriksaan ANC berhasil dihapus.');
    }

    public function show($id)
    {
        $anc = PemeriksaanAnc::with('ibuHamil')->findOrFail($id);

        return view('pemeriksaan-anc.show', compact('anc'));
    }

    public function cetakRujukanLabPdf($id)
    {
        $anc = PemeriksaanAnc::with('ibuHamil')->findOrFail($id);

        if (! $anc->rujuk_laboratorium) {
            return back()->with('error', 'Kunjungan ini tidak merujuk ke laboratorium.');
        }

        $pdf = Pdf::loadView('pemeriksaan-anc.rujukan-lab-pdf', [
            'anc' => $anc,
            'ibuHamil' => $anc->ibuHamil,
            'bidan' => Auth::user(),
            'tanggal' => now()->translatedFormat('d F Y'),
        ]);

        return $pdf->download('Surat_Rujukan_Lab_'.str_replace(' ', '_', $anc->ibuHamil->nama_lengkap).'.pdf');
    }
}

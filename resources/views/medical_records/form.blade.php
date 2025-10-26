<div class="mb-3">
    <label for="user_id" class="form-label">Pasien</label>
    <select name="user_id" class="form-control" required>
        @foreach($users as $user)
            <option value="{{ $user->id }}" {{ old('user_id', optional($record)->user_id) == $user->id ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="doctor_id" class="form-label">Dokter</label>
    <select name="doctor_id" class="form-control">
        <option value="">-- Tidak Ada --</option>
        @foreach($doctors as $doctor)
            <option value="{{ $doctor->id }}" {{ old('doctor_id', optional($record)->doctor_id) == $doctor->id ? 'selected' : '' }}>
                {{ $doctor->nama }} ({{ $doctor->spesialisasi }})
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="tanggal_kunjungan" class="form-label">Tanggal Kunjungan</label>
    <input type="date" name="tanggal_kunjungan" class="form-control"
        value="{{ old('tanggal_kunjungan', optional($record)->tanggal_kunjungan) }}" required>
</div>

<div class="mb-3">
    <label for="keluhan" class="form-label">Keluhan</label>
    <textarea name="keluhan" class="form-control" required>{{ old('keluhan', optional($record)->keluhan) }}</textarea>
</div>

<div class="mb-3">
    <label for="diagnosis" class="form-label">Diagnosis</label>
    <textarea name="diagnosis" class="form-control">{{ old('diagnosis', optional($record)->diagnosis) }}</textarea>
</div>

<div class="mb-3">
    <label for="tindakan" class="form-label">Tindakan</label>
    <textarea name="tindakan" class="form-control">{{ old('tindakan', optional($record)->tindakan) }}</textarea>
</div>

<div class="mb-3">
    <label for="resep_obat" class="form-label">Resep Obat</label>
    <textarea name="resep_obat" class="form-control">{{ old('resep_obat', optional($record)->resep_obat) }}</textarea>
</div>

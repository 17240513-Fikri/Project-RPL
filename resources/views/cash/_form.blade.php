@csrf
@if($cashTransaction->exists)
    @method('PUT')
@endif

<div class="form-grid">
    <div class="field">
        <label for="type">Jenis Transaksi</label>
        <select id="type" name="type" required>
            <option value="pemasukan" @selected(old('type', $cashTransaction->type) === 'pemasukan')>Pemasukan</option>
            <option value="pengeluaran" @selected(old('type', $cashTransaction->type) === 'pengeluaran')>Pengeluaran</option>
        </select>
    </div>
    <div class="field">
        <label for="category">Kategori</label>
        <input id="category" name="category" value="{{ old('category', $cashTransaction->category) }}" required>
    </div>
    <div class="field">
        <label for="amount">Nominal</label>
        <input id="amount" name="amount" type="number" step="0.01" min="0" value="{{ old('amount', $cashTransaction->amount) }}" required>
    </div>
    <div class="field">
        <label for="transaction_date">Tanggal</label>
        <input id="transaction_date" name="transaction_date" type="date" value="{{ old('transaction_date', optional($cashTransaction->transaction_date)->format('Y-m-d') ?: now()->format('Y-m-d')) }}" required>
    </div>
    <div class="field">
        <label for="payment_method">Metode Bayar</label>
        <input id="payment_method" name="payment_method" value="{{ old('payment_method', $cashTransaction->payment_method) }}">
    </div>
    <div class="field">
        <label for="reference">Referensi</label>
        <input id="reference" name="reference" value="{{ old('reference', $cashTransaction->reference) }}">
    </div>
    <div class="field full">
        <label for="description">Keterangan</label>
        <textarea id="description" name="description" required>{{ old('description', $cashTransaction->description) }}</textarea>
    </div>
</div>

<div class="form-actions" style="margin-top: 18px;">
    <a class="btn secondary" href="{{ route('cash.index') }}">Batal</a>
    <button class="btn" type="submit">Simpan Transaksi</button>
</div>

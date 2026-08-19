@if (! $selected)
    <p>Tidak ada aset yang tercatat.</p>
@else
    @php
        $accumulated = (float) $selected->depreciations()->where('status', 'posted')->sum('expense_amount');
        $bookValue = (float) $selected->acquisition_cost - $accumulated;
        $statusLabel = ucwords(str_replace('_', ' ', $selected->status));
    @endphp

    <table class="print-table">
        <tbody>
            <tr>
                <td style="width:35%;">Nama Aset</td>
                <td>{{ $selected->name }}</td>
                <td style="width:25%;">Nomor Aset</td>
                <td>{{ $selected->asset_number }}</td>
            </tr>
            <tr>
                <td>Kategori</td>
                <td>{{ $selected->category?->name ?? '-' }}</td>
                <td>Status</td>
                <td>{{ $statusLabel }}</td>
            </tr>
            <tr>
                <td>Tanggal Perolehan</td>
                <td>{{ $selected->acquisition_date?->format('d M Y') ?? '-' }}</td>
                <td>Metode Penyusutan</td>
                <td>{{ $selected->depreciationMethod?->name ?? '-' }}</td>
            </tr>
            <tr>
                <td>Harga Perolehan</td>
                <td>Rp {{ number_format($selected->acquisition_cost, 0, ',', '.') }}</td>
                <td>Nilai Residu</td>
                <td>Rp {{ number_format($selected->residual_value, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Umur Manfaat</td>
                <td>{{ $selected->useful_life }} tahun</td>
                <td>Akumulasi Penyusutan</td>
                <td>Rp {{ number_format($accumulated, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Nilai Buku</td>
                <td>Rp {{ number_format($bookValue, 0, ',', '.') }}</td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <h2 class="section-title">Jadwal Penyusutan</h2>
    <table class="print-table">
        <thead>
            <tr>
                <th>Periode</th>
                <th class="num">Beban Penyusutan</th>
                <th class="num">Akumulasi</th>
                <th class="num">Nilai Buku</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($schedule as $depreciation)
                <tr>
                    <td>{{ $depreciation->period }}</td>
                    <td class="num">{{ number_format($depreciation->expense_amount, 0, ',', '.') }}</td>
                    <td class="num">{{ number_format($depreciation->accumulated_after, 0, ',', '.') }}</td>
                    <td class="num">{{ number_format($depreciation->book_value_after, 0, ',', '.') }}</td>
                    <td>
                        @if ($depreciation->status === 'posted')
                            <span class="badge badge-primary">Posted</span>
                        @else
                            <span class="badge badge-warning">Pending</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Belum ada jadwal penyusutan untuk aset ini.</td></tr>
            @endforelse
        </tbody>
    </table>
@endif
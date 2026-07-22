@extends('layouts.app')

@section('title', 'Akad Syariah')
@section('page-title', 'Akad Syariah')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Master</a>
    <span>/</span>
    <span class="text-slate-700">Akad Syariah</span>
@endsection

@section('content')
    <div class="flex flex-col md:flex-row justify-between md:items-center mb-6 gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Daftar Akad</h2>
            <p class="text-slate-500 text-sm">Kelola jenis akad syariah (Murabahah, Mudharabah, dll).</p>
        </div>
        <button onclick="openModal('create-modal')" class="bg-primary text-white px-4 py-2.5 rounded-xl font-semibold flex items-center justify-center gap-2 hover:bg-primary-dark transition-colors shadow-sm">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Tambah Akad
        </button>
    </div>

    @if ($message = Session::get('success'))
        <div class="mb-6 p-4 bg-primary-light border border-primary rounded-xl flex items-start gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 text-primary flex-shrink-0 mt-0.5"></i>
            <p class="font-medium text-slate-800">{{ $message }}</p>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-soft border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100 sticky top-0">
                    <tr>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kode</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Akad</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Deskripsi</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Akun Debit</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Akun Kredit</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($contracts as $contract)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-4 text-sm font-medium text-slate-700 font-mono">{{ $contract->code }}</td>
                            <td class="py-3 px-4 text-sm font-medium text-slate-800">{{ $contract->name }}</td>
                            <td class="py-3 px-4 text-sm text-slate-600">{{ $contract->description ?? '-' }}</td>
                            <td class="py-3 px-4 text-sm text-slate-600">{{ $contract->debitAccount?->name ?? '-' }}</td>
                            <td class="py-3 px-4 text-sm text-slate-600">{{ $contract->creditAccount?->name ?? '-' }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full {{ $contract->is_active ? 'bg-primary-light text-primary' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $contract->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button onclick="openEditModal({{ $contract->id }}, '{{ $contract->code }}', '{{ $contract->name }}', '{{ $contract->description ?? '' }}', {{ $contract->debit_account_id ?? 'null' }}, {{ $contract->credit_account_id ?? 'null' }}, {{ $contract->is_active ? 'true' : 'false' }})" class="p-1.5 hover:bg-warning-light rounded-lg text-slate-500 hover:text-warning">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </button>
                                    <form action="{{ route('contracts.destroy', $contract->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 hover:bg-danger-light rounded-lg text-slate-500 hover:text-danger">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 px-4 text-center text-slate-500">Belum ada data akad.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($contracts->count() > 0)
            <div>{{ $contracts->links() }}</div>
        @endif
    </div>

    <!-- Create Modal -->
    <div id="create-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-xl max-h-[90vh] flex flex-col">
            <div class="flex items-center justify-between p-5 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Tambah Akad Baru</h3>
                    <p class="text-sm text-slate-500">Lambahkan jenis akad syariah.</p>
                </div>
                <button onclick="closeModal('create-modal')" class="p-2 hover:bg-slate-100 rounded-lg text-slate-500">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <form action="{{ route('contracts.store') }}" method="POST" class="p-6 overflow-y-auto custom-scroll">
                @csrf
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Kode Akad <span class="text-danger">*</span></label>
                            <input type="text" name="code" placeholder="MUR" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Akad <span class="text-danger">*</span></label>
                            <input type="text" name="name" placeholder="Murabahah" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi</label>
                        <textarea name="description" rows="2" placeholder="Deskripsi akad..." class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary resize-none"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Akun Debit Default</label>
                            <select name="debit_account_id" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white">
                                <option value="">Pilih Akun</option>
                                @foreach(\App\Models\Account::where('is_active', true)->get() as $account)
                                    <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Akun Kredit Default</label>
                            <select name="credit_account_id" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white">
                                <option value="">Pilih Akun</option>
                                @foreach(\App\Models\Account::where('is_active', true)->get() as $account)
                                    <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary/30">
                            <span class="text-sm text-slate-600">Aktif</span>
                        </label>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeModal('create-modal')" class="px-5 py-2.5 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-white transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-primary rounded-xl hover:bg-primary-dark transition-colors shadow-sm flex items-center gap-2">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="edit-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-xl max-h-[90vh] flex flex-col">
            <div class="flex items-center justify-between p-5 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Edit Akad</h3>
                    <p class="text-sm text-slate-500">Perbarui data akad.</p>
                </div>
                <button onclick="closeModal('edit-modal')" class="p-2 hover:bg-slate-100 rounded-lg text-slate-500">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <form id="edit-form" method="POST" class="p-6 overflow-y-auto custom-scroll">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Kode Akad <span class="text-danger">*</span></label>
                            <input type="text" id="edit-code" name="code" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Akad <span class="text-danger">*</span></label>
                            <input type="text" id="edit-name" name="name" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi</label>
                        <textarea id="edit-description" name="description" rows="2" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary resize-none"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Akun Debit Default</label>
                            <select id="edit-debit" name="debit_account_id" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white">
                                <option value="">Pilih Akun</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Akun Kredit Default</label>
                            <select id="edit-credit" name="credit_account_id" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white">
                                <option value="">Pilih Akun</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" id="edit-active" name="is_active" value="1" class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary/30">
                            <span class="text-sm text-slate-600">Aktif</span>
                        </label>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeModal('edit-modal')" class="px-5 py-2.5 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-white transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-primary rounded-xl hover:bg-primary-dark transition-colors shadow-sm flex items-center gap-2">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.getElementById(id).classList.add('flex');
            lucide.createIcons();
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.getElementById(id).classList.remove('flex');
        }

        document.querySelectorAll('[id$="-modal"]').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) closeModal(this.id);
            });
        });

        function openEditModal(id, code, name, description, debitId, creditId, isActive) {
            document.getElementById('edit-code').value = code;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-description').value = description;
            document.getElementById('edit-active').checked = isActive;

            const accounts = @json($accounts);

            const fillSelect = (id, selectedId) => {
                const select = document.getElementById(id);
                select.innerHTML = '<option value="">Pilih Akun</option>';
                accounts.forEach(a => {
                    select.innerHTML += `<option value="${a.id}">${a.code} - ${a.name}</option>`;
                });
                if (selectedId) select.value = selectedId;
            };

            fillSelect('edit-debit', debitId);
            fillSelect('edit-credit', creditId);

            document.getElementById('edit-form').action = '/contracts/' + id;
            openModal('edit-modal');
        }
    </script>
    <script>lucide.createIcons();</script>
@endsection

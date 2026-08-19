@extends('layouts.app')

@section('title', 'Chart of Account')
@section('page-title', 'Chart of Account')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Master</a>
    <span>/</span>
    <span class="text-slate-700">Chart of Account</span>
@endsection

@section('content')
    <div class="flex flex-col md:flex-row justify-between md:items-center mb-6 gap-4">
        <div>
            <h2 class="text-xl font-bold text-text-primary">Daftar Akun</h2>
            <p class="text-text-secondary text-sm">Kelola chart of account (COA) untuk akuntansi.</p>
        </div>
        <button onclick="openModal('create-modal')" class="bg-primary text-white px-4 py-2.5 rounded-xl font-semibold flex items-center justify-center gap-2 hover:bg-primary-dark transition-colors shadow-sm">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Tambah Akun
        </button>
    </div>

    @if ($message = Session::get('success'))
        <div class="mb-6 p-4 bg-primary-light border border-primary rounded-xl flex items-start gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 text-primary flex-shrink-0 mt-0.5"></i>
            <p class="font-medium text-text-primary">{{ $message }}</p>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-soft border border-slate-100 overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex flex-col md:flex-row gap-3 md:items-center justify-between">
            <div class="relative w-full md:w-64">
                <i data-lucide="search" class="w-4 h-4 text-text-secondary absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input type="text" placeholder="Cari kode / nama akun..." class="w-full pl-10 pr-4 py-2 text-sm border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100 sticky top-0">
                    <tr>
                        <th class="py-3 px-4 text-xs font-semibold text-text-secondary uppercase tracking-wider">Kode</th>
                        <th class="py-3 px-4 text-xs font-semibold text-text-secondary uppercase tracking-wider">Nama Akun</th>
                        <th class="py-3 px-4 text-xs font-semibold text-text-secondary uppercase tracking-wider">Kategori</th>
                        <th class="py-3 px-4 text-xs font-semibold text-text-secondary uppercase tracking-wider">Saldo Normal</th>
                        <th class="py-3 px-4 text-xs font-semibold text-text-secondary uppercase tracking-wider">Induk</th>
                        <th class="py-3 px-4 text-xs font-semibold text-text-secondary uppercase tracking-wider">Status</th>
                        <th class="py-3 px-4 text-xs font-semibold text-text-secondary uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($accounts as $account)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-4 text-sm font-medium text-slate-700 font-mono">{{ $account->code }}</td>
                            <td class="py-3 px-4 text-sm text-text-primary">
                                <div class="flex items-center gap-2">
                                    @if($account->parent_id)
                                        <span class="w-1 border-l-2 border-slate-300 h-4"></span>
                                    @endif
                                    {{ $account->name }}
                                </div>
                            </td>
                            <td class="py-3 px-4 text-sm text-slate-600">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    @switch($account->category)
                                        @case('asset') bg-blue-100 text-blue-700 @break
                                        @case('liability') bg-red-100 text-red-700 @break
                                        @case('equity') bg-purple-100 text-purple-700 @break
                                        @case('revenue') bg-green-100 text-green-700 @break
                                        @case('expense') bg-orange-100 text-orange-700 @break
                                    @endswitch">
                                    {{ ucfirst($account->category) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-sm text-slate-600">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $account->normal_balance === 'debit' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700' }}">
                                    {{ ucfirst($account->normal_balance) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-sm text-slate-600">{{ $account->parent?->name ?? '-' }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full {{ $account->is_active ? 'bg-primary-light text-primary' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $account->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button onclick="openEditModal({{ $account->id }}, '{{ $account->code }}', '{{ $account->name }}', '{{ $account->category }}', '{{ $account->normal_balance }}', {{ $account->parent_id ?? 'null' }}, {{ $account->is_active ? 'true' : 'false' }})" class="p-1.5 hover:bg-warning-light rounded-lg text-text-secondary hover:text-warning">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </button>
                                    <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 hover:bg-danger-light rounded-lg text-text-secondary hover:text-danger">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 px-4 text-center text-text-secondary">Belum ada data akun.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($accounts->count() > 0)
            <div>{{ $accounts->links() }}</div>
        @endif
    </div>

    <div id="create-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-xl max-h-[90vh] flex flex-col">
            <div class="flex items-center justify-between p-5 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-bold text-text-primary">Tambah Akun Baru</h3>
                    <p class="text-sm text-text-secondary">Lengkapi data akun.</p>
                </div>
                <button onclick="closeModal('create-modal')" class="p-2 hover:bg-slate-100 rounded-lg text-text-secondary">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <form action="{{ route('accounts.store') }}" method="POST" class="p-6 overflow-y-auto custom-scroll">
                @csrf
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Kode Akun <span class="text-danger">*</span></label>
                            <input type="text" name="code" placeholder="1101" required class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary {{ $errors->has('code') ? 'border-danger' : 'border-slate-200' }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Kategori <span class="text-danger">*</span></label>
                            <select name="category" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white">
                                <option value="">Pilih Kategori</option>
                                <option value="asset">Aset</option>
                                <option value="liability">Liabilitas</option>
                                <option value="equity">Ekuitas</option>
                                <option value="revenue">Pendapatan</option>
                                <option value="expense">Beban</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Akun <span class="text-danger">*</span></label>
                        <input type="text" name="name" placeholder="Kas Perusahaan" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Saldo Normal <span class="text-danger">*</span></label>
                            <select name="normal_balance" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white">
                                <option value="debit">Debit</option>
                                <option value="credit">Kredit</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Akun Induk</label>
                            <select name="parent_id" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white">
                                <option value="">Tanpa Induk</option>
                                @foreach(\App\Models\Account::where('parent_id', null)->get() as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->code }} - {{ $parent->name }}</option>
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

    <div id="edit-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-xl max-h-[90vh] flex flex-col">
            <div class="flex items-center justify-between p-5 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-bold text-text-primary">Edit Akun</h3>
                    <p class="text-sm text-text-secondary">Perbarui data akun.</p>
                </div>
                <button onclick="closeModal('edit-modal')" class="p-2 hover:bg-slate-100 rounded-lg text-text-secondary">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <form id="edit-form" method="POST" class="p-6 overflow-y-auto custom-scroll">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <input type="hidden" id="edit-id">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Kode Akun <span class="text-danger">*</span></label>
                            <input type="text" id="edit-code" name="code" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Kategori <span class="text-danger">*</span></label>
                            <select id="edit-category" name="category" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white">
                                <option value="asset">Aset</option>
                                <option value="liability">Liabilitas</option>
                                <option value="equity">Ekuitas</option>
                                <option value="revenue">Pendapatan</option>
                                <option value="expense">Beban</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Akun <span class="text-danger">*</span></label>
                        <input type="text" id="edit-name" name="name" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Saldo Normal <span class="text-danger">*</span></label>
                            <select id="edit-normal" name="normal_balance" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white">
                                <option value="debit">Debit</option>
                                <option value="credit">Kredit</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Akun Induk</label>
                            <select id="edit-parent" name="parent_id" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white">
                                <option value="">Tanpa Induk</option>
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

        function openEditModal(id, code, name, category, normalBalance, parentId, isActive) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-code').value = code;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-category').value = category;
            document.getElementById('edit-normal').value = normalBalance;
            document.getElementById('edit-active').checked = isActive;

            const parentSelect = document.getElementById('edit-parent');
            parentSelect.innerHTML = '<option value="">Tanpa Induk</option>';
            @foreach(\App\Models\Account::where('parent_id', null)->get() as $parent)
                parentSelect.innerHTML += `<option value="{{ $parent->id }}">{{ $parent->code }} - {{ $parent->name }}</option>`;
            @endforeach

            if (parentId) parentSelect.value = parentId;

            document.getElementById('edit-form').action = '/accounts/' + id;
            openModal('edit-modal');
        }
    </script>
    <script>lucide.createIcons();</script>
@endsection

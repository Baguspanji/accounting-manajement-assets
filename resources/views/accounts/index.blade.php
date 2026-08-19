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
            <i data-lucide="check-circle" class="w-5 h-5 text-primary shrink-0 mt-0.5"></i>
            <p class="font-medium text-text-primary">{{ $message }}</p>
        </div>
    @endif

    <x-table :items="$accounts" empty="Belum ada data akun.">
        <x-slot:header>
            <div class="relative w-full md:w-96">
                <i data-lucide="search" class="w-4 h-4 text-text-secondary absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input type="text" placeholder="Cari kode / nama akun..." class="w-full pl-10 pr-4 py-2 text-sm border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30">
            </div>
        </x-slot:header>

        <x-slot:head>
            <x-table.th>Kode</x-table.th>
            <x-table.th>Nama Akun</x-table.th>
            <x-table.th>Kategori</x-table.th>
            <x-table.th>Saldo Normal</x-table.th>
            <x-table.th>Induk</x-table.th>
            <x-table.th>Status</x-table.th>
            <x-table.th align="right">Aksi</x-table.th>
        </x-slot>

        @foreach ($accounts as $account)
            <tr class="hover:bg-slate-50 transition-colors">
                <x-table.td class="text-sm font-medium text-slate-700 font-mono">{{ $account->code }}</x-table.td>
                <x-table.td class="text-sm text-text-primary">
                    <div class="flex items-center gap-2">
                        @if($account->parent_id)
                            <span class="w-1 border-l-2 border-slate-300 h-4"></span>
                        @endif
                        {{ $account->name }}
                    </div>
                </x-table.td>
                <x-table.td class="text-sm text-slate-600">
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
                </x-table.td>
                <x-table.td class="text-sm text-slate-600">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $account->normal_balance === 'debit' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700' }}">
                        {{ ucfirst($account->normal_balance) }}
                    </span>
                </x-table.td>
                <x-table.td class="text-sm text-slate-600">{{ $account->parent?->name ?? '-' }}</x-table.td>
                <x-table.td>
                    <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full {{ $account->is_active ? 'bg-primary-light text-primary' : 'bg-slate-100 text-slate-600' }}">
                        {{ $account->is_active ? 'Aktif' : 'Non-Aktif' }}
                    </span>
                </x-table.td>
                <x-table.td align="right">
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
                </x-table.td>
            </tr>
        @endforeach
    </x-table>

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
                            <x-forms.label for="code" required>Kode Akun</x-forms.label>
                            <x-forms.input name="code" placeholder="1101" required />
                        </div>
                        <div>
                            <x-forms.label for="category" required>Kategori</x-forms.label>
                            <x-forms.select name="category" required>
                                <option value="">Pilih Kategori</option>
                                <option value="asset">Aset</option>
                                <option value="liability">Liabilitas</option>
                                <option value="equity">Ekuitas</option>
                                <option value="revenue">Pendapatan</option>
                                <option value="expense">Beban</option>
                            </x-forms.select>
                        </div>
                    </div>
                    <div>
                        <x-forms.label for="name" required>Nama Akun</x-forms.label>
                        <x-forms.input name="name" placeholder="Kas Perusahaan" required />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-forms.label for="normal_balance" required>Saldo Normal</x-forms.label>
                            <x-forms.select name="normal_balance" required>
                                <option value="debit">Debit</option>
                                <option value="credit">Kredit</option>
                            </x-forms.select>
                        </div>
                        <div>
                            <x-forms.label for="parent_id">Akun Induk</x-forms.label>
                            <x-forms.select name="parent_id">
                                <option value="">Tanpa Induk</option>
                                @foreach(\App\Models\Account::where('parent_id', null)->get() as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->code }} - {{ $parent->name }}</option>
                                @endforeach
                            </x-forms.select>
                        </div>
                    </div>
                    <div>
                        <x-forms.checkbox name="is_active" value="1" :checked="true">Aktif</x-forms.checkbox>
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
                            <x-forms.label for="edit-code" required>Kode Akun</x-forms.label>
                            <x-forms.input id="edit-code" name="code" required />
                        </div>
                        <div>
                            <x-forms.label for="edit-category" required>Kategori</x-forms.label>
                            <x-forms.select id="edit-category" name="category" required>
                                <option value="asset">Aset</option>
                                <option value="liability">Liabilitas</option>
                                <option value="equity">Ekuitas</option>
                                <option value="revenue">Pendapatan</option>
                                <option value="expense">Beban</option>
                            </x-forms.select>
                        </div>
                    </div>
                    <div>
                        <x-forms.label for="edit-name" required>Nama Akun</x-forms.label>
                        <x-forms.input id="edit-name" name="name" required />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-forms.label for="edit-normal" required>Saldo Normal</x-forms.label>
                            <x-forms.select id="edit-normal" name="normal_balance" required>
                                <option value="debit">Debit</option>
                                <option value="credit">Kredit</option>
                            </x-forms.select>
                        </div>
                        <div>
                            <x-forms.label for="edit-parent">Akun Induk</x-forms.label>
                            <x-forms.select id="edit-parent" name="parent_id">
                                <option value="">Tanpa Induk</option>
                            </x-forms.select>
                        </div>
                    </div>
                    <div>
                        <x-forms.checkbox id="edit-active" name="is_active" value="1">Aktif</x-forms.checkbox>
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

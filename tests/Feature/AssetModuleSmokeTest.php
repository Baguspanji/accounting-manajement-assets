<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\DepreciationMethod;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssetModuleSmokeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_asset_pages_load(): void
    {
        $user = User::firstOrFail();

        $routes = [
            'dashboard',
            'assets.index',
            'assets.create',
            'asset-categories.index',
            'asset-categories.create',
            'depreciation-methods.index',
            'depreciation-methods.create',
            'accounts.index',
            'documentation.index',
        ];

        foreach ($routes as $route) {
            $this->actingAs($user)->get(route($route))->assertOk();
        }

        $this->actingAs($user)->get(route('documentation.show', 1))->assertOk();
        $this->actingAs($user)->get(route('documentation.show', 999))->assertNotFound();
    }

    public function test_non_admin_user_is_blocked(): void
    {
        $staff = User::factory()->create(['role' => 'staff']);

        $this->actingAs($staff)->get(route('dashboard'))->assertForbidden();
        $this->actingAs($staff)->get(route('assets.index'))->assertForbidden();
        $this->actingAs($staff)->get(route('documentation.index'))->assertForbidden();
    }

    public function test_depreciation_method_crud(): void
    {
        $user = User::firstOrFail();

        $this->actingAs($user)->post(route('depreciation-methods.store'), [
            'name' => 'Metode Test',
            'code' => 'TEST',
            'formula' => '(Cost - Residual) / Useful Life',
            'description' => 'Metode uji coba.',
        ])->assertRedirect();

        $method = DepreciationMethod::where('code', 'TEST')->firstOrFail();
        $this->actingAs($user)->put(route('depreciation-methods.update', $method), [
            'name' => 'Garis Lurus',
            'code' => 'SL',
            'formula' => '(Cost - Residual) / Useful Life',
            'description' => 'Metode garis lurus.',
        ])->assertRedirect();
        $this->actingAs($user)->delete(route('depreciation-methods.destroy', $method))->assertRedirect();
    }

    public function test_asset_category_crud(): void
    {
        $user = User::firstOrFail();
        $assetAccount = Account::where('code', '1250')->firstOrFail();

        $this->actingAs($user)->post(route('asset-categories.store'), [
            'name' => 'Inventaris Kantor',
            'code' => 'INV',
            'asset_account_id' => $assetAccount->id,
            'depreciation_expense_account_id' => Account::where('code', '5100')->firstOrFail()->id,
            'accumulated_depreciation_account_id' => Account::where('code', '1290')->firstOrFail()->id,
            'default_useful_life' => 5,
            'default_residual_value' => 0,
            'description' => 'Kategori inventaris.',
        ])->assertRedirect();

        $category = AssetCategory::where('code', 'INV')->firstOrFail();
        $this->actingAs($user)->put(route('asset-categories.update', $category), [
            'name' => 'Inventaris Kantor',
            'code' => 'INV',
            'asset_account_id' => $assetAccount->id,
            'depreciation_expense_account_id' => Account::where('code', '5100')->firstOrFail()->id,
            'accumulated_depreciation_account_id' => Account::where('code', '1290')->firstOrFail()->id,
            'default_useful_life' => 5,
            'default_residual_value' => 0,
            'description' => 'Kategori inventaris.',
        ])->assertRedirect();
        $this->actingAs($user)->delete(route('asset-categories.destroy', $category))->assertRedirect();
    }

    public function test_asset_crud(): void
    {
        $user = User::firstOrFail();
        $category = AssetCategory::firstOrFail();
        $method = DepreciationMethod::firstOrFail();

        $payload = [
            'asset_number' => 'AST-TEST-001',
            'name' => 'Mesin Test',
            'category_id' => $category->id,
            'acquisition_date' => '2024-01-15',
            'acquisition_cost' => 50000000,
            'residual_value' => 5000000,
            'useful_life' => 10,
            'depreciation_method_id' => $method->id,
            'status' => 'active',
        ];

        $this->actingAs($user)->post(route('assets.store'), $payload)->assertRedirect();

        $asset = Asset::where('asset_number', 'AST-TEST-001')->firstOrFail();
        $payload['name'] = 'Mesin Test Updated';
        $this->actingAs($user)->put(route('assets.update', $asset), $payload)->assertRedirect();
        $this->actingAs($user)->delete(route('assets.destroy', $asset))->assertRedirect();
    }
}

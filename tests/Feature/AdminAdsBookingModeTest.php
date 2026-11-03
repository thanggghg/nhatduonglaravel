<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminAdsBookingModeTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_enable_and_disable_ads_booking_mode(): void
    {
        $admin = User::factory()->create();
        Role::create(['name' => 'admin']);
        $admin->assignRole('admin');

        $this->actingAs($admin)
            ->patch(route('admin.dashboard.ads-booking-mode'), ['ads_booking_mode' => '1'])
            ->assertRedirect();

        $this->assertTrue(Setting::adsBookingMode());

        $this->actingAs($admin)
            ->patch(route('admin.dashboard.ads-booking-mode'), ['ads_booking_mode' => '0'])
            ->assertRedirect();

        $this->assertFalse(Setting::adsBookingMode());
    }

    public function test_guest_cannot_change_ads_booking_mode(): void
    {
        $this->patch(route('admin.dashboard.ads-booking-mode'), ['ads_booking_mode' => '1'])
            ->assertRedirect(route('admin.login'));

        $this->assertFalse(Setting::adsBookingMode());
    }
}

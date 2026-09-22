<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const OLD_NAME = 'Bến xe Miền Đông';

    private const OLD_ADDRESS = '292 Đinh Bộ Lĩnh, P.26, Q.Bình Thạnh, TP.HCM';

    private const NEW_NAME = 'VPSG';

    private const NEW_ADDRESS = '99 Nguyễn Cư Trinh, Quận 1';

    public function up(): void
    {
        DB::table('pickup_points')
            ->where('name', self::OLD_NAME)
            ->where('address', self::OLD_ADDRESS)
            ->update([
                'name' => self::NEW_NAME,
                'address' => self::NEW_ADDRESS,
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('pickup_points')
            ->where('name', self::NEW_NAME)
            ->where('address', self::NEW_ADDRESS)
            ->update([
                'name' => self::OLD_NAME,
                'address' => self::OLD_ADDRESS,
                'updated_at' => now(),
            ]);
    }
};

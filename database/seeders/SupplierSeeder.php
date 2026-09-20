<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'PT. Indofood Sukses Makmur Tbk',
                'phone' => '021-5795-8822',
                'address' => 'Sudirman Plaza, Indofood Tower, Jl. Jend. Sudirman Kav. 76-78, Jakarta Selatan',
            ],
            [
                'name' => 'PT. Unilever Indonesia Tbk',
                'phone' => '021-8082-7000',
                'address' => 'Grha Unilever, BSD Green Office Park Kav. 3, Tangerang, Banten',
            ],
            [
                'name' => 'PT. Mayora Indah Tbk',
                'phone' => '021-5655-3333',
                'address' => 'Gedung Mayora, Jl. Tomang Raya No. 21-23, Jakarta Barat',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
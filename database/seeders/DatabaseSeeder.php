<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOut;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ============================================================
        // 1. Create Administrator User
        // ============================================================
        $admin = User::firstOrCreate(
            ['email' => 'admin@wms.co.id'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('password123'),
            ]
        );

        // ============================================================
        // 2. Create Sample Categories
        // ============================================================
        $categories = [
            ['name' => 'Alat Pelindung Diri', 'description' => 'Peralatan keselamatan dan perlindungan diri di area kerja'],
            ['name' => 'Peralatan Tangan',   'description' => 'Alat-alat yang dioperasikan secara manual'],
            ['name' => 'Elektronik & Listrik','description' => 'Komponen elektronik, kabel, dan peralatan listrik'],
            ['name' => 'Bahan Kimia',         'description' => 'Larutan pembersih, pelumas, dan bahan kimia industri'],
            ['name' => 'Kemasan & Packing',   'description' => 'Kotak, plastik wrap, bubble wrap, dan bahan kemasan'],
        ];

        $createdCategories = [];
        foreach ($categories as $cat) {
            $createdCategories[] = Category::create($cat);
        }

        // ============================================================
        // 3. Create Sample Products
        // ============================================================
        $products = [
            // APD
            ['code' => 'APD-001', 'name' => 'Helm Proyek Safety', 'category_id' => $createdCategories[0]->id, 'unit' => 'Pcs', 'rack_location' => 'A-1', 'current_stock' => 45, 'minimum_stock' => 20, 'description' => 'Helm keselamatan standar SNI, warna oranye'],
            ['code' => 'APD-002', 'name' => 'Sepatu Safety Krisbow', 'category_id' => $createdCategories[0]->id, 'unit' => 'Pasang', 'rack_location' => 'A-2', 'current_stock' => 8, 'minimum_stock' => 10, 'description' => 'Sepatu safety dengan pelindung besi'],
            ['code' => 'APD-003', 'name' => 'Sarung Tangan Kulit', 'category_id' => $createdCategories[0]->id, 'unit' => 'Pasang', 'rack_location' => 'A-3', 'current_stock' => 0, 'minimum_stock' => 15, 'description' => 'Sarung tangan kulit tebal anti-panas'],
            ['code' => 'APD-004', 'name' => 'Masker N95', 'category_id' => $createdCategories[0]->id, 'unit' => 'Box', 'rack_location' => 'A-4', 'current_stock' => 22, 'minimum_stock' => 10, 'description' => 'Masker respirator N95, isi 20pcs/box'],
            // Peralatan Tangan
            ['code' => 'PAT-001', 'name' => 'Kunci Pas Set 12pcs', 'category_id' => $createdCategories[1]->id, 'unit' => 'Set', 'rack_location' => 'B-1', 'current_stock' => 15, 'minimum_stock' => 5, 'description' => 'Set kunci pas 8mm–24mm'],
            ['code' => 'PAT-002', 'name' => 'Obeng Phillips #2', 'category_id' => $createdCategories[1]->id, 'unit' => 'Pcs', 'rack_location' => 'B-2', 'current_stock' => 30, 'minimum_stock' => 10, 'description' => 'Obeng plus ukuran 2'],
            ['code' => 'PAT-003', 'name' => 'Tang Kombinasi 8"', 'category_id' => $createdCategories[1]->id, 'unit' => 'Pcs', 'rack_location' => 'B-3', 'current_stock' => 12, 'minimum_stock' => 5, 'description' => 'Tang kombinasi gagang berisolasi'],
            // Elektronik
            ['code' => 'ELK-001', 'name' => 'Kabel NYA 2.5mm (100m)', 'category_id' => $createdCategories[2]->id, 'unit' => 'Roll', 'rack_location' => 'C-1', 'current_stock' => 5, 'minimum_stock' => 3, 'description' => 'Kabel listrik NYA 2.5mm warna merah'],
            ['code' => 'ELK-002', 'name' => 'MCB 16A 1 Phase', 'category_id' => $createdCategories[2]->id, 'unit' => 'Pcs', 'rack_location' => 'C-2', 'current_stock' => 18, 'minimum_stock' => 10, 'description' => 'MCB Schneider 16A 1 phase'],
            // Bahan Kimia
            ['code' => 'KIM-001', 'name' => 'Oli Pelumas ISO VG 46', 'category_id' => $createdCategories[3]->id, 'unit' => 'Liter', 'rack_location' => 'D-1', 'current_stock' => 50, 'minimum_stock' => 20, 'description' => 'Oli pelumas mesin industri'],
            ['code' => 'KIM-002', 'name' => 'Cairan Pembersih Lantai', 'category_id' => $createdCategories[3]->id, 'unit' => 'Jerigen', 'rack_location' => 'D-2', 'current_stock' => 3, 'minimum_stock' => 5, 'description' => 'Cairan pembersih lantai 5 liter'],
            // Kemasan
            ['code' => 'PKG-001', 'name' => 'Bubble Wrap 1m x 50m', 'category_id' => $createdCategories[4]->id, 'unit' => 'Roll', 'rack_location' => 'E-1', 'current_stock' => 8, 'minimum_stock' => 5, 'description' => 'Bubble wrap anti-pecah 1mx50m'],
            ['code' => 'PKG-002', 'name' => 'Karton Box 30x30x30cm', 'category_id' => $createdCategories[4]->id, 'unit' => 'Pcs', 'rack_location' => 'E-2', 'current_stock' => 120, 'minimum_stock' => 50, 'description' => 'Karton box ukuran 30x30x30cm'],
        ];

        $createdProducts = [];
        foreach ($products as $prod) {
            $createdProducts[] = Product::create($prod);
        }

        // ============================================================
        // 4. Create Sample Stock In Transactions (last 6 months)
        // ============================================================
        $stockIns = [
            ['product' => $createdProducts[0], 'qty' => 20, 'supplier' => 'PT. Safety Abadi', 'months_ago' => 5],
            ['product' => $createdProducts[3], 'qty' => 30, 'supplier' => 'CV. Medika Jaya', 'months_ago' => 5],
            ['product' => $createdProducts[4], 'qty' => 10, 'supplier' => 'Toko Teknik Maju', 'months_ago' => 4],
            ['product' => $createdProducts[5], 'qty' => 20, 'supplier' => 'Toko Teknik Maju', 'months_ago' => 4],
            ['product' => $createdProducts[9], 'qty' => 50, 'supplier' => 'PT. Pelumas Nusantara', 'months_ago' => 3],
            ['product' => $createdProducts[0], 'qty' => 25, 'supplier' => 'PT. Safety Abadi', 'months_ago' => 3],
            ['product' => $createdProducts[1], 'qty' => 15, 'supplier' => 'CV. Krisbow Distributor', 'months_ago' => 2],
            ['product' => $createdProducts[7], 'qty' => 10, 'supplier' => 'PT. Cahaya Listrik', 'months_ago' => 2],
            ['product' => $createdProducts[11], 'qty' => 5, 'supplier' => 'CV. Kemasan Mandiri', 'months_ago' => 1],
            ['product' => $createdProducts[12], 'qty' => 100, 'supplier' => 'CV. Kemasan Mandiri', 'months_ago' => 1],
            ['product' => $createdProducts[3], 'qty' => 15, 'supplier' => 'CV. Medika Jaya', 'months_ago' => 0],
            ['product' => $createdProducts[8], 'qty' => 20, 'supplier' => 'PT. Cahaya Listrik', 'months_ago' => 0],
        ];

        foreach ($stockIns as $i => $trx) {
            $date = Carbon::now()->subMonths($trx['months_ago'])->subDays(rand(0, 15));
            StockIn::create([
                'transaction_number' => 'TRX-IN-' . $date->format('Ymd') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'product_id' => $trx['product']->id,
                'quantity' => $trx['qty'],
                'supplier' => $trx['supplier'],
                'date' => $date->toDateString(),
                'description' => 'Pengadaan barang rutin',
            ]);
        }

        // ============================================================
        // 5. Create Sample Stock Out Transactions (last 6 months)
        // ============================================================
        $stockOuts = [
            ['product' => $createdProducts[0], 'qty' => 5, 'receiver' => 'Divisi Produksi A', 'purpose' => 'Kebutuhan proyek pabrik', 'months_ago' => 4],
            ['product' => $createdProducts[5], 'qty' => 8, 'receiver' => 'Teknisi Gedung', 'purpose' => 'Perbaikan jalur listrik', 'months_ago' => 4],
            ['product' => $createdProducts[9], 'qty' => 10, 'receiver' => 'Tim Maintenance', 'purpose' => 'Perawatan mesin bulanan', 'months_ago' => 3],
            ['product' => $createdProducts[4], 'qty' => 2, 'receiver' => 'Divisi Instalasi', 'purpose' => 'Instalasi mesin baru', 'months_ago' => 3],
            ['product' => $createdProducts[3], 'qty' => 5, 'receiver' => 'Pak Budi – Kepala Shift', 'purpose' => 'Distribusi APD harian', 'months_ago' => 2],
            ['product' => $createdProducts[6], 'qty' => 3, 'receiver' => 'Teknisi Lapangan', 'purpose' => 'Perbaikan pipa', 'months_ago' => 2],
            ['product' => $createdProducts[12], 'qty' => 30, 'receiver' => 'Departemen Shipping', 'purpose' => 'Pengemasan produk ekspor', 'months_ago' => 1],
            ['product' => $createdProducts[0], 'qty' => 10, 'receiver' => 'Divisi Konstruksi', 'purpose' => 'Proyek renovasi pabrik', 'months_ago' => 0],
            ['product' => $createdProducts[9], 'qty' => 15, 'receiver' => 'Tim Maintenance', 'purpose' => 'Ganti oli mesin Q4', 'months_ago' => 0],
        ];

        foreach ($stockOuts as $i => $trx) {
            // Only create if product has enough stock
            $product = Product::find($trx['product']->id);
            if ($product->current_stock >= $trx['qty']) {
                $date = Carbon::now()->subMonths($trx['months_ago'])->subDays(rand(0, 10));
                StockOut::create([
                    'transaction_number' => 'TRX-OUT-' . $date->format('Ymd') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                    'product_id' => $trx['product']->id,
                    'quantity' => $trx['qty'],
                    'receiver' => $trx['receiver'],
                    'purpose' => $trx['purpose'],
                    'date' => $date->toDateString(),
                ]);
            }
        }

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('📧 Admin Login: admin@wms.co.id | Password: password123');
    }
}

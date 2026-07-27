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
            ['email' => 'apoteker@ams.co.id'],
            [
                'name'     => 'Apoteker Utama',
                'password' => Hash::make('password123'),
            ]
        );

        // ============================================================
        // 2. Create Sample Categories
        // ============================================================
        $categories = [
            ['name' => 'Obat Bebas', 'description' => 'Obat yang dapat dibeli tanpa resep dokter'],
            ['name' => 'Obat Keras', 'description' => 'Obat yang harus dibeli dengan resep dokter'],
            ['name' => 'Vitamin & Suplemen', 'description' => 'Vitamin, mineral, dan suplemen kesehatan'],
            ['name' => 'Alat Kesehatan', 'description' => 'Peralatan medis dan alat bantu kesehatan'],
            ['name' => 'Perawatan Tubuh', 'description' => 'Produk perawatan kulit, rambut, dan kebersihan diri'],
        ];

        $createdCategories = [];
        foreach ($categories as $cat) {
            $createdCategories[] = Category::create($cat);
        }

        // ============================================================
        // 3. Create Sample Products
        // ============================================================
        $products = [
            // Obat Bebas
            ['code' => 'OBA-001', 'name' => 'Paracetamol 500mg', 'category_id' => $createdCategories[0]->id, 'unit' => 'Strip', 'rack_location' => 'A-1', 'current_stock' => 150, 'minimum_stock' => 50, 'description' => 'Obat penurun panas dan pereda nyeri'],
            ['code' => 'OBA-002', 'name' => 'Antasida Doen', 'category_id' => $createdCategories[0]->id, 'unit' => 'Strip', 'rack_location' => 'A-2', 'current_stock' => 80, 'minimum_stock' => 30, 'description' => 'Obat maag dan asam lambung'],
            ['code' => 'OBA-003', 'name' => 'OBH Combi Plus', 'category_id' => $createdCategories[0]->id, 'unit' => 'Botol', 'rack_location' => 'A-3', 'current_stock' => 0, 'minimum_stock' => 15, 'description' => 'Obat batuk berdahak dan flu'],
            ['code' => 'OBA-004', 'name' => 'Promag Tablet', 'category_id' => $createdCategories[0]->id, 'unit' => 'Box', 'rack_location' => 'A-4', 'current_stock' => 45, 'minimum_stock' => 20, 'description' => 'Obat sakit maag'],
            // Obat Keras
            ['code' => 'OBK-001', 'name' => 'Amoxicillin 500mg', 'category_id' => $createdCategories[1]->id, 'unit' => 'Strip', 'rack_location' => 'B-1', 'current_stock' => 120, 'minimum_stock' => 40, 'description' => 'Antibiotik (Harus dengan resep dokter)'],
            ['code' => 'OBK-002', 'name' => 'Captopril 25mg', 'category_id' => $createdCategories[1]->id, 'unit' => 'Strip', 'rack_location' => 'B-2', 'current_stock' => 60, 'minimum_stock' => 20, 'description' => 'Obat penurun tekanan darah tinggi'],
            ['code' => 'OBK-003', 'name' => 'Metformin 500mg', 'category_id' => $createdCategories[1]->id, 'unit' => 'Strip', 'rack_location' => 'B-3', 'current_stock' => 90, 'minimum_stock' => 30, 'description' => 'Obat diabetes tipe 2'],
            // Vitamin & Suplemen
            ['code' => 'VIT-001', 'name' => 'Enervon-C Multivitamin', 'category_id' => $createdCategories[2]->id, 'unit' => 'Botol', 'rack_location' => 'C-1', 'current_stock' => 35, 'minimum_stock' => 15, 'description' => 'Suplemen vitamin C dan B kompleks'],
            ['code' => 'VIT-002', 'name' => 'Imboost Force', 'category_id' => $createdCategories[2]->id, 'unit' => 'Strip', 'rack_location' => 'C-2', 'current_stock' => 50, 'minimum_stock' => 20, 'description' => 'Suplemen daya tahan tubuh'],
            // Alat Kesehatan
            ['code' => 'ALK-001', 'name' => 'Termometer Digital Omron', 'category_id' => $createdCategories[3]->id, 'unit' => 'Pcs', 'rack_location' => 'D-1', 'current_stock' => 12, 'minimum_stock' => 5, 'description' => 'Alat pengukur suhu tubuh digital'],
            ['code' => 'ALK-002', 'name' => 'Masker Medis 3-Ply', 'category_id' => $createdCategories[3]->id, 'unit' => 'Box', 'rack_location' => 'D-2', 'current_stock' => 8, 'minimum_stock' => 10, 'description' => 'Masker bedah isi 50 pcs'],
            // Perawatan Tubuh
            ['code' => 'PRW-001', 'name' => 'Betadine Antiseptik 30ml', 'category_id' => $createdCategories[4]->id, 'unit' => 'Botol', 'rack_location' => 'E-1', 'current_stock' => 25, 'minimum_stock' => 10, 'description' => 'Cairan antiseptik untuk luka'],
            ['code' => 'PRW-002', 'name' => 'Minyak Kayu Putih Cap Lang 60ml', 'category_id' => $createdCategories[4]->id, 'unit' => 'Botol', 'rack_location' => 'E-2', 'current_stock' => 40, 'minimum_stock' => 15, 'description' => 'Minyak gosok untuk menghangatkan badan'],
        ];

        $createdProducts = [];
        foreach ($products as $prod) {
            $createdProducts[] = Product::create($prod);
        }

        // ============================================================
        // 4. Create Sample Stock In Transactions (last 6 months)
        // ============================================================
        $stockIns = [];
        $suppliers = ['PBF Kimia Farma', 'PBF Kalbe Farma', 'PBF Dexa Medica', 'PBF Sanbe Farma', 'PT. Alkes Indo', 'PBF Darya Varia', 'PBF Mahakam Beta', 'PBF Eagle Indo', 'PBF Soho Global'];
        
        // Generate 150 random stock in transactions over the last 180 days
        for ($i = 0; $i < 150; $i++) {
            $product = $createdProducts[array_rand($createdProducts)];
            $daysAgo = rand(0, 180);
            $date = Carbon::now()->subDays($daysAgo);
            
            $stockIns[] = [
                'transaction_number' => 'TRX-IN-' . $date->format('Ymd') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'product_id' => $product->id,
                'quantity' => rand(10, 100),
                'supplier' => $suppliers[array_rand($suppliers)],
                'date' => $date->toDateString(),
                'description' => 'Penerimaan obat rutin',
            ];
        }

        foreach ($stockIns as $trx) {
            StockIn::create($trx);
        }

        // ============================================================
        // 5. Create Sample Stock Out Transactions (last 6 months)
        // ============================================================
        $stockOuts = [];
        $receivers = ['Pasien Umum', 'Pasien Resep', 'Klinik Sehat', 'Puskesmas Pembantu', 'Dokter Praktek'];
        $purposes = ['Penjualan bebas', 'Resep dokter', 'Distribusi cabang', 'Kebutuhan internal'];

        // Generate 300 random stock out transactions over the last 180 days
        for ($i = 0; $i < 300; $i++) {
            $product = $createdProducts[array_rand($createdProducts)];
            $daysAgo = rand(0, 180);
            $date = Carbon::now()->subDays($daysAgo);
            
            $stockOuts[] = [
                'transaction_number' => 'TRX-OUT-' . $date->format('Ymd') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'product_id' => $product->id,
                'quantity' => rand(1, 15),
                'receiver' => $receivers[array_rand($receivers)],
                'purpose' => $purposes[array_rand($purposes)],
                'date' => $date->toDateString(),
            ];
        }

        foreach ($stockOuts as $trx) {
            StockOut::create($trx);
        }

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('📧 Admin Login: apoteker@ams.co.id | Password: password123');
    }
}

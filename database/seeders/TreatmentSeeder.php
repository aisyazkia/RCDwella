<?php

namespace Database\Seeders;

use App\Models\Treatment;
use Illuminate\Database\Seeder;

class TreatmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Treatment::insert([
            [
                'id' => 1,
                'name' => 'Facial Acne Comedo',
                'description' => 'Mengenyalkan dan mengencangkan kulit wajah.',
                'price' => 100000,
            ],
            [
                'id' => 2,
                'name' => 'Facial Detoks',
                'description' => 'Membuang racun sisa metabolisme, mercury, radikal bebas.',
                'price' => 110000,
            ],
            [
                'id' => 3,
                'name' => 'Facial Messo Glow',
                'description' => 'pencerah, pemutih, dan penghilang flek',
                'price' => 150000,
            ],
            [
                'id' => 4,
                'name' => 'Facial RF',
                'description' => 'Menghilangkan garis halus dan kerutan, memutihkan kulit wajah, menghilangkan pori" besar, mengembalikan elasitas dan kehalusan kulit wajah.',
                'price' => 150000,
            ],
            [
                'id' => 5,
                'name' => 'Facial Ultrawhite',
                'description' => 'Untuk mencerahkan wajah.',
                'price' => 100000,
            ],
            [
                'id' => 6,
                'name' => 'Facial Peeling Acne',
                'description' => 'membuang sisa-sisa kulit mati, meremajakan kulit, mengatasi jerawat dan komedo.',
                'price' => 150000,
            ],
            [
                'id' => 7,
                'name' => 'Facial Peeling Flek',
                'description' => 'mengangkat sel kulit mati, mencerahkan wajah, memudarkan flek pada wajah',
                'price' => 150000,
            ],
            [
                'id' => 9,
                'name' => 'Facial Microdermabrasi',
                'description' => 'Mengikis sel kulit mati, mencerahkan dan meremajakan kulit wajah.',
                'price' => 125000,
            ],
            [
                'id' => 10,
                'name' => 'Facial Korean Brightening',
                'description' => 'menghilangkan kotoran yang menumpuk di wajah sekaligus mencerahkan kulit dengan menggunakan formula herbal khusus Korea yang dikombinasikan racikan Dermis Dermatologist',
                'price' => 300000,
            ],
            [
                'id' => 11,
                'name' => 'Facial Glasskin',
                'description' => 'Menghaluskan kulit, mengencangkan kulit serta mengecilkan pori-pori',
                'price' => 300000,
            ],
            [
                'id' => 12,
                'name' => 'Facial IPL',
                'description' => 'menghilangkan noda hitam diwajah, mencegah keriput, merontokkan bulu, merawat bekas luka dan mengatasi jerawat',
                'price' => 200000,
            ],
            [
                'id' => 13,
                'name' => 'Facial Photo Laser',
                'description' => 'membersihkan kulit, memperkecil kelenjar minyak, merangsang produksi kolagen, mengurangi pigmentasi, mengurangi penymbatan pada pori-pori',
                'price' => 200000,
            ],
            [
                'id' => 14,
                'name' => 'Fasial Masker PDT',
                'description' => 'mencerahkan wajah, menghilangkan flek bekas jerawat, menghaluskan pori-pori, mengatasi jerawat, mengurangi kadar minyak pada wajah',
                'price' => 100000,
            ],
            [
                'id' => 15,
                'name' => 'Masker PDT',
                'description' => 'Memutihkan, menghilangkan jerawat, menghilangkan dan mencegah keriput & urat halus diwajah.',
                'price' => 50000,
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChambreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ([
            ['unite'=>'Unité 2: Prof KAKOU AKA RIGOBERT / REANIMATION', 'nom'=>'Box 1', 'nbr_place'=>1],
            ['unite'=>'Unité 2: Prof KAKOU AKA RIGOBERT / REANIMATION', 'nom'=>'Box 2', 'nbr_place'=>1],
            ['unite'=>'Unité 2: Prof KAKOU AKA RIGOBERT / REANIMATION', 'nom'=>'Box 3', 'nbr_place'=>1],
            ['unite'=>'Unité 2: Prof KAKOU AKA RIGOBERT / REANIMATION', 'nom'=>'Box 4', 'nbr_place'=>1],
            ['unite'=>'Unité 2: Prof KAKOU AKA RIGOBERT / REANIMATION', 'nom'=>'Box 5', 'nbr_place'=>1],
            ['unite'=>'Unité 2: Prof KAKOU AKA RIGOBERT / REANIMATION', 'nom'=>'Ch16', 'nbr_place'=>1],
            ['unite'=>'Unité 2: Prof KAKOU AKA RIGOBERT / REANIMATION', 'nom'=>'Ch17', 'nbr_place'=>1],
            ['unite'=>'Unité 2: Prof KAKOU AKA RIGOBERT / REANIMATION', 'nom'=>'Ch18', 'nbr_place'=>1],
            ['unite'=>'Unité 2: Prof KAKOU AKA RIGOBERT / REANIMATION', 'nom'=>'Ch19', 'nbr_place'=>1],
            ['unite'=>'Unité 2: Prof KAKOU AKA RIGOBERT / REANIMATION', 'nom'=>'Ch20', 'nbr_place'=>1],
            ['unite'=>'Unité 2: Prof KAKOU AKA RIGOBERT / REANIMATION', 'nom'=>'Ch21', 'nbr_place'=>1],
                 ] as $lit){
            DB::table('chambre_lits')->insert($lit);
        }
    }
}

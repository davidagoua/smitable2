<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = ["Général","Tuberculose",'VIH/SIDA','Urgence','COVID-19','Lèpre'];

        foreach ($services as $s){
            DB::table('service')->insert(['nom'=>$s, 'label'=>'fe-aperture']);
        }
    }
}

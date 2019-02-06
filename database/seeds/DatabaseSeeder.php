<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
//use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // Este é o método executado quando executamos -> php artisan db:seed
    public function run()
    {
        // Este comando "desabilita" a proteção do método fill($data = []); nos models
        Model::unguard();
        // Desabilitas as FKs
//        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Impede que seed seja executado em ambiente de produção
        if(!app()->environment('production')):
            $this->call(MaritalStatusTableSeeder::class);
            $this->call(SchoolingsTableSeeder::class);
            $this->call(GendersTableSeeder::class);
            $this->call(ProfessionsTableSeeder::class);
            $this->call(UsersTableSeeder::class);
//            $this->call(PostsTableSeeder::class);
            $this->call(StatesTableSeeder::class);
            $this->call(CitiesTableSeeder::class);
            $this->call(TrustsTableSeeder::class);
            $this->call(DepartmentsTableSeeder::class);
        endif;

        if(app()->environment('production')):
            // seeds especiais para o ambiente de produção
        endif;

        // Habilitas as FKs
//        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}

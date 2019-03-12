<?php

use Illuminate\Database\Seeder;

class PmUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\PmUser::class, 5)->create(['user_type' => 'employer', 'roles' => 'employer'])->each(function ($user){
            $user->employer()->save(factory(App\Models\Employer::class)->make());
        });
        
        factory(App\Models\PmUser::class, 5)->create()->each(function ($user) {
            factory(App\Models\Candidate::class)->create(['user_id' => $user->id]);
        });
    }
}

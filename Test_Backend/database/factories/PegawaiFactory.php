<?php

namespace Database\Factories;

use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;

class PegawaiFactory extends Factory
{
    protected $model = Pegawai::class;

    public function definition()
    {
        return [
            'nama' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'alamat' => $this->faker->address(),
            'notlpn' => $this->faker->phoneNumber()
        ];
    }
}

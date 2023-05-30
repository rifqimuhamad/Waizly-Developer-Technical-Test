<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Pegawai;
use App\Models\User;



class PegawaiTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStore()
    {   
        $user = User::factory()->create();
        $token = $user->createToken('api-test-token')->plainTextToken;
        $data = [
            'nama' => 'Muhamad Rifqi',
            'email' => 'gmail@muhamadrifqi.com',
            'alamat' => 'jl.komp uka bloc cb 6a',
            'notlpn' => '08123456789'
        ];

        $response = $this->withToken($token)->json('POST', '/api/pegawai', $data);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data'
            ])->assertJsonPath('success', true)
            ->assertJsonPath('message', 'Pegawai berhasil ditambahkan')
            ->assertJsonPath('data.nama', $data['nama'])
            ->assertJsonPath('data.email', $data['email'])
            ->assertJsonPath('data.alamat', $data['alamat'])
            ->assertJsonPath('data.notlpn', $data['notlpn']);
    }
    public function testIndex()
    {
        $user = User::factory()->create();     
        $token = $user->createToken('api-test-token')->plainTextToken;     
        $pegawai = Pegawai::factory()->count(5)->create();
        $response = $this->withToken($token)->getJson('/api/pegawai');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'id',
                            'nama',
                            'email',
                            'alamat',
                            'notlpn'
                        ]
                    ]
                 ]);
    }
    
    public function testUpdate()
    {
        $user = User::factory()->create();
        $token = $user->createToken('api-test-token')->plainTextToken;
        $pegawai = Pegawai::factory()->create();
        $updatedData = [
            'nama' => 'Nama Baru',
            'email' => 'emailbaru@example.com',
            'alamat' => 'Alamat baru, Jalan Baru',
            'notlpn' => '1234567890',
        ];

        $response = $this->withToken($token)->putJson("/api/pegawai/{$pegawai->id}", $updatedData);
        $response->assertStatus(200)
                ->assertJson(['success' => true, 'message' => 'Data pegawai berhasil diupdate']);

        $pegawai->refresh();
        $this->assertEquals($updatedData['nama'], $pegawai->nama);
        $this->assertEquals($updatedData['email'], $pegawai->email);
        $this->assertEquals($updatedData['alamat'], $pegawai->alamat);
        $this->assertEquals($updatedData['notlpn'], $pegawai->notlpn);
    }

    public function testShow()
    {
        $user = User::factory()->create();
        $token = $user->createToken('api-test-token')->plainTextToken;
        $pegawai = Pegawai::factory()->create();
        $response = $this->withToken($token)->getJson("/api/pegawai/{$pegawai->id}");
        $response->assertStatus(200)
                ->assertJsonStructure([
                    'pegawai' => [
                        'id',
                        'nama',
                        'email',
                        'alamat',
                        'notlpn',
                        'created_at',
                        'updated_at'
                    ]
                ]);

        $responseNotFound = $this->withToken($token)->getJson("/api/pegawai/10"); 
        $responseNotFound->assertStatus(404)
                        ->assertJson(['message' => 'Pegawai tidak ditemukan.']);
    }
    public function testDestroy()
    {
        $user = User::factory()->create();
        $token = $user->createToken('api-test-token')->plainTextToken;
        $pegawai = Pegawai::factory()->create();
        $id = $pegawai->id;
        $response = $this->withToken($token)->deleteJson("/api/pegawai/{$pegawai->id}");
        $response->assertStatus(200)
                ->assertJson(['success' => true, 'message' => 'Pegawai berhasil dihapus']);

        $this->assertNull(Pegawai::find($id));
        $responseNotFound = $this->withToken($token)->deleteJson("/api/pegawai/10");
        $responseNotFound->assertStatus(500)
                        ->assertJson(['success' => false, 'message' => 'Gagal menghapus data pegawai']);
    }

}

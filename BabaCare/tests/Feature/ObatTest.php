<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Obat;

class ObatTest extends TestCase
{
    use RefreshDatabase;

    public function test_bisa_melihat_halaman_obat()
    {
        $response = $this->get('/obats');

        $response->assertStatus(200);
        $response->assertSee('Data Obat'); // sesuaikan dengan tampilan di view
    }

    public function test_bisa_menambah_obat_baru()
    {
        $this->withoutMiddleware(); // lewati middleware seperti CSRF

        $data = [
            'nama_obat' => 'Paracetamol',
            'kategori' => 'Ringan',
            'golongan' => 'tablet',
        ];

        $response = $this->post('/obats', $data);

        $response->assertRedirect('/obats');
        $this->assertDatabaseHas('obats', $data);
    }

    public function test_bisa_edit_data_obat()
    {
        $this->withoutMiddleware();

        $obat = Obat::create([
            'nama_obat' => 'Paracetamol',
            'kategori' => 'Ringan',
            'golongan' => 'tablet',
        ]);

        $updatedData = [
            'nama_obat' => 'Paracetamol Updated',
            'kategori' => 'Sedang',
            'golongan' => 'sirup',
        ];

        $response = $this->put("/obats/{$obat->id}", $updatedData);

        $response->assertRedirect('/obats');
        $this->assertDatabaseHas('obats', $updatedData);
    }

    public function test_bisa_hapus_obat()
    {
        $this->withoutMiddleware();

        $obat = Obat::create([
            'nama_obat' => 'Paracetamol',
            'kategori' => 'Ringan',
            'golongan' => 'tablet',
        ]);

        $response = $this->delete("/obats/{$obat->id}");

        $response->assertRedirect('/obats');
        $this->assertDatabaseMissing('obats', ['id' => $obat->id]);
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;

class FrontendRoutesTest extends TestCase
{
    public function test_dashboard_page_loads_successfully(): void
    {
        $response = $this->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('CollabQuest');
        $response->assertSee('Total Tugas');
    }

    public function test_login_page_loads_successfully(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Masuk ke Akun');
        $response->assertSee('Alamat Email');
    }

    public function test_register_page_loads_successfully(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Registrasi Pengguna');
        $response->assertSee('Nama Lengkap');
    }
}

<?php

namespace Tests\Feature\Admin\Doctors;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class DoctorsModuleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function test_load_doctors_list()
    {
        factory(User::class)->create([
            'name' => 'Joel',
            'doctor' => true,
        ]);

        factory(User::class)->create([
            'name' => 'Ellie',
            'doctor' => true,
        ]);

        $this->actingAsAdmin()
            ->get('/admin/doctors')
        	->assertStatus(200)
        	->assertSee('Listado de doctores')
            ->assertSee('Joel')
            ->assertSee('Ellie');
    }

    /**
     * @test
     */
    public function test_load_doctors_detail()
    {
        $doctor = factory(User::class)->create([
            'name' => 'Doctor',
            'doctor' => true,
        ]);

        $this->actingAsAdmin()
            ->get('/admin/doctors/'.$doctor->id)
        	->assertStatus(200)
        	->assertSee('Doctor');
    }

    /**
     * @test
     */
    public function test_load_doctors_new()
    {
        $this->actingAsAdmin()
            ->get('/admin/doctors/create')
        	->assertStatus(200)
        	->assertSee('Creando nuevo doctor.');
    }

    /**
     * @test
     */
    public function test_load_doctors_edit()
    {
        $this->actingAsAdmin()
            ->get('/admin/doctors/5/edit')
        	->assertStatus(200)
        	->assertSee('Editando doctor: 5');
    }

    /**
     * @test
     */
    public function test_load_doctors_edit_fail()
    {
        $this->actingAsAdmin()
            ->get('/admin/doctors/texto/edit')
        	->assertStatus(404);
    }

    /**
     * @test
     */
    public function test_show_404_error_doctor_not_found()
    {
        $this->actingAsAdmin()
            ->get('/admin/doctors/999999')
            ->assertStatus(404)
            ->assertSee('Página no encontrada');
    }

    /**
     * @test
     */
    public function test_create_new_user()
    {
        $this->actingAsAdmin()
            ->post('admin/doctors/', [
           'name' => 'Made2',
           'surname' => 'Zamora',
           'email' => 'made2@made.com',
           'password' => '123456',
           'phone' => '+34655655655',
           'doctor' => true,
        ])->assertRedirect(route('admin_doctors'));

        $this->assertDatabaseHas('users', [
            'name' => 'Made2',
            'surname' => 'Zamora',
            'email' => 'made2@made.com',
            'phone' => '+34655655655',
            'doctor' => true,
        ]);
    }

    /**
     * @test
     */
    public function test_name_is_required()
    {
        $users_count = User::count();

        $this->actingAsAdmin()
            ->from('admin/doctors/create')
            ->post('admin/doctors', [
                'email' => 'antonio22@antonio.com',
                'password' => '123456'
            ])->assertRedirect(route('admin_create_doctors'))
                ->assertSessionHasErrors(['name' => 'Debe introducir un nombre']);

        $this->assertEquals($users_count, User::count());

    }

    /**
     * @test
     */
    public function test_email_is_required()
    {
        $old_user_count = User::count();

        $this->actingAsAdmin()
            ->from('admin/doctors/create')
            ->post('admin/doctors', [
                'name' => 'Antonio',
                'password' => '123456'
            ])->assertRedirect(route('admin_create_doctors'))
                ->assertSessionHasErrors(['email' => 'Debe introducir un email']);

        $this->assertEquals($old_user_count, User::count());
    }

    /**
     * @test
     */
    public function test_password_is_required()
    {
        $old_user_count = User::count();

        $this->actingAsAdmin()
            ->from('admin/doctors/create')
            ->post('admin/doctors', [
                'name' => 'Antonio',
                'email' => 'antonio@antonio.com'
            ])->assertRedirect(route('admin_create_doctors'))
                ->assertSessionHasErrors(['password']);

        $this->assertEquals($old_user_count, User::count());
    }

    /**
     * @test
     */
    public function test_email_is_invalid()
    {
        $old_user_count = User::count();

        $this->actingAsAdmin()
            ->from('admin/doctors/create')
            ->post('admin/doctors', [
                'name' => 'Antonio',
                'email' => 'antonio',
                'password' => '123456',
            ])->assertRedirect(route('admin_create_doctors'))
                ->assertSessionHasErrors(['email']);

        $this->assertEquals($old_user_count, User::count());
    }

    /**
     * @test
     */
    public function test_email_is_unique()
    {
        factory(User::class)->create([
            'email' => 'antonio@antonio.com'
        ]);

        $old_user_count = User::count();

        $this->actingAsAdmin()
            ->from('admin/doctors/create')
            ->post('admin/doctors', [
                'name' => 'Antonio',
                'email' => 'antonio@antonio.com',
                'password' => '123456',
            ])->assertRedirect(route('admin_create_doctors'))
                ->assertSessionHasErrors(['email']);

        $this->assertEquals($old_user_count, User::count());
    }

    /**
     * @test
     */
    public function test_email_long_is_6_char()
    {
        $old_user_count = User::count();

        $this->actingAsAdmin()
            ->from('admin/doctors/create')
            ->post('admin/doctors', [
                'name' => 'Antonio',
                'email' => 'antonio@antonio.com',
                'password' => '1234',
            ])->assertRedirect(route('admin_create_doctors'))
                ->assertSessionHasErrors(['password']);

        $this->assertEquals($old_user_count, User::count());
    }
}

<?php

namespace Tests\Feature\Admin\Doctors;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Illuminate\Support\Facades\DB;

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
    public function test_pass_long_is_6_char()
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

    /**
     * @test
     */
    public function test_load_edit_doctors_page()
    {
        $doctor = factory(User::class)->create([
            'doctor' => true,
        ]);

        $this->actingAsAdmin()
            ->get("admin/doctors/{$doctor->id}/edit")
            ->assertStatus(200)
            ->assertSee("Editando doctor: $doctor->id")
            ->assertViewIs('admin.doctors.edit')
            ->assertViewHas('doctor', function($viewUser) use ($doctor){
                return $viewUser->id == $doctor->id;
            });
    }

    /**
     * @test
     */
    public function test_updates_a_doctor()
    {

        $doctor = factory(User::class)->create([
            'doctor' => true,
            'email' => 'koda46@koda.com',
        ]);

        $this->actingAsAdmin()
            ->put("admin/doctors/{$doctor->id}", [
            'name' => 'Koda45',
            'surname' => 'koda',
            'email' => 'koda45@koda.com',
            'phone' => '+34688699677',
            'password' => '123456',
        ])->assertRedirect("admin/doctors/{$doctor->id}");

        $this->assertDatabaseHas('users',[
            'name' => 'Koda45',
        ]);
    }

    /**
     * @test
     */
    public function test_name_is_required_when_update_a_doctor()
    {
        $doctor = factory(User::class)->create([
            'doctor' => true,
        ]);

        $this->actingAsAdmin()
            ->from("/admin/doctors/{$doctor->id}/edit")
            ->put("/admin/doctors/{$doctor->id}", [
                'name' => '',
                'email' => 'antonio2@antonio2.com',
                'password' => '1234'
            ])->assertRedirect(route('admin_edit_doctors', ['doctor' => $doctor]))
                ->assertSessionHasErrors(['name' => 'Debe introducir un nombre']);

        $this->assertDatabaseMissing('users', [
            'email' => 'antonio2@antonio2.com',
        ]);
    }

    // /**
    //  * @test
    //  */
    // public function test_email_is_required_when_update_a_doctor()
    // {
    //     //$this->withoutExceptionHandling();

    //     $doctor = factory(User::class)->create([
    //         'doctor' => true,
    //     ]);

    //     $this->actingAsAdmin()
    //         ->from("/admin/doctors/{$doctor->id}/edit")
    //         ->put("/admin/doctors/{$doctor->id}", [
    //             'name' => 'Antonio2',
    //             'email' => '',
    //             'password' => '1234'
    //         ])->assertRedirect(route('admin_edit_doctors', ['doctor' => $doctor]))
    //             ->assertSessionHasErrors(['email' => 'Debe introducir un email']);

    //     $this->assertDatabaseMissing('users', [
    //         'name' => 'Antonio2',
    //     ]);
    // }

    /**
     * @test
     */
    public function test_password_is_optional_when_update_a_doctor()
    {
        $doctor= factory(User::class)->create([
            'doctor' => true,
        ]);

        $this->actingAsAdmin()
            ->from("/admin/doctors/{$doctor->id}/edit")
            ->put("/admin/doctors/{$doctor->id}", [
                'name' => 'Antonio2',
                'surname' => 'user',
                'email' => 'antonio2222@antonio.com',
                'password' => '',
                'phone' => '+34655688677',
            ])->assertRedirect(route('admin_show_doctors', ['doctor' => $doctor]));

        $this->assertDatabaseMissing('users', [
            'email' => 'antonio2222@antonio.com',
        ]);
    }

    // /**
    //  * @test
    //  */
    // public function test_email_is_invalid_when_update_a_doctor()
    // {
    //     //$this->withoutExceptionHandling();

    //     $doctor = factory(User::class)->create([
    //         'doctor' => true,
    //     ]);

    //     $this->actingAsAdmin()
    //         ->from("/admin/doctors/{$doctor->id}/edit")
    //         ->put("/admin/doctors/{$doctor->id}", [
    //             'name' => 'Antonio2',
    //             'email' => 'antonio2',
    //             'password' => '1234'
    //         ])->assertRedirect(route('admin_edit_doctors', ['doctor' => $doctor]))
    //             ->assertSessionHasErrors(['email' => 'Debe introducir un email válido']);

    //     $this->assertDatabaseMissing('users', [
    //         'email' => 'antonio2@antonio2.com',
    //     ]);
    // }

    // /**
    //  * @test
    //  */
    // public function test_email_is_unique_when_update_a_doctors()
    // {
    //     //$this->withoutExceptionHandling();

    //     $doctor = factory(User::class)->create([
    //         'email' => 'antonio2@antonio2.com',
    //         'doctor' => true,
    //     ]);

    //     $doctor2 = factory(User::class)->create([
    //         'email' => 'antonio55@antonio55.com',
    //         'doctor' => true,
    //     ]);

    //     $this->actingAsAdmin()
    //         ->from("/admin/doctors/{$doctor->id}/edit")
    //         ->put("/admin/doctors/{$doctor->id}", [
    //             'name' => 'Antonio2',
    //             'email' => 'antonio55@antonio55.com',
    //             'password' => '1234'
    //         ])->assertRedirect(route('admin_edit_doctors', ['doctor' => $doctor]))
    //             ->assertSessionHasErrors(['email' => 'El email introducido ya existe']);

    // }

    /**
     * @test
     */
    public function test_pass_long_is_6_char_when_update_a_doctors()
    {
        //$this->withoutExceptionHandling();

        $doctor = factory(User::class)->create([
            'doctor' => true,
        ]);

        $this->actingAsAdmin()
            ->from("/admin/doctors/{$doctor->id}/edit")
            ->put("/admin/doctors/{$doctor->id}", [
                'name' => 'Antonio2',
                'email' => 'antonio3@antonio3.com',
                'password' => '1234'
            ])->assertRedirect(route('admin_edit_doctors', ['doctor' => $doctor]))
                ->assertSessionHasErrors(['password' => 'La contraseña debe tener entre 6 y 14 carácteres']);

        $this->assertDatabaseMissing('users', [
            'email' => 'antonio3@antonio3.com',
        ]);
    }

    // /**
    //  * @test
    //  */
    // public function test_doctors_email_can_be_the_same_when_update_a_doctor()
    // {
    //     $this->withoutExceptionHandling();

    //     $doctor = factory(User::class)->create([
    //         'email' => 'antonio33@antonio33.com',
    //         'doctor' => true,
    //     ]);

    //     $this->actingAsAdmin()
    //         ->from("/admin/doctors/{$doctor->id}/edit")
    //         ->put("/admin/doctors/{$doctor->id}", [
    //             'name' => 'Antonio33',
    //             'email' => 'antonio33@antonio33.com',
    //             'password' => '123456'
    //         ])->assertRedirect(route('admin_show_doctors', ['doctor' => $doctor]));

    //     $this->assertDatabaseHas('users', [
    //         'name' => 'Antonio33',
    //         'email' => 'antonio33@antonio33.com',
    //     ]);
    // }

    /**
     * @test
     */
    public function test_delete_a_doctor()
    {
        //$this->withoutExceptionHandling();

        DB::table('users')->truncate();

        $doctor = factory(User::class)->create([
            'doctor' => true,
        ]);

        $this->actingAsAdmin()
            ->delete("admin/doctors/{$doctor->id}")
            ->assertRedirect(route('admin_doctors'));

        $this->assertDatabaseMissing('users', [
            'id' => $doctor->id,
        ]);
    }
}

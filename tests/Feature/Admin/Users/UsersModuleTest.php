<?php

namespace Tests\Feature\Admin\Users;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UsersModuleTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function test_load_users_list()
    {
        factory(User::class)->create([
            'name' => 'Joel',
        ]);

        factory(User::class)->create([
            'name' => 'Ellie',
        ]);

        $this->actingAsAdmin()
            ->get('/admin/users')
        	->assertStatus(200)
        	->assertSee('Listado de usuarios')
            ->assertSee('Joel')
            ->assertSee('Ellie');
    }

    /**
     * @test
     */
    public function test_load_users_detail()
    {
        $user = factory(User::class)->create([
            'name' => 'Victor',
        ]);

        $this->actingAsAdmin()
            ->get('/admin/users/'.$user->id)
        	->assertStatus(200)
        	->assertSee('Victor');
    }

    /**
     * @test
     */
    public function test_load_users_new()
    {
        $this->actingAsAdmin()
            ->get('/admin/users/create')
        	->assertStatus(200)
        	->assertSee('Creando nuevo usuario.');
    }

    /**
     * @test
     */
    public function test_load_users_edit_fail()
    {
        $this->actingAsAdmin()
            ->get('/admin/users/texto/edit')
        	->assertStatus(404);
    }

    /**
     * @test
     */
    public function test_show_404_error_user_not_found()
    {
        $this->actingAsAdmin()
            ->get('/admin/users/999')
            ->assertStatus(404)
            ->assertSee('Página no encontrada');
    }

    /**
     * @test
     */
    public function test_create_new_user()
    {
        $this->actingAsAdmin()
            ->post('admin/users/', [
           'name' => 'Made',
           'surname' => 'Zamora',
           'email' => 'made@made.com',
           'phone' => '+34655655655',
           'password' => '123456'
        ])->assertRedirect(route('admin_users'));

        $this->assertDatabaseHas('users', [
            'name' => 'Made',
            'surname' => 'Zamora',
            'email' => 'made@made.com',
            'phone' => '+34655655655',
        ]);
    }

    /**
     * @test
     */
    public function test_name_is_required()
    {
        $users_count = User::count();

        $this->actingAsAdmin()
            ->from('admin/users/create')
            ->post('admin/users', [
                'email' => 'antonio@antonio.com',
                'password' => '123456'
            ])->assertRedirect(route('admin_create_users'))
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
            ->from('admin/users/create')
            ->post('admin/users', [
                'name' => 'Antonio',
                'password' => '123456'
            ])->assertRedirect(route('admin_create_users'))
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
            ->from('admin/users/create')
            ->post('admin/users', [
                'name' => 'Antonio',
                'email' => 'antonio@antonio.com'
            ])->assertRedirect(route('admin_create_users'))
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
            ->from('admin/users/create')
            ->post('admin/users', [
                'name' => 'Antonio',
                'email' => 'antonio',
                'password' => '123456',
            ])->assertRedirect(route('admin_create_users'))
                ->assertSessionHasErrors(['email']);

        $this->assertEquals($old_user_count, User::count());
    }

    /**
     * @test
     */
    public function test_email_is_unique()
    {
        User::truncate();

        factory(User::class)->create([
            'email' => 'antonio555@antonio.com'
        ]);

        $old_user_count = User::count();

        $this->actingAsAdmin()
            ->from('admin/users/create')
            ->post('admin/users', [
                'name' => 'Antonio',
                'email' => 'antonio555@antonio.com',
                'password' => '123456',
            ])->assertRedirect(route('admin_create_users'))
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
            ->from('admin/users/create')
            ->post('admin/users', [
                'name' => 'Antonio',
                'email' => 'antonio@antonio.com',
                'password' => '1234',
            ])->assertRedirect(route('admin_create_users'))
                ->assertSessionHasErrors(['password']);

        $this->assertEquals($old_user_count, User::count());
    }

    /**
     * @test
     */
    public function test_load_edit_users_page()
    {
        $user = factory(User::class)->create();

        $this->actingAsAdmin()
            ->get("admin/users/{$user->id}/edit")
            ->assertStatus(200)
            ->assertSee("Editando usuario: $user->id")
            ->assertViewIs('admin.users.edit')
            ->assertViewHas('user', function($viewUser) use ($user){
                return $viewUser->id == $user->id;
            });
    }

    /**
     * @test
     */
    public function test_updates_a_user()
    {

        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $this->actingAsAdmin()
            ->put("admin/users/{$user->id}", [
            'name' => 'Koda3',
            'surname' => 'koda',
            'email' => 'koda34@koda.com',
            'phone' => '+34688699677',
            'password' => '123456',
        ])->assertRedirect("admin/users/{$user->id}");

        $this->assertDatabaseHas('users',[
            'name' => 'Koda3',
        ]);
    }

    /**
     * @test
     */
    public function test_name_is_required_when_update_a_user()
    {
        $user = factory(User::class)->create();

        $this->actingAsAdmin()
            ->from("/admin/users/{$user->id}/edit")
            ->put("/admin/users/{$user->id}", [
                'name' => '',
                'email' => 'antonio2@antonio2.com',
                'password' => '1234'
            ])->assertRedirect(route('admin_edit_users', ['user' => $user]))
                ->assertSessionHasErrors(['name' => 'Debe introducir un nombre']);

        $this->assertDatabaseMissing('users', [
            'email' => 'antonio2@antonio2.com',
        ]);
    }

    // /**
    //  * @test
    //  */
    // public function test_email_is_required_when_update_a_user()
    // {
    //     //$this->withoutExceptionHandling();

    //     $user = factory(User::class)->create();

    //     $this->actingAsAdmin()
    //         ->from("/admin/users/{$user->id}/edit")
    //         ->put("/admin/users/{$user->id}", [
    //             'name' => 'Antonio2',
    //             'email' => '',
    //             'password' => '1234'
    //         ])->assertRedirect(route('admin_edit_users', ['user' => $user]))
    //             ->assertSessionHasErrors(['email' => 'Debe introducir un email']);

    //     $this->assertDatabaseMissing('users', [
    //         'name' => 'Antonio2',
    //     ]);
    // }

    /**
     * @test
     */
    public function test_password_is_required_when_update_a_user()
    {
        $user = factory(User::class)->create();

        $this->actingAsAdmin()
            ->from("/admin/users/{$user->id}/edit")
            ->put("/admin/users/{$user->id}", [
                'name' => 'Antonio2',
                'surname' => 'user',
                'email' => 'antonio2222@antonio.com',
                'phone' => '+34655688677',
            ])->assertRedirect(route('admin_edit_users', ['user' => $user]))
                ->assertSessionHasErrors(['password' => 'Debe introducir una contraseña']);

        $this->assertDatabaseMissing('users', [
            'email' => 'antonio2222@antonio.com',
        ]);
    }

    // /**
    //  * @test
    //  */
    // public function test_email_is_invalid_when_update_a_user()
    // {
    //     $user = factory(User::class)->create();

    //     $this->actingAsAdmin()
    //         ->from("/admin/users/{$user->id}/edit")
    //         ->put("/admin/users/{$user->id}", [
    //             'name' => 'Antonio2',
    //             'email' => 'antonio2',
    //             'password' => '1234'
    //         ])->assertRedirect(route('admin_edit_users', ['user' => $user]))
    //             ->assertSessionHasErrors(['email' => 'Debe introducir un email válido']);

    //     $this->assertDatabaseMissing('users', [
    //         'email' => 'antonio2@antonio2.com',
    //     ]);
    // }

    // /**
    //  * @test
    //  */
    // public function test_email_is_unique_when_update_a_users()
    // {

    //     $user = factory(User::class)->create([
    //         'email' => 'antonio2@antonio2.com',
    //     ]);

    //     $user2 = factory(User::class)->create([
    //         'email' => 'antonio55@antonio55.com',
    //     ]);

    //     $this->actingAsAdmin()
    //         ->from("/admin/users/{$user->id}/edit")
    //         ->put("/admin/users/{$user->id}", [
    //             'name' => 'Antonio2',
    //             'email' => 'antonio55@antonio55.com',
    //             'password' => '12345678'
    //         ])->assertRedirect(route('admin_edit_users', ['user' => $user]))
    //             ->assertSessionHasErrors(['email' => 'El email introducido ya existe']);

    // }

    /**
     * @test
     */
    public function test_pass_long_is_6_char_when_update_a_users()
    {
        //$this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $this->actingAsAdmin()
            ->from("/admin/users/{$user->id}/edit")
            ->put("/admin/users/{$user->id}", [
                'name' => 'Antonio2',
                'email' => 'antonio3@antonio3.com',
                'password' => '1234'
            ])->assertRedirect(route('admin_edit_users', ['users' => $user]))
                ->assertSessionHasErrors(['password' => 'La contraseña debe tener entre 6 y 14 carácteres']);

        $this->assertDatabaseMissing('users', [
            'email' => 'antonio3@antonio3.com',
        ]);
    }

    // /**
    //  * @test
    //  */
    // public function test_users_email_can_be_the_same_when_update_a_user()
    // {
    //     $this->withoutExceptionHandling();

    //     $user = factory(User::class)->create([
    //         'email' => 'antonio33@antonio33.com',
    //         'doctor' => true,
    //     ]);

    //     $this->actingAsAdmin()
    //         ->from("/admin/users/{$user->id}/edit")
    //         ->put("/admin/users/{$user->id}", [
    //             'name' => 'Antonio33',
    //             'email' => 'antonio33@antonio33.com',
    //             'password' => '123456'
    //         ])->assertRedirect(route('admin_show_doctors', ['user' => $user]));

    //     $this->assertDatabaseHas('users', [
    //         'name' => 'Antonio33',
    //         'email' => 'antonio33@antonio33.com',
    //     ]);
    // }
}

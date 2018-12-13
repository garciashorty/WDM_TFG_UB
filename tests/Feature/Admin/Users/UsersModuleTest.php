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
    public function test_load_users_edit()
    {
        $this->actingAsAdmin()
            ->get('/admin/users/5/edit')
        	->assertStatus(200)
        	->assertSee('Editando usuario: 5');
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
    public function test_email_long_is_6_char()
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
}

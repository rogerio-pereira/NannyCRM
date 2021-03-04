<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Models\CategoryEvent;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\ActingAs;

class CategoryEventTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function aGuestCantAccessCategoryEvent()
    {
        $response = $this->get('/api/categoria-eventos');
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function aUserCanAccessCategoryEvent()
    {
        ActingAs::user();

        $response = $this->get(route('events-category.index'));
        $response->assertJson([]);

        $category = factory(CategoryEvent::class)->create();
        $category2 = factory(CategoryEvent::class)->create();

        $response2 = $this->get(route('events-category.index'));
        $response2->assertJson([
            'data' => [
                [
                    'id' => 1,
                    'name' => $category->name
                ],
                [
                    'id' => 2,
                    'name' => $category2->name
                ],
            ]
        ]);
    }

    /**
     * @test
     */
    public function aUserCanCreateCategoryEvent()
    {
        ActingAs::user();

        $response = $this->get(route('events-category.index'));
        $response->assertJson([]);

        $data = ['name' => 'Category 1'];
        $request = $this->post(route('events-category.store', $data));
        $request->assertStatus(201)
            ->assertJson([
                'id' => 1,
                'name' => 'Category 1',
            ]);
        $this->assertDatabaseHas('category_events', [
            'id' => 1,
            'name' => 'Category 1'
        ]);

        $response2 = $this->get(route('events-category.index'));
        $response2->assertJson([
            'data' => [
                [
                    'id' => 1,
                    'name' => 'Category 1'
                ]
            ]
        ]);
    }

    /**
     * @test
     */
    public function aUserCanUpdateCategoryEvent()
    {
        ActingAs::user();
        $category = factory(CategoryEvent::class)->create();


        $this->assertDatabaseHas('category_events', [
            'id' => 1,
            'name' => $category->name
        ]);
        $response = $this->get(route('events-category.index'));
        $response->assertJson([
            'data' => [
                [
                    'id' => 1,
                    'name' => $category->name
                ]
            ]
        ]);

        $data = ['name' => 'Category 1'];
        $request = $this->put(route('events-category.update', 1), $data);
        $request->assertStatus(200)
            ->assertJson([
                'id' => 1,
                'name' => 'Category 1',
            ]);
        $this->assertDatabaseHas('category_events', [
            'id' => 1,
            'name' => 'Category 1'
        ]);

        $response2 = $this->get(route('events-category.index'));
        $response2->assertJson([
            'data' => [
                [
                    'id' => 1,
                    'name' => 'Category 1'
                ]
            ]
        ]);
    }

    /**
     * @test
     */
    public function aUserCanDeleteCategoryEvent()
    {
        ActingAs::user();
        $category = factory(CategoryEvent::class)->create();


        $this->assertDatabaseHas('category_events', [
            'id' => 1,
            'name' => $category->name
        ]);
        $response = $this->get(route('events-category.index'));
        $response->assertJson([
            'data' => [
                [
                    'id' => 1,
                    'name' => $category->name
                ]
            ]
        ]);
        $request = $this->delete(route('events-category.destroy', 1));
        $request->assertStatus(200);
        $this->assertDatabaseMissing('category_events', [
            'id' => 1,
            'name' => 'Category 1'
        ]);

        $response2 = $this->get(route('events-category.index'));
        $response2->assertJson([
            'data' => []
        ]);
    }

    /**
     * @test
     */
    public function categoryEventCreateValidation()
    {
        ActingAs::user();

        $data = ['name' => ''];
        $request = $this->post(route('events-category.store'), $data);
        $request
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'name' => 'O campo nome é obrigatório'
            ]);

        $data = ['name' => 'd'];
        $request = $this->post(route('events-category.store'), $data);
        $request
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'name' => 'O campo nome deve ter no minimo 3 caracteres'
            ]);

        $data = ['name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'];
        $request = $this->post(route('events-category.store'), $data);
        $request
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'name' => 'O campo nome deve ter no maximo 30 caracteres'
            ]);

        $data = ['name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'];
        $request = $this->post(route('events-category.store'), $data);
        $request
            ->assertStatus(201);
        $this->assertDatabaseHas('category_events', ['id' => 1, 'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa']);


        $request = $this->post(route('events-category.store'), $data);
        $request
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'name' => 'Esse nome já existe'
            ]);
    }

    /**
     * @test
     */
    public function categoryEventUpdateValidation()
    {
        ActingAs::user();
        $category = factory(CategoryEvent::class)->create();
        $category2 = factory(CategoryEvent::class)->create();

        
        $data = ['name' => ''];
        $request = $this->put(route('events-category.update', 1), $data);
        $request
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'name' => 'O campo nome é obrigatório'
            ]);


        $data = ['name' => 'd'];
        $request = $this->put(route('events-category.update', 1), $data);
        $request
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'name' => 'O campo nome deve ter no minimo 3 caracteres'
            ]);


        $data = ['name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'];
        $request = $this->put(route('events-category.update', 1), $data);
        $request
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'name' => 'O campo nome deve ter no maximo 30 caracteres'
            ]);


        $data = ['name' => $category->name];
        $this->assertDatabaseHas('category_events', ['id' => 1, 'name' => $category->name]);
        $this->assertDatabaseHas('category_events', ['id' => 2, 'name' => $category2->name]);
        $request = $this->put(route('events-category.update', 1), $data);
        $request
            ->assertStatus(200);
        $this->assertDatabaseHas('category_events', ['id' => 1, 'name' => $category->name]);
        $this->assertDatabaseHas('category_events', ['id' => 2, 'name' => $category2->name]);


        $data = ['name' => $category->name];
        $this->assertDatabaseHas('category_events', ['id' => 1, 'name' => $category->name]);
        $this->assertDatabaseHas('category_events', ['id' => 2, 'name' => $category2->name]);
        $request = $this->put(route('events-category.update', 2), $data);
        $request
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'name' => 'Esse nome já existe'
            ]);
        $this->assertDatabaseHas('category_events', ['id' => 1, 'name' => $category->name]);
        $this->assertDatabaseHas('category_events', ['id' => 2, 'name' => $category2->name]);
    }
}

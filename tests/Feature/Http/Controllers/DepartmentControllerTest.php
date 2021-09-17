<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Department;
use App\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DepartmentController
 */
class DepartmentControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $departments = Department::factory()->count(3)->create();

        $response = $this->get(route('department.index'));

        $response->assertOk();
        $response->assertViewIs('department.index');
        $response->assertViewHas('departments');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('department.create'));

        $response->assertOk();
        $response->assertViewIs('department.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DepartmentController::class,
            'store',
            \App\Http\Requests\DepartmentStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $state = State::factory()->create();
        $name = $this->faker->name;
        $created_at = $this->faker->dateTime();
        $updated_at = $this->faker->dateTime();

        $response = $this->post(route('department.store'), [
            'state_id' => $state->id,
            'name' => $name,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ]);

        $departments = Department::query()
            ->where('state_id', $state->id)
            ->where('name', $name)
            ->where('created_at', $created_at)
            ->where('updated_at', $updated_at)
            ->get();
        $this->assertCount(1, $departments);
        $department = $departments->first();

        $response->assertRedirect(route('department.index'));
        $response->assertSessionHas('department.id', $department->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $department = Department::factory()->create();

        $response = $this->get(route('department.show', $department));

        $response->assertOk();
        $response->assertViewIs('department.show');
        $response->assertViewHas('department');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $department = Department::factory()->create();

        $response = $this->get(route('department.edit', $department));

        $response->assertOk();
        $response->assertViewIs('department.edit');
        $response->assertViewHas('department');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DepartmentController::class,
            'update',
            \App\Http\Requests\DepartmentUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $department = Department::factory()->create();
        $state = State::factory()->create();
        $name = $this->faker->name;
        $created_at = $this->faker->dateTime();
        $updated_at = $this->faker->dateTime();

        $response = $this->put(route('department.update', $department), [
            'state_id' => $state->id,
            'name' => $name,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ]);

        $department->refresh();

        $response->assertRedirect(route('department.index'));
        $response->assertSessionHas('department.id', $department->id);

        $this->assertEquals($state->id, $department->state_id);
        $this->assertEquals($name, $department->name);
        $this->assertEquals($created_at, $department->created_at);
        $this->assertEquals($updated_at, $department->updated_at);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $department = Department::factory()->create();

        $response = $this->delete(route('department.destroy', $department));

        $response->assertRedirect(route('department.index'));

        $this->assertSoftDeleted($department);
    }
}

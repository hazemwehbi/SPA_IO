<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Tests\TestCase;
use Tests\WithStubUser;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TasksTest extends TestCase
{
    use DatabaseTransactions, WithStubUser;

    public function test_index_authentication()
    {
        $this->assertAuthenticationRequired('/tasks');
        $this->assertAuthenticationRequired('/tasks/add');
        $this->assertAuthenticationRequired('/tasks', 'post');
        $this->assertAuthenticationRequired('/tasks/1');
        $this->assertAuthenticationRequired('/tasks/edit/1');
        $this->assertAuthenticationRequired('/tasks/update/1', 'put');
        $this->assertAuthenticationRequired('/tasks/delete/1', 'delete');
    }

    public function test_index_view()
    {
        $user = $this->createStubUser();
        $response = $this->actingAs($user)->get('/tasks');

        $response->assertStatus(200);
        $response->assertViewHas('tasks');
        $response->assertSee('<span>Tasks</span>');
    }

    public function test_authenticated_user_can_create_new_task()
    {
        $this->actingAs($this->createStubUser());

        $this->get('/tasks/add')
             ->assertStatus(200)
             ->assertViewIs('tasks.form')
             ->assertViewHas('task', null);

        $this->post('/tasks', ['name' => 'Hanoi','description' => 'Hanoi'])
             ->assertRedirect('/tasks')
             ->assertSessionHas('created', Task::latest()->first()->id);
    }

    public function test_it_checks_for_invalid_task()
    {
        $this->actingAs($this->createStubUser());

        $this->postJson('/tasks', ['name' => '','description' => ''])
             ->assertStatus(422)
             ->assertJsonStructure(['message', 'errors' => ['name']]);
    }

    public function test_authenticated_user_can_view_a_task()
    {
        $task = $this->createTask();

        $this->get("/tasks/{$task->id}")
             ->assertStatus(200)
             ->assertViewIs('tasks.item')
             ->assertViewHas('task');
    }

    public function test_authenticated_user_can_edit_an_existing_task()
    {
        $task = $this->createTask();

        $this->get("/tasks/edit/{$task->id}")
             ->assertStatus(200)
             ->assertViewIs('tasks.form')
             ->assertViewHas('task');

        $this->post("/tasks/update/{$task->id}", ['name' => 'London'])
             ->assertRedirect('/tasks')
             ->assertSessionHas('updated', $task->id);
    }

    public function test_authenticated_user_can_delete_an_existing_task()
    {
        $task = $this->createTask();

        $this->delete("/tasks/delete/{$task->id}")
             ->assertRedirect('/tasks')
             ->assertSessionHas('deleted', $task->id);
    }

    private function createTask($authenticated = true)
    {

        $task =  Task::factory()->create();

        if ($authenticated) {
            $this->actingAs($this->createStubUser());
        }

        return $task;
    }
}

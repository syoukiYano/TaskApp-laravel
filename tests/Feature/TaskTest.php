<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Requests\CreateTask;
use Carbon\Carbon;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function setUP(){
        parent::setUP();
        $this->seed('FoldersTablesSeeder');
    }

    public function due_date_should_be_date(){
        $response = $this->post('/folders/1/tasks/create',[
            'title' => 'Sample task',
            'due_date' => 123,
        ]);
        $response->assertSessionHasErrors([
            'due_date' => '期日には日付を入力してくださいな。',
        ]);
    }
    public function due_date_should_not_be_past(){
        $response = $this->post('folders/1/tasks/create',[
            'title' => 'Sample task',
            'due_date' => Carbon::yesterday()->format('Y/m/d'),
        ]);
        $response->assertSessionHasErrors([
            'due_date' => '期日には今日以降の日付を入力してくださいな。',
        ]);
    }

    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}

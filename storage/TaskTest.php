<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Task;
use Tests\ModelTestCase;

class TaskTest extends ModelTestCase
{
    public function test_model_configuration()
    {
        $this->runConfigurationAssertions(new Task(), [
            'user_id', 'name','description'
        ]);
    }

    public function test_tasks_relation()
    {
        $m = new Task();
        $r = $m->user();
        $this->assertBelongsToRelation($r, $m, new User(), 'user_id');
    }
}

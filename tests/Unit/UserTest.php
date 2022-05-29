<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\ModelTestCase;

class UserTest extends ModelTestCase
{
    public function test_model_configuration()
    {
        $this->runConfigurationAssertions(new User(), [
            'name',
            'email',
            'password'
        ]);
    }

    public function test_Tasks_relation()
    {
        $m = new User();
        $r = $m->Tasks();
        $this->assertHasManyRelation($r, $m, new Task());
    }
}

<?php

namespace Tests\Feature;

use App\Http\Controllers\TeamController;
use App\Models\Group;
use App\Models\Team;
use App\Models\Week;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    use RefreshDatabase;

    //   $this->seeInDatabase('teams', ['points' => 10]);

    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertViewIs('index');

        $response->assertSuccessful();
    }

    public function test_the_teams_endpoint_working_correctly()
    {
        Team::factory()->create();

        $response = $this->get('/teams');

        $response->assertJsonStructure([
            '*' => [
                'id',
                'group_id',
                'name',
                'points',
                'played',
                'won',
                'lost',
                'drawn',
                'ga',
                'gf',
                'gd',
            ]
        ]);
    }

    public function test_the_groups_endpoint_working_correctly()
    {
        $data = Group::factory(4)->create()->jsonSerialize();

        $response = $this->get('/groups');

        $response->assertSuccessful()->assertJson($data);
    }

    public function test_group_names_are_create_correctly()
    {
        $groups = Group::factory(4)->create()->pluck('name')->toArray();

        $this->assertEquals(['A', 'B', 'C', 'D'], $groups);
    }

    public function test_week_endpoint_is_working_correctly()
    {
        Week::factory(6)->create();

        Team::factory(4)->create();

        (new TeamController)->reGenerate();


    }


}

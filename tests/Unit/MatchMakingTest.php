<?php

namespace Tests\Unit;

use App\Services\Matchmaking;
use PHPUnit\Framework\TestCase;

class MatchMakingTest extends TestCase
{
    public function test_matches_maker_function_work_correctly()
    {
        $teams = ['Arsenal', 'Chelsea'];

        $matches = Matchmaking::matchesMaker($teams);

        $this->assertCount(2, $matches);

        $this->assertEquals([['Arsenal' , 'Chelsea'], ['Chelsea', 'Arsenal']], $matches);
    }

    public function test_matches_maker_function_work_correctly_with_more_teams()
    {
        $teams = ['Arsenal', 'Chelsea', 'Liverpool', 'Tottenham'];

        $matches = Matchmaking::matchesMaker($teams);

        $this->assertCount(12, $matches);

        $this->assertEquals([
            ["Arsenal","Chelsea"],
            ["Arsenal","Liverpool"],
            ["Arsenal","Tottenham"],
            ["Chelsea","Liverpool"],
            ["Chelsea","Tottenham"],
            ["Liverpool","Tottenham"],
            ["Chelsea","Arsenal"],
            ["Liverpool","Arsenal"],
            ["Tottenham","Arsenal"],
            ["Liverpool","Chelsea"],
            ["Tottenham","Chelsea"],
            ["Tottenham","Liverpool"]
        ], $matches);
    }
}

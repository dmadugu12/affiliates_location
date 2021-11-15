<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\AffiliatesController;

class AffiliatesTest extends TestCase
{
    /**
     * Test than an array is returned.
     *
     * @return void
     */
    public function testThatThePageDoesntFail()
    {
        //$response = $this->get('/affiliate');

        $response = $this->call('GET', '/affiliate');
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test that the functionality to retrieve affiliates from the file works, and returns an array
     * 
     * @return void
     */
    public function testWeCanGetAffiliatesFromTheFile() 
    {
        $affiliatesController = new AffiliatesController();
        $this->assertIsArray($affiliatesController->getAffiiatesFromFile());
    }

    /**
     * Test we can calculate the distance when given the locations, and confirm that boolean value is returned
     * 
     * @return void
     */
    public function testWeCanCalculateTheDistanceFromTheOffice() 
    {
        $affiliatesController = new AffiliatesController();
        $this->assertIsBool($affiliatesController->checkDistanceFromOffice('52.986375', '-6.043701', '53.3340285', '-6.2535495', $unit = 'kilometers'));
        $this->assertIsBool($affiliatesController->checkDistanceFromOffice('52.833502', '-8.522366', '53.3340285', '-6.2535495', $unit = 'kilometers'));
    }
}

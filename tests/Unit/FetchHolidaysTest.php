<?php

namespace Tests\Unit;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class FetchHolidaysTest extends TestCase
{
    /** @test */
    public function test_has_fetch_holidays_command()
    {
        $this->assertTrue(class_exists (\App\Console\Commands\FetchHolidays::class));
    }

    /** @test */
    public function test_can_fetch_holidays () 
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->get("https://kayaposoft.com/enrico/json/v2.0?action=getHolidaysForYear&year=2021&country=zaf&holidayType=public_holiday");
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getBody()->getContents());
    }

}

<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Tests\Integration\Preview\Sync\Service\SyncMap;

use Twilio\Exceptions\DeserializeException;
use Twilio\Exceptions\TwilioException;
use Twilio\Http\Response;
use Twilio\Serialize;
use Twilio\Tests\HolodeckTestCase;
use Twilio\Tests\Request;

class SyncMapItemTest extends HolodeckTestCase {
    public function testFetchRequest() {
        $this->holodeck->mock(new Response(500, ''));

        try {
            $this->twilio->preview->sync->services("ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                        ->syncMaps("MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                        ->syncMapItems("key")->fetch();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}

        $this->assertRequest(new Request(
            'get',
            'https://preview.twilio.com/Sync/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Maps/MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items/key'
        ));
    }

    public function testFetchResponse() {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "created_by": "created_by",
                "data": {},
                "date_created": "2015-07-30T20:00:00Z",
                "date_updated": "2015-07-30T20:00:00Z",
                "key": "key",
                "map_sid": "MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "revision": "revision",
                "service_sid": "ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "url": "https://preview.twilio.com/Sync/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Maps/MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items/key"
            }
            '
        ));

        $actual = $this->twilio->preview->sync->services("ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                              ->syncMaps("MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                              ->syncMapItems("key")->fetch();

        $this->assertNotNull($actual);
    }

    public function testDeleteRequest() {
        $this->holodeck->mock(new Response(500, ''));

        try {
            $this->twilio->preview->sync->services("ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                        ->syncMaps("MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                        ->syncMapItems("key")->delete();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}

        $this->assertRequest(new Request(
            'delete',
            'https://preview.twilio.com/Sync/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Maps/MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items/key'
        ));
    }

    public function testDeleteResponse() {
        $this->holodeck->mock(new Response(
            204,
            null
        ));

        $actual = $this->twilio->preview->sync->services("ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                              ->syncMaps("MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                              ->syncMapItems("key")->delete();

        $this->assertTrue($actual);
    }

    public function testCreateRequest() {
        $this->holodeck->mock(new Response(500, ''));

        try {
            $this->twilio->preview->sync->services("ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                        ->syncMaps("MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                        ->syncMapItems->create("key", "{}");
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}

        $values = array(
            'Key' => "key",
            'Data' => Serialize::json_object("{}"),
        );

        $this->assertRequest(new Request(
            'post',
            'https://preview.twilio.com/Sync/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Maps/MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items',
            null,
            $values
        ));
    }

    public function testCreateResponse() {
        $this->holodeck->mock(new Response(
            201,
            '
            {
                "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "created_by": "created_by",
                "data": {},
                "date_created": "2015-07-30T20:00:00Z",
                "date_updated": "2015-07-30T20:00:00Z",
                "key": "key",
                "map_sid": "MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "revision": "revision",
                "service_sid": "ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "url": "https://preview.twilio.com/Sync/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Maps/MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items/key"
            }
            '
        ));

        $actual = $this->twilio->preview->sync->services("ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                              ->syncMaps("MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                              ->syncMapItems->create("key", "{}");

        $this->assertNotNull($actual);
    }

    public function testReadRequest() {
        $this->holodeck->mock(new Response(500, ''));

        try {
            $this->twilio->preview->sync->services("ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                        ->syncMaps("MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                        ->syncMapItems->read();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}

        $this->assertRequest(new Request(
            'get',
            'https://preview.twilio.com/Sync/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Maps/MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items'
        ));
    }

    public function testReadEmptyResponse() {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "items": [],
                "meta": {
                    "first_page_url": "https://preview.twilio.com/Sync/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Maps/MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items?PageSize=50&Page=0",
                    "key": "items",
                    "next_page_url": null,
                    "page": 0,
                    "page_size": 50,
                    "previous_page_url": null,
                    "url": "https://preview.twilio.com/Sync/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Maps/MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items?PageSize=50&Page=0"
                }
            }
            '
        ));

        $actual = $this->twilio->preview->sync->services("ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                              ->syncMaps("MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                              ->syncMapItems->read();

        $this->assertNotNull($actual);
    }

    public function testReadFullResponse() {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "items": [
                    {
                        "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "created_by": "created_by",
                        "data": {},
                        "date_created": "2015-07-30T20:00:00Z",
                        "date_updated": "2015-07-30T20:00:00Z",
                        "key": "key",
                        "map_sid": "MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "revision": "revision",
                        "service_sid": "ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "url": "https://preview.twilio.com/Sync/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Maps/MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items/key"
                    }
                ],
                "meta": {
                    "first_page_url": "https://preview.twilio.com/Sync/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Maps/MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items?PageSize=50&Page=0",
                    "key": "items",
                    "next_page_url": null,
                    "page": 0,
                    "page_size": 50,
                    "previous_page_url": null,
                    "url": "https://preview.twilio.com/Sync/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Maps/MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items?PageSize=50&Page=0"
                }
            }
            '
        ));

        $actual = $this->twilio->preview->sync->services("ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                              ->syncMaps("MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                              ->syncMapItems->read();

        $this->assertGreaterThan(0, count($actual));
    }

    public function testUpdateRequest() {
        $this->holodeck->mock(new Response(500, ''));

        try {
            $this->twilio->preview->sync->services("ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                        ->syncMaps("MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                        ->syncMapItems("key")->update("{}");
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}

        $values = array(
            'Data' => Serialize::json_object("{}"),
        );

        $this->assertRequest(new Request(
            'post',
            'https://preview.twilio.com/Sync/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Maps/MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items/key',
            null,
            $values
        ));
    }

    public function testUpdateResponse() {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "created_by": "created_by",
                "data": {},
                "date_created": "2015-07-30T20:00:00Z",
                "date_updated": "2015-07-30T20:00:00Z",
                "key": "key",
                "map_sid": "MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "revision": "revision",
                "service_sid": "ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "url": "https://preview.twilio.com/Sync/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Maps/MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items/key"
            }
            '
        ));

        $actual = $this->twilio->preview->sync->services("ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                              ->syncMaps("MPaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                              ->syncMapItems("key")->update("{}");

        $this->assertNotNull($actual);
    }
}
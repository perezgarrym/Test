<?php 

class CheckoutTest extends \PHPUnit\Framework\TestCase
{
    private $client;

    public function testCheckout()
    {
        $this->client = new GuzzleHttp\Client();

        // test A,B,C,D,A,B,A
        $request = $this->client->post('http://test.r4pidev.com/sale/checkout', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode([
                'code' => 'A,B,C,D,A,B,A',
            ])
        ]);
        $response = json_decode($request->getBody(), true);

        $this->assertSame(13.25, @$response['total']);

        // test C,C,C,C,C,C,C
        $request = $this->client->post('http://test.r4pidev.com/sale/checkout', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode([
                'code' => 'C,C,C,C,C,C,C',
            ])
        ]);
        $response = json_decode($request->getBody(), true);

        $this->assertSame(6, @$response['total']);


        // test A,B,C,D
        $request = $this->client->post('http://test.r4pidev.com/sale/checkout', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode([
                'code' => 'A,B,C,D',
            ])
        ]);
        $response = json_decode($request->getBody(), true);

        $this->assertSame(7.25, @$response['total']);
    }

    
}
# FnMock

A PHP testing took for mocking PHP functions.

Most mocking frameworks only allow mocking of objects. FnMock is a tiny class that makes it easy to test native PHP functions as long as the caller is namespaced.


```php
// Code
namespace Http;

class Client {
    public function touch($url) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        $response = curl_exec($ch);

        curl_close($ch);
    }
}
```
```php
// Test
use FnMock\FnMock;

$client = new Http\Client();
FnMock::mock('Client\curl_exec', function($ch) {
    $url = curl_getinfo($ch)['url'];
    assert($url == 'http://google.com');
});

$client->touch('http://google.com');

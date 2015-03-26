# FnMock

A PHP testing tool for mocking functions.

Most mocking frameworks only allow mocking of objects. FnMock is a tiny class that makes it easy to test functions outside the context of a class.

> **Important**: Mocking functions is only supported when the function caller is within a namespace.

## Example

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

		return $response;
    }
}
```
```php
// Test
use FnMock\FnMock;

$client = new Http\Client();

FnMock::mock('Client\curl_exec', function($ch) {
    $url = curl_getinfo($ch)['url'];
    assert($url === 'http://google.com');
	return 'Fake response from server';
});

$response = $client->touch('http://google.com');
assert($response === 'Fake response from server');

// Important: Reset FnMock as part of your tearDown process
FnMock::reset();
```

## Install

```
composer require fnmock/fnmock
```


## Integrate it with PHPUnit

```php
use FnMock\FnMock;

class TestCase extends \PHPUnit_Framework_TestCase 
{
    protected function mockFunction($fn, callable $callback) 
    {
        FnMock::mock($fn, $callback);
    }

    public function tearDown()
    {
        FnMock::reset();
        parent::tearDown();
    }
}
```
Or just use the trait we provide

```php
use FnMock\PHPUnitTrait;

class TestCase extends \PHPUnit_Framework_TestCase
{
    use PHPUnitTrait;
}
```

## License

FnMock is licensed under the MIT License - see the `LICENSE.txt` file for details

## Author

Adam Nicholson - adamnicholson10@gmail.com

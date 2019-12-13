About
------------
this is a simple package for asynchronous laravel.
Each task will be stored in the cache, and then will be executed in parallel with php artisan cli.

Setup
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/):

```
composer require n-singularity/async
```

After updating composer, add the ServiceProvider to the providers array in `config/app.php`

```
Nsingularity\Async\AsynchronousServiceProvider::class
```

Basic Usage
-----------
This package supports three types of functions that can be run in parallel:

#### 1. Global Function
```php
function sendEmail($email, $bodyEmail){
    //code to send email
}

function foo(){
    Nsingularity\Async\Async::globalFunction("sendEmail", ["email@example.com", "body email html"]);
    echo("done");
}

```

#### 2. Function of Object

```php
class Example
{
    public function sendEmail($email, $bodyEmail){
        //code to send email
        
    }
}

function foo(){
    Nsingularity\Async\Async::objectFunction(new Example, "sendEmail", ["email@example.com", "body email html"]);
    echo("done");
}
```

#### 3. Object (must inplements AsyncableClassInterface)

```php
class Example implements \Nsingularity\Async\AsyncableClassInterface
{
    private $email;
    
    private $bodyEmail;
    
    public function __construct($email, $bodyEmail){
        $this->email = $email;
        $this->bodyEmail = $bodyEmail;
    }
    
    public function handler(){
        //code to send email
        
    }
}

function foo(){
    Nsingularity\Async\Async::object(new Example("email@example.com", "body email html"));
    echo("done");
}
```


<?php

require 'vendor/autoload.php';

function http($url, $method)
{
    $response = null;
    $deferred = new \React\Promise\Deferred();

    // depending on the result value we either resolve or reject
    if($response)
    {
        $deferred->resolve($response);
    }else{
        $deferred->reject(new Exception('No response'));
    }

    return $deferred->promise();
}

// promises have builtin methods to handle fulfilled and rejected state
// first one called when the promise is fulfilled, second one when the promise is rejected
// we can chain the promises
http('http://google.com', 'GET')->then(
        function ($response){
            throw new Exception('Errors');
            return strtoupper($response);
        }
    )->then(
        function ($response){
            echo $response . PHP_EOL;
        }
    )->otherwise(
        function (Exception $exception){
            echo $exception->getMessage() . PHP_EOL;
        }
    );


/**
 * Note:
 * Promise is a placeholder for the initially unknown result of the asynchronous deferred process
 * Promise States:  1. pending (value of the deferred process is yet unknown)
 *                  2. fulfilled (filled with the value returned from the deferred process)
 *                  3. rejected (there was an exception during the deferred execution)
 */
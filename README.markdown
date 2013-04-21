# JeepStatus.com

### Purpose

Jeepstatus.com will report to you the status of a Jeep whose information is found in the Chrysler VOTS (Vehicle Order Tracking System).  The VOTS only reports on a very broad level which stage your jeep is at in production.  In fact, it quite often is wrong.  The underlying data actually exposes more information, if you can decipher what the status codes mean.  Thanks to some great Chrysler dealers, we can.

### Method

Chrysler's VOTS relies on asyncronous calls to an address that returns an invalid, but close, JSON response.  By highjacking the async call and performing a lookup on an array, we can get a more specific explanation of where the vehicle is actually reported as being.

### Requirments/Built On

This service is built on [Slim Framework](https://github.com/codeguy/Slim) with the addition of [Slim Extras](https://github.com/codeguy/Slim-Extras), [Twig](http://twig.sensiolabs.org/) for templating, and [Predis](https://github.com/nrk/predis) for caching in a redis server.

You should install the components via composer.  Outside of that (and a webserver with rewrite on) you only need a copy of redis running.

``` json
{
    "name": "jeepstatus",
    "require": {
        "slim/slim": "2.*",
        "slim/extras": "*",
        "twig/twig": "*",
        "predis/predis": "0.8.*@dev"
    }
}
```

### Changelog

#### 0.2
52 times a day is a lot
Not wanting to bombard Chrysler's VOTS service every 5 minutes from the same address, implemented a redis server to cache the json result for 20 minutes.  The interval does not grow or shrink depending on how many times you hit the url.  20 minutes.  Go drink a coffee or beer or something.

#### 0.1
Initial Creation:
JeepStatus is born from the exhaustion of looking at JSON backend code provided by Chrysler than doesn't actually show all the information they are providing.  By coupling the actual data response with a dealer provdied list (available on many jeep websites) we can cross refence and get a better description of where the vehicle actually is.


### License

Copyright (c) <2013> <Kyle Arrington>

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

This repository is a dead on copy of the code running Jeepstatus.com.


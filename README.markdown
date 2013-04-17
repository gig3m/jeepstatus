# JeepStatus.com

### Purpose

Jeepstatus.com will report to you the status of a Jeep whose information is found in the Chrysler VOTS (Vehicle Order Tracking System).  The VOTS only reports on a very broad level which stage your jeep is at in production.  In fact, it quite often is wrong.  The underlying data actually exposes more information, if you can decipher what the status codes mean.  Thanks to some great Chrysler dealers, we can.

### Method

Chrysler's VOTS relies on asyncronous calls to an address that returns an invalid, but close, JSON response.  By highjacking the async call and performing a lookup on an array, we can get a more specific explanation of where the vehicle is actually reported as being.

This repository more specifically runs on (taken from the composer.json file):

``` json
{
    "name": "jeepsomething",
    "require": {
        "slim/slim": "2.*",
        "slim/extras": "*",
        "twig/twig": "*"
    }
}
```
### Warranty

There is none.  Use this tool at your own peril.  All actual information (save the lookup table) comes directly from Chrysler.  Here be dragons.

### License

Copyright (c) <2013> <Kyle Arrington>

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

This repository is a dead on copy of the code running Jeepstatus.com.


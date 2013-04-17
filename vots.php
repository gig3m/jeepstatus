<?php
/**
* 
* 
* 
* 
 */

class VOTSService {

        public $lastname;
        public $vin;
        public static $decoded;

        private $codes = [
            "BB"   => "review by fleet department",
            "BD"   => "special equipment processing",
            "BE"   => "edit error",
            "BG"   => "passed edit n/a for schedule",
            "BGL"  => "edit ok parts unavailable",
            "BX"   => "passed edit available for schedule",
            "C"    => "sub firm",
            "D"    => "firm schedule - dealer has allocation and all parts available",
            "D"    => "1 gateline schedule - scheduled to be built",
            "E"    => "frame",
            "F"    => "paint",
            "G"    => "trim",
            "I"    => "built not ok'd",
            "J"    => "built ok'd",
            "JB"   => "shipped to body vendor",
            "JE"   => "emission check",
            "JS"   => "shipped to storage",
            "KZ"   => "released by plant , invoiced",
            "KZL"  => "released - not shipped",
            "KZM"  => "first rail departure",
            "KZN"  => "first rail arrival",
            "KZO"  => "delayed/recieved",
            "KZOA" => "plant holds",
            "KZOB" => "zone/distribution holds",
            "KZOC" => "carrier delays",
            "KZOD" => "carrier holds",
            "KZOE" => "mis-shipped vehicle",
            "KZOF" => "show/test vehicle",
            "KZOG" => "damaged vehicle",
            "KZOH" => "all other reasons",
            "KZT"  => "second rail departure",
            "KZU"  => "second rail arrival",
            "KZX"  => "delivered to dealer",
            "ZA"   => "canceled",
        ];


    public function __construct($lastname, $vin)
    {
        $this->lastname = $lastname;
        $this->vin = $vin;
        self::$decoded = NULL;

        $this->getJSON();
    }

    public function getJSON()
    {
        $lastname = $this->lastname;
        $vin = $this->vin;

        // Get VOTS Servlet
        $response = file_get_contents("https://www.jeep.com/vots/VOTSServlet?firstName=&lastName=$lastname&vin_last8=$vin&service=json");

        //trim the crap off the front and back, wrapped in votsservice()
        $response = rtrim(ltrim($response, "votsservice("), ")");

        self::$decoded =  json_decode($response, TRUE);

        return TRUE;   

    }

    public function isValid()
    {
        if (self::$decoded['ERROR_DESC'])
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    public function getStatusCode()
    {
        return self::$decoded['StatusDetails']['cStatus'];
    }

    public function getStatusDesc()
    {
        return self::$decoded['StatusDetails']['statusDesc'];
    }

    public function getStatusExplanation()
    {
        return ucwords($this->codes[self::$decoded['StatusDetails']['cStatus']]);
    }

    public function getError()
    {
        return self::$decoded['ERROR_DESC'];
    }



}



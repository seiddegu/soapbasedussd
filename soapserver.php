<?php

//get raw xml data

function sxiToXpath($sxi, $key = null, &$tmp = null)
{
    $keys_arr = array();
    //get the keys count array
    for ($sxi->rewind(); $sxi->valid(); $sxi->next())
    {
        $sk = $sxi->key();
        if (array_key_exists($sk, $keys_arr))
        {
            $keys_arr[$sk]+=1;
            $keys_arr[$sk] = $keys_arr[$sk];
        }
        else
        {
            $keys_arr[$sk] = 1;
        }
    }
    //create the xpath 
    for ($sxi->rewind(); $sxi->valid(); $sxi->next())
    {
        $sk = $sxi->key();
        if (!isset($$sk))
        {
            $$sk = 1;
        }
        if ($keys_arr[$sk] >= 1)
        {
            $spk = $sk . '[' . $$sk . ']';
            $keys_arr[$sk] = $keys_arr[$sk] - 1;
            $$sk++;
        }
        else
        {
            $spk = $sk;
        }
        $kp = $key ? $key . '/' . $spk : '/' . $sxi->getName() . '/' . $spk;
        if ($sxi->hasChildren())
        {
            sxiToXpath($sxi->getChildren(), $kp, $tmp);
        }
        else
        {
            $tmp[$kp] = strval($sxi->current());
        }
        $at = $sxi->current()->attributes();
        if ($at)
        {
            $tmp_kp = $kp;
            foreach ($at as $k => $v)
            {
                $kp .= '/@' . $k;
                $tmp[$kp] = $v;
                $kp = $tmp_kp;
            }
        }
    }
    return $tmp;
}

function xmlToXpath($xml)
{
    $sxi = new SimpleXmlIterator($xml);
    return sxiToXpath($sxi);
}

$response= '<?xml version="1.0" encoding="utf-8"?>
              <soapenv:envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://www.webserviceX.php/">
                  <soapenv:header>
                  <soapenv:body>
                      <web:conversionrateResponse>
                          <web:fromcurrency>GBP</web:fromcurrency>
                          <web:tocurrency>CHF</web:tocurrency>
                      </web:conversionrateResponse>
                  </soapenv:body>
              </soapenv:header></soapenv:envelope>';

// Read cats.xml and print the results:
$rawPost = file_get_contents('php://input');
$rArray = xmlToXpath($rawPost);

//mb_parse_str($rawPost, $result);
//var_dump($result);
//print $result;

file_put_contents('php://output', $rArray);
?>

<?php
$string = <<<XML
<?xml version='1.0'?> 
<document>
 <title>Forty What?</title>
 <from>Joe</from>
 <to>Jane</to>
 <body>
  I know that's the answer -- but what's the question?
 </body>
</document>
XML;


$string = '<?xml version="1.0" encoding="utf-8"?>
<soapenv:envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://www.webserviceX.php/">
                  <soapenv:header>
                  <soapenv:body>
                      <web:conversionrateResponse>
                          <web:fromcurrency>1</web:fromcurrency>
                          <web:tocurrency>23.99</web:tocurrency>
                          <web:fromcurrency1>11</web:fromcurrency1>
                          <web:tocurrency1>233.99</web:tocurrency1>
                      </web:conversionrateResponse>
                  </soapenv:body>
              </soapenv:header>
          </soapenv:envelope>';


$simple = "<para><note>simple note</note></para>";
$p = xml_parser_create();

xml_parse_into_struct($p, $string, $vals, $index);
xml_parser_free($p);
echo "Index array\n\n";
print_r($index);
echo "<br><br>";
echo "\nVals array\n";
print_r($vals);
echo "<br><br>";
echo "FromCurrency : " . $vals[4]["value"];
echo "<br>";
echo "ToCurrency : " . $vals[6]["value"];
?>
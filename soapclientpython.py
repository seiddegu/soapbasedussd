
import requests
import xml as XML

request = u"""<?xml version="1.0" encoding="utf-8"?>
              <soapenv:envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://www.webserviceX.php/">
                  <soapenv:header>
                  <soapenv:body>
                      <web:conversionrate>
                          <web:fromcurrency>GBP</web:fromcurrency>
                          <web:tocurrency>CHF</web:tocurrency>
                      </web:conversionrate>
                  </soapenv:body>
              </soapenv:header></soapenv:envelope>"""

encoded_request = request.encode('utf-8')

headers = {"Host": "localhost",
           "Content-Type": "text/xml; charset=UTF-8",
           "Content-Length": len(encoded_request)}

response = requests.post(url="http://localhost/tepDraw/soapserver.php",
                         headers = headers,
                         data = encoded_request,
                         verify=False)

print response.text

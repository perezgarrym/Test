# Test
 This is a test repo. 

# API REST

POST
http://{{api-url}}/sale/checkout 

payload
{
    "code": "A,B,C,D"
}

# SETUP 

import SQL use mySQL as database \n
test.sql


# UNIT TESTING 
http://test.r4pidev.com use this host name on local \n
run php vendor/bin/phpunit test/CheckoutTest.php
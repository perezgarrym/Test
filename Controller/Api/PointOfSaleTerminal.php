<?php
class PointOfSaleTerminal extends BaseController
{
    public $scaned = [];
    public $productModel;
    public $productDetails = [];
    function __construct() {
        $this->productModel = new ProductModel();
    }
    /**
     * "/user/list" Endpoint - Get list of users
     */
    public function list()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
 
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $arrProducts = $this->productModel->getProducts();
                $responseData = json_encode($arrProducts);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
 
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function checkout() {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $payload = json_decode(file_get_contents('php://input'), true);
        
        # will check payload code exists
        if (!isset($payload['code']) && $payload['code'] == '') {
            $strErrorDesc = 'Missing Param';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        if (strtoupper($requestMethod) == 'POST') {
            $codes = explode(",", $payload['code']);
            foreach($codes as $code) {
                $this->scanProduct($code);
            }

            $totalPrice = $this->calculateTotal();
            $res = [
                "scaned" => $payload['code'],
                "total" => $totalPrice
            ];
            $responseData = json_encode($res);
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    private function calculateTotal() {
        $totalPrice = 0;
            
        foreach($this->scaned as $productCode => $qty) {
            if (!isset($this->productDetails[$productCode])) {
                $prod = $this->productModel->getProduct($productCode);
                $this->productDetails[$productCode] = $prod;
            }

            $pd = $this->productDetails[$productCode];

            if ($pd['bulk_count'] != null) {
                # compute bulk price
                if ($qty >= $pd['bulk_count']) {
                    $pdBulkctr = $qty / $pd['bulk_count'];
                    $intBulkCtr = floor($pdBulkctr);
                    $totalPrice += $intBulkCtr * $pd['bulk_price'];

                    if (($qty % $pd['bulk_count']) != 0) {
                        $notInBulkQty = $qty - ($intBulkCtr*$pd['bulk_count']);
                        $totalPrice += $pd['unit_price'] * $notInBulkQty; 
                    } 
                } else {
                    $totalPrice += $pd['unit_price'] * $qty;
                }
            } else {
                $totalPrice += $pd['unit_price'] * $qty;
            }
        }

        return $totalPrice;
    }

    private function scanProduct($productCode) {
        if (!isset($this->scaned[$productCode])) {
            $this->scaned[$productCode] = 1;
        } else {
            $this->scaned[$productCode]++; 
        }
    }
}
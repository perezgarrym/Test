<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";
 
class ProductModel extends Database
{
    public function getProducts()
    {
        return $this->select("SELECT * FROM products ORDER BY id ASC");
    }

    public function getProduct($productCode) 
    {
        $res = $this->select("SELECT * FROM products where code = ? ORDER BY id ASC", ["s", $productCode]);
        return $res[0] ?? [];
    }
}
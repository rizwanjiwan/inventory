<?php

/**
 * Class Products Encapsulates work with the product table
 * Todo: Edit name, delete product
 */
class Products
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        session_start();
        $this->db=$db;
    }

    /**
     * Add a product with quantity 0 to start
     * @param $name string name
     * @return int the ID in the DB of the product
     */
    public function addProduct(string $name):int
    {
        $sql="insert into products (name,available) values (?,?)";
        $this->db->prepare($sql)->execute(array($name,0));
        return intval($this->db->lastInsertId());
    }


    /**
     * Add a quantity to a product
     * @param int $id the product id
     * @param int $amount ammount to add (pass negative number to subtract)
     * @return int
     * @throws Exception
     */
    public function addQuantity(int $id, int $amount):int
    {
        $product=$this->getProduct($id);
        if(count($product)===0)
            throw new Exception('Invalid product id');
        $updatedQuantity=self::quantity($product)+$amount;
        $sql="update products set available=? where id=?";
        $this->db->prepare($sql)->execute(array($updatedQuantity,$id));
        return $updatedQuantity;
    }

    /**
     * Get all products
     * @return array 2-d with outer being rows an inner being associative with the keys being the column names
     */
    public function getProducts():array
    {
         $stm=$this->db->prepare('select * from products');
         $stm->execute();
         return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get a single product row
     * @param int $id
     * @return array associative with the keys being the column names
     */
    public function getProduct(int $id):array
    {
        $stm=$this->db->prepare('select * from products where id=?');
        $stm->execute(array($id));
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get the name from a product row from the DB
     * @param array $row of string
     * @return string the name
     * @throws Exception on invalid row format
     */
    public static function name(array $row):string
    {
        if(array_key_exists('name',$row))
            return $row['name'];
        throw new Exception('Invalid row, missing name.');
    }

    /**
     * Get the quantity from a product row from the DB
     * @param array $row
     * @return int
     * @throws Exception on invalid row format
     */
    public static function quantity(array $row):int
    {
        if(array_key_exists('available',$row))
            return intval($row['available']);
        throw new Exception('Invalid row, missing available.');
    }
    /**
     * Get the id from a product row from the DB
     * @param array $row
     * @return int
     * @throws Exception on invalid row format
     */
    public static function id(array $row):int
    {
        if(array_key_exists('id',$row))
            return intval($row['id']);
        throw new Exception('Invalid row, missing id.');
    }
}
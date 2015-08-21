<?php
    /**
   * @backupGlobals disabled
   * @backupStaticAttributes disabled
   */

   require_once "src/Stylist.php";

   $server = 'mysql:host=localhost;dbname=hair_salon_test';
   $username = 'root';
   $password = 'root';
   $db = new PDO($server, $username, $password);

   class StylistTest extends PHPUnit_Framework_TestCase
   {
       function test_getName()
       {
           //Arrange
           $stylist_name = "Big Bird"
           $test_Stylist = new Stylist($stylist_name);

           //Act
           $result = $test_Stylist->getName();

           //Assert
           $this->assertEquals($stylist_name, $result);

       }
   }


 ?>

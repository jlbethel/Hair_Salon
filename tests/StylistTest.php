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
       function test_getStylistName()
       {
           //Arrange
           $stylist_name = "Big Bird";
           $test_Stylist = new Stylist($stylist_name);

           //Act
           $result = $test_Stylist->getStylistName();

           //Assert
           $this->assertEquals($stylist_name, $result);

       }

       function test_getId()
       {
           //Arrange
           $stylist_name = "Big Bird";
           $id = 1;
           $test_Stylist = new Stylist($stylist_name, $id);

           //Act
           $result = $test_Stylist->getId();

           //Arrange
           $this->assertEquals(true, is_numeric($result));
       }

       function test_save()
       {
           //Arrange
           $stylist_name = "Big Bird";
           $test_Stylist = new Stylist($stylist_name);
           $test_Stylist->save();

           //Act
           $result = Stylist::getAll();

           //Assert
           $this->assertEquals($test_Stylist, $result[0]);
       }

       function test_getALL()
       {
           //Arrange
           $stylist_name = "Big Bird";
           $stylist_name2 = "Araya Stark";
           $test_Stylist = new Stylist($stylist_name);
           $test_Stylist-> save();
           $test_Stylist2 = new Stylist($stylist_name2);
           $test_Stylist2-> save();

           //Act
           $result = Stylist::getAll();

           //Assert
           $thi->assertEquals([$test_category, $test_category2], $result);
       }
   }


 ?>

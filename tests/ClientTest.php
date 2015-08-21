<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Client.php";
    require_once "src/Stylist.php";

    $server = 'mysql:host=localhost;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ClientTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Client::deleteAll();
        }

        function test_getClientName()
        {
            //Arrange
            $client_name = "Harry Potter";
            $test_client = new Client($client_name);

            //Act
            $result = $test_client->getClientName();

            //Assert
            $this->assertEquals($client_name, $result);
        }

        function test_save()
        {
            //Arrange
            $client_name = "Harry Potter";
            $test_client = new Client($client_name);
            $test_client->save();

            //Act
            $result = Client::getAll();

            //Assert
            $this->assertEquals($test_client, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $client_name = "Harry Potter";
            $test_client = new Client($client_name);
            $test_client->save();

            $client_name2 = "Spock";
            $test_client2 = new Client($client_name2);
            $test_client2->save();

            //Act
            $result = Client::getAll();

            //Assert
            $this->assertEquals([$test_client, $test_client2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $client_name = "Harry Potter";
            $test_client = new Client($client_name);
            $test_client->save();

            $client_name2 = "Spock";
            $test_client2 = new Client($client_name2);
            $test_client2->save();

            //Act
            $result = Client::deleteAll();
            $result = Client::getAll();

            //Assert
            $this->assertEquals([], $result);
        }
    }
 ?>

<?php
    class Stylist
    {
        private $stylist_name;
        private $id;

        function __construct($stylist_name, $id = null)
        {
            $this->stylist_name = $stylist_name;
            $this->id = $id;
        }

        function setStylistName($new_name)
        {
            $this->stylist_name = (string) $new_name;
        }

        function getStylistName()
        {
            return $this->stylist_name;
        }
    }
 ?>

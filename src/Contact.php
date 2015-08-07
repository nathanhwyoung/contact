<?php

    class Contact
    {
        private $name;
        private $number;
        private $address;

        function __construct($name, $number, $address)
        {
            $this->name = $name;
            $this->number = $number;
            $this->address = $address;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function getNumber()
        {
            return $this->number;
        }

        function setNumber($new_number)
        {
            $this->number = $new_number;
        }

        function getAddress()
        {
            return $this->address;
        }

        function setAddress($new_address)
        {
            $this->address = $new_address;
        }

        function save()
        {
            array_push($_SESSION['list_of_contacts'], $this);
        }

        static function getAll()
        {
            return $_SESSION['list_of_contacts'];
        }

        static function deleteAll()
        {
            $_SESSION['list_of_contacts'] = array();
        }

    }

?>

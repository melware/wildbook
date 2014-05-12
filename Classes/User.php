<?php
/**
 * Created by PhpStorm.
 * User: Shannon
 * Date: 5/10/14
 * Time: 3:19 PM
 */

namespace wildbook {
    require_once('functions.php');
    class User {
        private $username;
        private $firstName;
        private $lastName;
        private $profilePictureDir;

        private $birhtdate;
        private $address;
        private $state;
        private $city;
        private $zip;

        private $friends = array();

        function __construct($username)
        {
            $this->username = $username;

            /*
             * Columns for populate_user
             *
             * 0 - email
             * 1 - firstname
             * 2 - lastname
             * 3 - gender
             * 4 - street
             * 5 - state
             * 6 - city
             * 7 - zipcode
             * 8 - birthdate
             *
             */

            $result = runStoredProcedure("populate_user", $username);
            $row = $result->fetch_assoc();

            $this->firstName    = $row['firstname'];
            $this->lastName     = $row['lastname'];
            $this->email        = $row['email'];
            $this->birhtdate    = $row['birthdate'];
            $this->address      = $row['street'];
            $this->state        = $row['state'];
            $this->city         = $row['city'];
            $this->zip          = $row['zipcode'];

        }

        /**
         * @param User $other
         * @return array of mutual friends
         */
        public function getMutualFriends(User $other)
        {
            return array_intersect($other->friends, $this->friends);
        }

        /**
         * Will wrap an <a> tag around the given string (usually a name), pointing to the user's profile
         * @param $str
         * @param $user
         *
         * @return string
         */
        public static function makeLink($str, $user)
        {
            return "<a href='users/{$user}'>{$str}</a>";
        }

        public function getUsername() { return $this->username; }
        public function getName() { return $this->firstName . " " . $this->lastName; }
        public function getNameLink() { return "<a href='users/{$this->username}'>{$this->getName()}</a>"; }
        public function getFirstName() { return $this->firstName; }
        public function getLastName() { return $this->lastName; }
        /**
         * @return mixed
         */
        public function getAddress()
        {
            return $this->address;
        }

        /**
         * @return mixed
         */
        public function getBirhtdate()
        {
            return $this->birhtdate;
        }

        /**
         * @return mixed
         */
        public function getCity()
        {
            return $this->city;
        }

        /**
         * @return array
         */
        public function getFriends()
        {
            return $this->friends;
        }

        /**
         * @return mixed
         */
        public function getProfilePictureDir()
        {
            return $this->profilePictureDir;
        }

        /**
         * @return mixed
         */
        public function getState()
        {
            return $this->state;
        }

        /**
         * @return mixed
         */
        public function getZip()
        {
            return $this->zip;
        }


    }
}
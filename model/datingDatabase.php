<?php
/*
 * CREATE TABLE `interest` (
  `interest_id` int(11) NOT NULL,
  `interest` varchar(50) DEFAULT NULL,
  `type` varchar(8) DEFAULT NULL
   PRIMARY KEY (interest_id)
)

CREATE TABLE `member` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `state` char(2) DEFAULT NULL,
  `bio` text,
  `premium` tinyint(1) DEFAULT NULL,
  `image` varchar(500) DEFAULT NULL
   PRIMARY KEY (member_id)
)

CREATE TABLE `member_interest` (
  `member_id` int(11) DEFAULT NULL,
  `interest_id` int(11) DEFAULT NULL,
   FOREIGN KEY (member_id) REFERENCES member(member_id),
   FOREIGN KEY (interest_id) REFERENCES interest(interest_id)
)
 */

class DatingDatabase
{
    function __construct()
    {
        require('/home/oringhis/datingConfig.php');
        try {
            $this->_db = new PDO(DB_DATING_DSN, DB_DATING_USERNAME, DB_DATING_PASSWORD);
            echo "connected!";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function getMembers()
    {
    }

    function getMember($member_id)
    {

    }

    function getInterests($member_id)
    {

    }
}
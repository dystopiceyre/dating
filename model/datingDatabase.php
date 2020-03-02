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
  `age` int(3) DEFAULT NULL,
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
    //PDO object
    private $_db;

    function __construct()
    {
        require('/home/oringhis/datingConfig.php');
        try {
            $this->_db = new PDO(DB_DATING_DSN, DB_DATING_USERNAME, DB_DATING_PASSWORD);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function getMembers()
    {
        $sql = "SELECT * FROM member";
        $statement = $this->_db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function getMember($member_id)
    {
        $sql = "SELECT * FROM member WHERE member_id = :member_id";
        $statement = $this->_db->prepare($sql);
        $statement->bindParam(':member_id', $member_id);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function createMember($member)
    {
        $sql = "INSERT INTO member (fname, lname, age, gender, phone, email, state, bio)
        VALUES (:fname, :lname, :age, :gender, :phone, :email, :state, :bio)";
        $statement = $this->_db->prepare($sql);
        $statement->bindParam(':fname', $member->getFname(), PDO::PARAM_STR);
        $statement->bindParam(':lname', $member->getLname(), PDO::PARAM_STR);
        $statement->bindParam(':age', $member->getAge(), PDO::PARAM_INT);
        $statement->bindParam(':gender', $member->getGender(), PDO::PARAM_STR);
        $statement->bindParam(':phone', $member->getPhone());
        $statement->bindParam(':email', $member->getEmail(), PDO::PARAM_STR);
        $statement->bindParam(':state', $member->getState(), PDO::PARAM_STR);
        $statement->bindParam(':bio', $member->getBio(), PDO::PARAM_STR);
        $statement = $this->_db->prepare($sql);
        $statement->execute();
        echo "Created a new member profile!";
        return $id = $this->_db->lastInsertId();
    }

    function premiumMember($premiumMember, $id)
    {
        $sql = "UPDATE member SET premium = :premium, image = :images WHERE member_id = :member_id";
        $statement = $this->_db->prepare($sql);
        $statement->bindParam(':premium', $premium = 1, PDO::PARAM_INT);
        $statement->bindParam(':image', $premiumMember->getImage(), PDO::PARAM_STR);
        $statement->bindParam(':member_id', $id, PDO::PARAM_INT);
        $statement = $this->_db->prepare($sql);
        $statement->execute();
        echo "added premium member info!";
    }

    function addInterests()
    {

    }

    function getInterests($member_id)
    {
        //need to expand to specify member
        $sql = "SELECT * FROM interest INNER JOIN member_interest ON member_interest.interest_id = interest.interest_id";
        $statement = $this->_db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function addSeeking()
    {
    }

    function getSeeking()
    {
    }

}
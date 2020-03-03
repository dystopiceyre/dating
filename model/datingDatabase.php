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
        $sql = "SELECT * FROM member ORDER BY lname";
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
        $sql = "INSERT INTO member(fname, lname, age, gender, phone, email, state, bio)
        VALUES (:firstName, :lastName, :age, :gender, :phone, :email, :state, :bio)";
        $statement = $this->_db->prepare($sql);
        $statement->bindParam(':firstName', $member->getFname(), PDO::PARAM_STR);
        $statement->bindParam(':lastName', $member->getLname(), PDO::PARAM_STR);
        $statement->bindParam(':age', $member->getAge(), PDO::PARAM_INT);
        $statement->bindParam(':gender', $member->getGender(), PDO::PARAM_STR);
        $statement->bindParam(':phone', $member->getPhone());
        $statement->bindParam(':email', $member->getEmail(), PDO::PARAM_STR);
        $statement->bindParam(':state', $member->getState(), PDO::PARAM_STR);
        $statement->bindParam(':bio', $member->getBio(), PDO::PARAM_STR);
        $statement->execute();
        echo "Created a new member profile!<br>";
        return $id = $this->_db->lastInsertId();
    }

    function premiumMember($premiumMember, $id)
    {
        $sql = "UPDATE member SET premium = :premium WHERE member_id = :member_id";
        $statement = $this->_db->prepare($sql);
        $statement->bindParam(':premium', $premium = 1, PDO::PARAM_INT);
        $statement->bindParam(':member_id', $id, PDO::PARAM_INT);
        $statement->execute();
        echo "Added premium member info!<br>";
    }

    function addInterests($id, $interest_id)
    {
        $sql = "INSERT INTO member_interest(member_id, interest_id)
        VALUES (:id, :interest)";
        $statement = $this->_db->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->bindParam(':interest', $interest_id, PDO::PARAM_INT);
        $statement->execute();
        echo "Added interest id" . $interest_id . "!<br>";
    }

    function getInterests($member_id)
    {
        $interestsString = "";
        $sql = "SELECT interest, type FROM interest INNER JOIN member_interest ON member_interest.interest_id 
                                                    = interest.interest_id AND member_id = :member_id";
        $statement = $this->_db->prepare($sql);
        $statement->bindParam(':member_id', $member_id, PDO::PARAM_INT);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $index => $arr) {
            foreach ($arr as $interests => $interest) {
                $interestsString .= $interest . " ";
            }
        }
        return trim($interestsString);
    }

    function addSeeking($id, $seeking_id)
    {
        $sql = "INSERT INTO member_seeking(member_id, seeking_id)
        VALUES (:id, :seeking_id)";
        $statement = $this->_db->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->bindParam(':seeking_id', $seeking_id, PDO::PARAM_INT);
        $statement->execute();
        echo "Added seeking info!<br>";
    }

    function getSeeking($member_id)
    {
        $seekingString = '';
        $sql = "SELECT seeking FROM seeking INNER JOIN member_seeking ON member_seeking.seeking_id =
                                                         seeking.seeking_id AND member_id = :member_id";
        $statement = $this->_db->prepare($sql);
        $statement->bindParam(':member_id', $member_id, PDO::PARAM_INT);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $index => $arr) {
            foreach ($arr as $seeking => $gender) {
                $seekingString .= $gender . " ";
            }
        }
        return trim($seekingString);
    }

}
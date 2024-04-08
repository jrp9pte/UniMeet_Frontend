<?php 

function getAccount($email)
{
    global $db;
    $query = "SELECT * FROM accounts WHERE email=:email";
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
}

function createAccount($email, $password, $first_name, $last_name)
{
    global $db;
    $hashed_pw = password_hash($password, PASSWORD_DEFAULT); 
    $query = "INSERT INTO accounts (email, password, first_name, last_name) VALUES (:email, :password, :first_name, :last_name)";
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $hashed_pw);
    $statement->bindValue(':first_name', $first_name);
    $statement->bindValue(':last_name', $last_name);
    $result = $statement->execute();
    $statement->closeCursor();
    return $result;
}

function getEventsByAccount($email)
{
    global $db;
    $query = "SELECT * FROM reservations NATURAL JOIN events NATURAL JOIN locations NATURAL JOIN club_of NATURAL JOIN clubs WHERE email=:email";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) 
    {
        $e->getMessage();
    } catch (Exception $e)
    {
        $e->getMessage();
    }
}

function getClubsByAccount($email)
{
    global $db;
    $query = "SELECT * FROM member_of NATURAL JOIN clubs NATURAL JOIN club_categories WHERE email=:email";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) 
    {
        $e->getMessage();
    } catch (Exception $e)
    {
        $e->getMessage();
    }
}

?>
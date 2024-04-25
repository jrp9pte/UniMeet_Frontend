<?php 

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

function createClub($club_description)
{
    global $db;
    $query = "INSERT INTO clubs (club_description) VALUES (:club_description)";
    $statement = $db->prepare($query);
    $statement->bindValue(':club_description', $club_description);
    $result = $statement->execute();
    $lastInsertedId = $db->lastInsertId();
    $statement->closeCursor();
    return $lastInsertedId;
}

function createClubCategory($club_id, $category_name)
{
    global $db;
    $query = "INSERT INTO club_categories (club_id, category_name) VALUES (:club_id, :category_name)";
    $statement = $db->prepare($query);
    $statement->bindValue(':club_id', $club_id);
    $statement->bindValue(':category_name', $category_name);
    $result = $statement->execute();
    $statement->closeCursor();
    return $result;
}

function createMember($club_id, $email, $privilege){
    global $db;
    $query = "INSERT INTO member_of (club_id, email, privilege) VALUES (:club_id, :email, :privilege)";
    $statement = $db->prepare($query);
    $statement->bindValue(':club_id', $club_id);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':privilege', $privilege);
    $result = $statement->execute();
    $statement->closeCursor();
    return $result;
}

function deleteMember($club_id, $email){
    global $db;
    $query = "DELETE FROM member_of WHERE club_id=:club_id AND email=:email";
    $statement = $db->prepare($query);
    $statement->bindValue(':club_id', $club_id);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
}

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

function getCategories()
{
    global $db;
    $query = "SELECT * FROM categories";
    try {
        $statement = $db->prepare($query);
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

function getClubByID($club_id)
{
    global $db;
    $query = "SELECT * FROM clubs NATURAL JOIN club_categories WHERE club_id=:club_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':club_id', $club_id);
        $statement->execute();
        $result = $statement->fetch();
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

function getClubIDsByAccount($email)
{
    global $db;
    $query = "SELECT club_id FROM member_of NATURAL JOIN clubs NATURAL JOIN club_categories WHERE email=:email";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_COLUMN, 0); //Transforms result into 1D array of Club IDs
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

function getClubs()
{
    global $db;
    $query = "SELECT * FROM clubs NATURAL JOIN club_categories";
    try {
        $statement = $db->prepare($query);
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

function getClubsByFilter($filter)
{
    global $db;
    $patternFilter = "%".$filter."%";
    $query = "SELECT * FROM clubs NATURAL JOIN club_categories WHERE club_description LIKE :patternFilter";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':patternFilter', $patternFilter);
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

function getEventsByAccount($email)
{
    global $db;
    $query = "SELECT * FROM reservations NATURAL JOIN events NATURAL JOIN event_categories NATURAL JOIN locations NATURAL JOIN club_of NATURAL JOIN clubs WHERE email=:email";
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

function getEventsByClub($club_id)
{
    global $db;
    $query = "SELECT * FROM club_of NATURAL JOIN events NATURAL JOIN locations NATURAL JOIN event_categories WHERE club_id=:club_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':club_id', $club_id);
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

function getMembersByClub($club_id)
{
    global $db;
    $query = "SELECT * FROM member_of WHERE club_id=:club_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':club_id', $club_id);
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

function updateMember($club_id, $email, $privilege){
    global $db;
    $query = "UPDATE member_of SET privilege=:privilege WHERE club_id=:club_id AND email=:email";
    $statement = $db->prepare($query);
    $statement->bindValue(':club_id', $club_id);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':privilege', $privilege);
    $statement->execute();
    $statement->closeCursor();
    // return $result;
}

?>
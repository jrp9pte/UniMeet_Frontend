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
// Stored procedure 
// function createEvent($location, $event_date, $event_description, $event_category){
//     global $db;
//     $query = "INSERT INTO events (location, event_date, event_description, event_category) VALUES (:location, :event_date, :event_description, :event_category)";
//     $statement = $db->prepare($query);
//     $statement->bindValue(':location', $location);
//     $statement->bindValue(':event_date', $event_date);
//     $statement->bindValue(':event_description', $event_description);
//     $statement->bindValue(':event_category', $event_category);
//     $result = $statement->execute();
//     $lastInsertedId = $db->lastInsertId();
//     $statement->closeCursor();
//     return $lastInsertedId;

// }

function createLocation($capacity, $location_address){
//    INSERT INTO locations(capacity, address) VALUES (capacity, address);
    global $db;
    $query = "INSERT INTO locations (capacity, location_address) VALUES (:capacity, :location_address)";
    $statement = $db->prepare($query);
    $statement->bindValue(':capacity', $capacity);
    $statement->bindValue(':location_address', $location_address);
    $result = $statement->execute();
    $lastInsertedId = $db->lastInsertId();
    $statement->closeCursor();
    return $lastInsertedId;
}

function getLocation($location_id){
    global $db;
    $query = "SELECT * FROM locations WHERE location_id=:location_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':location_id', $location_id);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
}

function getAllLocations(){
    global $db;
    $query = "SELECT location_id FROM locations";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}

function getEvent($event_id){
    global $db;
    $query = "SELECT * FROM events NATURAL JOIN locations NATURAL JOIN club_of WHERE event_id=:event_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':event_id', $event_id);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
}
// GetEvent(event_id):
// SELECT * FROM events NATURAL JOIN locations NATURAL JOIN club_of WHERE event_id=event_id;


// UpdateEventDescription(event_id, event_description);
// UPDATE events SET event_description=event_description WHERE event_id=event_id;

function updateEventDescription($event_id, $event_description){
    global $db;
    $query = "UPDATE events SET event_description=:event_description WHERE event_id=:event_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':event_id', $event_id);
    $statement->bindValue(':event_description', $event_description);
    $statement->execute();
    $statement->closeCursor();
}

//  8 UpdateEventDate(event_id, event_date);
// UPDATE events SET date=event_date WHERE event_id=event_id;
function updateEventDate($event_id, $event_date){
    global $db;
    $query = "UPDATE events SET event_date=:event_date WHERE event_id=:event_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':event_id', $event_id);
    $statement->bindValue(':event_date', $event_date);
    $statement->execute();
    $statement->closeCursor();
}
// 9 UpdateEventClub(event_id, club_id):
// DELETE FROM club_of WHERE event_id = event_id;
// INSERT INTO club_of(event_id, club_id) VALUES (event_id, club_id)
function updateEventClub($event_id, $club_id){
    global $db;
    $query = "DELETE FROM club_of WHERE event_id=:event_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':event_id', $event_id);
    $statement->execute();
    $statement->closeCursor();
    $query = "INSERT INTO club_of (event_id, club_id) VALUES (:event_id, :club_id)";
    $statement = $db->prepare($query);
    $statement->bindValue(':event_id', $event_id);
    $statement->bindValue(':club_id', $club_id);
    $statement->execute();
    $statement->closeCursor();
}

// 10 UpdateLocationCapacity(location_id, capacity):
// UPDATE locations SET capacity=capacity WHERE location_id=location_id;

function updateLocationCapacity($location_id, $capacity){
    global $db;
    $query = "UPDATE locations SET capacity=:capacity WHERE location_id=:location_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':location_id', $location_id);
    $statement->bindValue(':capacity', $capacity);
    $statement->execute();
    $statement->closeCursor();
}






?>
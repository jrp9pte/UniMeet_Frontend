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

// should be procedure
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

function getEventsByFilter($filter){
    global $db;
    $patternFilter = "%".$filter."%";
    $query = "SELECT * FROM events NATURAL JOIN locations NATURAL JOIN club_of WHERE event_description LIKE :patternFilter";
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

function getEventsByAccount($email){
    global $db;
    $query = "SELECT event_id FROM reservations NATURAL JOIN events NATURAL JOIN event_categories NATURAL JOIN locations NATURAL JOIN club_of NATURAL JOIN clubs WHERE email=:email";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        $ids = array_map(function($item) {
        return $item['event_id'];
}, $result);    
        return $ids;
        
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
function createEvent($location, $event_date, $event_description, $event_category, $user_email, $club){
    global $db;
    $query = "CALL CreateEvent(:location, :event_date, :event_description, :event_category :user_email :club)";
    $statement = $db->prepare($query);
    $statement->bindValue(':location', $location);
    $statement->bindValue(':event_date', $event_date);
    $statement->bindValue(':event_description', $event_description);
    $statement->bindValue(':event_category', $event_category);
    $statement->bindValue(':user_email', $user_email);
    $statement->bindValue(':club', $club);
    $result = $statement->execute();
    $lastInsertedId = $db->lastInsertId();
    $statement->closeCursor();
    return $lastInsertedId;

}

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

// 4
function getLocation($location_id){
    global $db;
    $query = "SELECT * FROM locations WHERE location_id=:location_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':location_id', $location_id);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    // will change given object
    // $json = json_encode($result, JSON_PRETTY_PRINT);
    //         echo "<script>
    //         console.log( $json);
    //         </script>";
    return $result;
}

function getAllLocations(){
    global $db;
    $query = "SELECT location_id FROM locations";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_COLUMN, 0);
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
// 11 GetAllEvents():
// SELECT * FROM events NATURAL JOIN club_of, NATURAL JOIN locations;

function getAllEvents(){
    global $db;
    $query = "SELECT * FROM events NATURAL JOIN club_of NATURAL JOIN locations";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}
// 12 GetAllEventsUserIsAdminOf(user_email):
// SELECT T1.event_id, T1.location_id, T1.date, T1.event_description FROM events T1 JOIN admin_of T2 ON T1.event_id = T2.event_id WHERE T2.email = user_email;

function getAllEventsUserIsAdminOf($user_email){
    global $db;
    $query = "SELECT T1.event_id, T1.location_id, T1.date, T1.event_description FROM events T1 JOIN admin_of T2 ON T1.event_id = T2.event_id WHERE T2.email = :user_email";
    $statement = $db->prepare($query);
    $statement->bindValue(':user_email', $user_email);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    $ids = array_map(function($item) {
        return $item['event_id'];
    }, $result);    
    return $ids;
}

// 13 GetClub(club_id):
// SELECT * FROM clubs WHERE club_id=club_id;

function getClub($club_id){
    global $db;
    $query = "SELECT * FROM clubs WHERE club_id=:club_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':club_id', $club_id);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
}

// 14 GetAllClubs():
// SELECT * FROM clubs;

function getAllClubs(){
    global $db;
    $query = "SELECT * FROM clubs";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}

// 15 GetLocationIDFromEvent(event_id):
// SELECT l.location_id FROM events e JOIN locations l ON e.location_id = l.location_id WHERE e.event_id = event_id;

function getLocationIDFromEvent($event_id){
    global $db;
    $query = "SELECT l.location_id FROM events e JOIN locations l ON e.location_id = l.location_id WHERE e.event_id = :event_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':event_id', $event_id);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
}

// Idk if we still need this one
// 16 CreateUser(username, password):
// INSERT INTO accounts (email, password) VALUES (username, password);
// function createUser($username, $password){
//     global $db;
//     $query = "INSERT INTO accounts (email, password) VALUES (:username, :password)";
//     $statement = $db->prepare($query);
//     $statement->bindValue(':username', $username);
//     $statement->bindValue(':password', $password);
//     $result = $statement->execute();
//     $statement->closeCursor();
//     return $result;
// }

// Idk if we still need this one
// // 17 ValidateUser(user_email, password): 
// After executing query below, check if query returns value > 0, return true, else, false
// SELECT COUNT(*) FROM accounts WHERE email = user_email AND password = password;
// function validateUser($user_email, $password){
//     global $db;
//     $query = "SELECT COUNT(*) FROM accounts WHERE email = :user_email AND password = :password";
//     $statement = $db->prepare($query);
//     $statement->bindValue(':user_email', $user_email);
//     $statement->bindValue(':password', $password);
//     $statement->execute();
//     $result = $statement->fetch();
//     $statement->closeCursor();
//      return $result > 0;
//     return $result;
// }

// 18 GetCapacity(location_id): 
// SELECT capacity FROM locations WHERE location_id = location_id;
function getCapacity($location_id){
    global $db;
    $query = "SELECT capacity FROM locations WHERE location_id = :location_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':location_id', $location_id);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
}

// 19 GetAllAdminsGivenEvent(event_id):
// SELECT * FROM admin_of WHERE event_id = event_id;
function getAllAdminsGivenEvent($event_id){
    global $db;
    $query = "SELECT * FROM admin_of WHERE event_id = :event_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':event_id', $event_id);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}

// 20 AddAdminforEvent(event_id, admin_email):
// Check if exists first
// INSERT INTO admin_of (event_id, email) VALUES (event_id, admin_email);
// function addAdminforEvent($event_id, $admin_email){
//     // check if event exists and if an admin is already assigned to the event
//     global $db;
//     $event_exists  = getEvent($event_id);
//     $admin_exists = getAccount($admin_email);
//     if(!$event_exists || !$admin_exists){
//         return false;
//     }
//     $query = "INSERT INTO admin_of (event_id, email) VALUES (:event_id, :admin_email)";

//     $statement = $db->prepare($query);
//     $statement->bindValue(':event_id', $event_id);
//     $statement->bindValue(':admin_email', $admin_email);
//     $result = $statement->execute();
//     $statement->closeCursor();
//     return $result;
// }

// 21 UpdatePassword(email, password):
// UPDATE accounts SET password = password WHERE email = email;

//22 UpdateFirstName(user_email, new_first_name):
// UPDATE accounts SET first_name = new_first_name WHERE email = user_email;

// 23 UpdateLastName(user_email, last_name):
// UPDATE accounts SET last_name = last_name WHERE email = user_email;

// 24 GetReservations(user_email):
// SELECT * FROM reservations WHERE email = user_email;
function getReservations($user_email){
    global $db;
    $query = "SELECT * FROM reservations WHERE email = :user_email";
    $statement = $db->prepare($query);
    $statement->bindValue(':user_email', $user_email);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}

// 25 IsMyEvent(event_id, user_email):
// After executing query below, check if query returns value > 0, return true, else, false
// SELECT COUNT(*) FROM admin_of WHERE event_ID = event_id AND email = user_email;
function isMyEvent($event_id, $user_email){
    // echo "<script>console.log('In isMyEvent');</script>";
    global $db;
    $query = "SELECT COUNT(*) FROM admin_of WHERE event_id = :event_id AND email = :user_email";
    $statement = $db->prepare($query);
    $statement->bindValue(':event_id', $event_id);
    $statement->bindValue(':user_email', $user_email);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result[0] > 0;
}

// 26 DeleteAdminFromEvent(admin_email, event_id):
// DELETE FROM admin_of WHERE event_id = event_id AND email = admin_email;
function deleteAdminFromEvent($admin_email, $event_id){
    global $db;
    $query = "DELETE FROM admin_of WHERE event_id = :event_id AND email = :admin_email";
    $statement = $db->prepare($query);
    $statement->bindValue(':event_id', $event_id);
    $statement->bindValue(':admin_email', $admin_email);
    $statement->execute();
    $statement->closeCursor();
    // check if admin is deleted or no error
}

// 27 DeleteEvent(event_id):
// Delete all reservations and admins and relating information
// DELETE FROM events WHERE event_id = event_id;

// 28 DeleteReservation(user_email, event_id):
// Check if not admin
// DELETE FROM reservations WHERE email = user_email AND event_id = event_id;
function deleteReservation($user_email, $event_id){
    $json = json_encode((isMyEvent($event_id, $user_email)), JSON_PRETTY_PRINT);
            echo "<script>
            console.log( $json);
            </script>";
    if (isMyEvent($event_id, $user_email)){
        return false;
    }
    global $db;
    $query = "DELETE FROM reservations WHERE email = :user_email AND event_id = :event_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':user_email', $user_email);
    $statement->bindValue(':event_id', $event_id);
    $statement->execute();
    $statement->closeCursor();
    return true;
}

// 29 DeleteUser(user_email):
// Check if not sole admin of club or event
// Remove reservations
// Delete user
// DELETE FROM accounts WHERE email = user_email;

//30 DeleteLocation(location_id):
// Check if location is not used for any events
// DELETE FROM locations WHERE location_id = location_id;
// Might have bug with this way im checking
// function deleteLocation($location_id){
// // if getEvent($location_id);
// if (getEvent($location_id)){
// return false;
// }
// global $db;
// $query = "DELETE FROM locations WHERE location_id = :location_id";
// $statement = $db->prepare($query);
// $statement->bindValue(':location_id', $location_id);
// $statement->execute();
// $statement->closeCursor();
// }

//31 DeleteClub(club_id):
// Check if club is not already associated with any event
// Delete relationship in club_categories table that is associated with this club
// DELETE FROM clubs WHERE club_id = club_id;

// 32 AddClubCategory(club_id, club_category):
// Check if exists
// INSERT INTO club_categories( club_category, club_id) VALUES ( club_category, club_id);
// function addClubCategory($club_id, $club_category){
// // Do check if club exists and category exists
// global $db;
// $query = "INSERT INTO club_categories (club_id, category_name) VALUES (:club_id, :club_category)";
// $statement = $db->prepare($query);
// $statement->bindValue(':club_id', $club_id);
// $statement->bindValue(':club_category', $club_category);
// $result = $statement->execute();
// $statement->closeCursor();
// return $result;
// }

// 33 RemoveClubCategory(club_id, club_category):
// DELETE FROM club_categories WHERE club_id = club_id AND category_name = club_category;
function removeClubCategory($club_id, $club_category){
    global $db;
    $query = "DELETE FROM club_categories WHERE club_id = :club_id AND category_name = :club_category";
    $statement = $db->prepare($query);
    $statement->bindValue(':club_id', $club_id);
    $statement->bindValue(':club_category', $club_category);
    $statement->execute();
    $statement->closeCursor();
}

// 34 AddEventCategory(event_id, event_category):
// INSERT INTO event_categories(event_id, category_name) VALUES (event_id, event_category);
function addEventCategory($event_id, $event_category){
    global $db;
    $query = "INSERT INTO event_categories (event_id, category_name) VALUES (:event_id, :event_category)";
    $statement = $db->prepare($query);
    $statement->bindValue(':event_id', $event_id);
    $statement->bindValue(':event_category', $event_category);
    $result = $statement->execute();
    $statement->closeCursor();
    return $result;
}

// 35 RemoveEventCategory(event_id, event_category):
// DELETE FROM event_categories WHERE club_id = club_id AND category_name = event_category;
function removeEventCategory($event_id, $event_category){
    global $db;
    $query = "DELETE FROM event_categories WHERE event_id = :event_id AND category_name = :event_category";
    $statement = $db->prepare($query);
    $statement->bindValue(':event_id', $event_id);
    $statement->bindValue(':event_category', $event_category);
    $statement->execute();
    $statement->closeCursor();
    }

// 36 GetClubCategories(club_id):
// SELECT category_name FROM club_categories WHERE club_id = club_id;
function getClubCategories($club_id){
    global $db;
    $query = "SELECT category_name FROM club_categories WHERE club_id = :club_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':club_id', $club_id);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}

// 37 GetEventCategories(event_id):
// SELECT category_name FROM event_categories WHERE event_id = club_id;
function getEventCategories($event_id){
global $db;
$query = "SELECT category_name FROM event_categories WHERE event_id = :event_id";
$statement = $db->prepare($query);
$statement->bindValue(':event_id', $event_id);
$statement->execute();
$result = $statement->fetchAll();
$statement->closeCursor();
return $result;
}

// 38 UpdateClubCategory(club_id, club_category):
// No sql just use AddclubCategory and RemoveClubCategory
// function updateClubCategory($club_id, $club_category){
// removeClubCategory($club_id, $club_category);
// addClubCategory($club_id, $club_category);
// }

//39 UpdateEventCategory(event_id, list_event_category):
// No sql just use AddEventCategory and RemoveEventCategory
function updateEventCategory($event_id, $event_category){
removeEventCategory($event_id, $event_category);
addEventCategory($event_id, $event_category);
}

// 40 CreateReservation(user_email, event_id):
// Check IsMyEvent(event_id, user_email)
// Check HasReservation(user_email, event_id)
// INSERT INTO reservations(event_id, email) VALUES (event_id, user_email);
function createReservation($event_id, $user_email ){

    // echo "<script>
    // console.log('In createReservation'); < /script>";
    // // $ismyevent = isMyEvent($event_id, $user_email)
    // // echo "<script>console.log('$ismyevent ');
    // </script>";
    var_dump(isMyEvent($event_id, $user_email));
    $json = json_encode((isMyEvent($event_id, $user_email)), JSON_PRETTY_PRINT);
        echo "<script>
                console.log( $json);
            </script>";
    if (isMyEvent($event_id, $user_email)){
    return false;
    }
    if(isMyEvent($event_id, $user_email)){
        return false;
    }
    if(hasReservation($user_email, $event_id)){
        return false;
    }
    global $db;
    $query = "INSERT INTO reservations (event_id, email) VALUES (:event_id, :user_email)";
    $statement = $db->prepare($query);
    $statement->bindValue(':event_id', $event_id);
    $statement->bindValue(':user_email', $user_email);
    $result = $statement->execute();
    $statement->closeCursor();
    return $result;
}

//41 hasReservation(user_email, event_id):
// After executing query below, check if query returns value > 0, return true, else, false
// SELECT COUNT(*) FROM reservations WHERE email = user_email AND event_id = event_id;
function hasReservation($user_email, $event_id){
    global $db;
    $query = "SELECT COUNT(*) FROM reservations WHERE email = :user_email AND event_id = :event_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':user_email', $user_email);
    $statement->bindValue(':event_id', $event_id);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result[0] > 0;
}

function getEventCurrentCapacity($event_id){
global $db;
$query = "SELECT COUNT(*) FROM reservations WHERE event_id = :event_id";
$statement = $db->prepare($query);
$statement->bindValue(':event_id', $event_id);
$statement->execute();
$result = $statement->fetch();
$statement->closeCursor();
return $result[0];
}

function getReservationsForEvent($event_id) {
    global $db;
    $query = "SELECT a.first_name, a.last_name, a.email FROM reservations r NATURAL JOIN accounts a WHERE r.event_id = :event_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':event_id', $event_id);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}

function getEventDetails($event_id) {
    global $db;
    $query = "SELECT e.event_id, e.event_description, c.club_description, l.address, l.capacity, c.club_id, cc.category_name FROM events e NATURAL JOIN locations l NATURAL JOIN club_of NATURAL JOIN clubs c NATURAL JOIN club_categories cc WHERE e.event_id = :event_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':event_id', $event_id);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
}
<?php


//what are we using PHP for
//in PHP you cant make a json obj. like in javascript, so you need to create a txt/json file
//which you can decode as an object, and encode back as text

//what are we using javascript for
//in javascript we can use jquery and ajax together, to fetch data from an api
//in js we can access the json, that we fetch via ajax, and work with it as objects

//what are we using ajax for
//We use ajax on form submits, and for updating data in the 'background'
//I have also used ajax to output a message from the API backend to the user frontend
//Some places I have used ajax to request data from the server, and update the data to the frontend
//I am checking if the server data is the same as in the frontend with a set interval function
//if the data is not the same - i am changing it to whatever is in the server, which is the newest data


//***************** TESTING APIS ***********************************
//ALWAYS TEST THE API FIRST - THEN THE PAGE
//TO TEST THE API, FIRST TEST THE API FILE, (go to the site in browser) (echo something)
//THEN YOU TEST IT WITH JAVASCRIPT



// ********* RETURN FUNCTION IN PHP *****************************************************
// return function
// make a function return something
// function returnSomething($sName){
//     return "hello $sName";
// }
// echo $output = returnSomething('pernille');

// return a sum of 2 numbers
// function sum($iNumberA, $iNumberB){
//     return $iNumberA + $iNumberB;
// }
// echo sum(3, 20);

// ********* VOID FUNCTION IN PHP *****************************************************
//does not return anything, just echo it
// $sName = 'Pernille';

// function fnvSomething($sName){
//     echo $sName;
// }
// fnvSomething($sName);


// ********** For each loop ****************************************************

//foreach loop
//takes an array and loops through it
//doesnt have to count in the array - it stops when there is nothing more left in the array

// ********** Associative arrays ****************************************************

//because our data structure is nested json objects, 
//I have used associative arrays to access the keys and values of the objects
//JSON stands for Javascript Object, and thats what we are working with as database


// ********** For loop *************************************************************

//Create a system that takes 2 arguments, name and number, 
//based on the name, make the name appear the number of times (via a get)

// Postman - GET
// localhost/exams?name=x&number=10

// Php file
// $sName = $_GET[‘name’]
// $iNumber = $_GET[‘number’]
// Echo the name and number

//because you want me to repeat something a number of times, I should use a loop

// a for loop takes 3 arguments (counting from ; counting to ; how to count (++ increment by 1 for each loop))
// for ($i=0; $i < $iNumber; $i++) {
//       echo "$sName\n";
// }


// extra : Validate name and number
// Name should be at least 2 characters
// if(strlen($sName) < 2 ){
//    echo 'name should be at least 2 characters';
// }else{
//    for( $i = 0; $i < $iNumber; $i++){
//        echo "$sName\n";
//    }
// }

// ************** EXAM QUESTIONS ***********************************************

// Question based on the project:
// Create a bug in the code
// Send a positive json response when password is above 5 characters
    // $sPassword = $_POST['txtSignupPassword'] ?? '';
    // if( empty($sPassword) ){ fnvSendResponse(0, __LINE__,'Password field cant be empty');  }
    // if( strlen($sPassword) < 4 ){ fnvSendResponse(0, __LINE__,'Password has to be at least 4 characters'); }
    // if( strlen($sPassword) > 5 ){ fnvSendResponse(1, __LINE__,'Password correct'); }
// (test in test.php with postman - remember to copy the function with response)

// ***********************************************************************

// Use something else than new std class
// json_decode(‘{}’);
//show the structure when signing up with both

// ***********************************************************************

// Add a new element in the database
// Add a new field “nickname”, that will always be the letter X
// in signup.php
// $jClient->nickname = 'x';

// ***********************************************************************

// Create an api that takes 3 arguments, a, b, c
// In postman, pass the a,b,c values in

// Postman
// localhost:8080/api-exam
// Choose Post
// Key : a, b, c
// I’ts the ‘name’ in a form


// ***************  OUTPUT DATA ON SCREEN ***************************************
// $sData = file_get_contents('data/clients.json');
// $jData = json_decode($sData);
// if($jData == null){echo 'json not right';}
// $jInnerData = $jData->data;

// foreach($jInnerData as $jClient){
//     echo "
//         <div>
//             <div>name: $jClient->name </div>
//             <div>name: $jClient->balance </div>
//             <div>name: $jClient->email </div>
//         </div>
//     ";
// }

// **************** JSON DECODE/ENCODE *************************************

// //open the file
// $sData = file_get_contents('data/clients.json');
// // echo $sData;
// $jData = json_decode($sData);
// if($jData == null){echo 'system update';}

//convert back to string
// $sData = json_encode($jData);
//put it in the file
// file_put_contents('data/clients.json' $sData);

// ****** OUTPUT SOMETHING IN THE OBJECT WITHOUT HAVING THE USER ID/PHONE ********

// $sData = file_get_contents('data/clients.json');
// $jData = json_decode($sData);
// if($jData == null){echo 'system update';}
// $jInnerData = $jData->data;

// CLOSE PHP TAG
// OPEN HTML TAG
// INSIDE BODY -> OPEN PHP 

// foreach( $jInnerData as $sUserId => $jClient ){
//     echo "
//         <div>{$jClient->name}</div>
//     ";
// }


// *************** GET VALUE OF FORM IN JS *******************************

// <form id="frmTest" action="">
//     <input type="text" name="name" id="name">
//     <button>submit</button>
// </form>

// <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
// <script>
//     $('#frmTest').submit(function(){
//         let name = $('#name').val();
//         console.log(name)
//     })
// </script>


// *************** MAKE NEW OBJECT *******************************
//make object without new std class and json_encode('{}') - php knows the structure
// $jClient->accountName = "AA";
// $jAccount->balance = 20;
// $jClient->accounts = $jAccount;
// echo json_encode($jClient);


// $jClient = new stdClass();
// $jClient->name = "AA";
// $jClient->age = "18";
// echo json_encode($jClient);

//MAKE THIS STRUCTURE IN OBJECT
// "accounts": {
//   "5c62d64541460": {
//       "balance": 0
// }
// $jClient->accounts = new stdClass();
// $jAccountId = uniqid();
// $jAccount = new stdClass();
// $jAccount->balance = 20;
// $jClient->accounts->$jAccountId = $jAccount;
// echo json_encode($jClient);


// Make this structure: "111":{"name":"A"}
// $sPhone = "111";
// $jClient = new stdClass();
// $jClient->$sPhone = new stdClass();
// $jClient->$sPhone->name = 'AA';
// echo json_encode($jClient);

// ***************** MAKE THIS STRUCTURE IN OBJECT ************************************

// "5c756226c702d": {
//     "name": "aaa",
//     "age": "25",
//     "address": "kbh"
// }

// $sName = $_POST['name'];
// $sAge = $_POST['age'];
// $sAddress = $_POST['address'];

// $sData = file_get_contents('data/data.json');
// $jData = json_decode($sData);


// $sUserId = uniqid();
// $jData->$sUserId = new stdClass();

// $jUser = new stdClass();
// $jUser->name = $sName;
// $jUser->age = $sAge;
// $jUser->address = $sAddress;

// $jData->$sUserId = $jUser;

// when making a nested object inside an existing bject
//you dont hav to make a new std class for the ID, just put it in the structure
// $sAccountId = uniqid();
// $jUser->accounts = new stdClass();
// $jAccount->balance = 20;
// $jAccount->active = 0;e

// $jData->$sUserId->accounts->$sAccountId = $jAccount;

// // echo json_encode($jUser);

// $sFinalData = json_encode($jData, JSON_PRETTY_PRINT);
// file_put_contents('data/data.json', $sFinalData);


// foreach($jData as $jUser){
//     echo "
//     <div>$jUser->name</div>
//     <div>$jUser->age</div>
    
//     ";
// }


// *************** ARRAYS IN PHP *******************************
// $aLetters = [];
// array_push($aLetters, "a","b","c");
// echo json_encode($aLetters);

// $aLetters = [];
// $aLetters['one'] = "a";
// // print_r($aLetters);
// // echo json_encode($aLetters);


// **************** VALIDATION IN PHP *******************************
// $jClient->price = 20;
// if(!$jClient->price){
//     echo 'no price';
// }
// echo $jClient->price;


// $sName = $_GET['name'];
// if( empty($sName) ){ echo 'cant be empty'; }
// if( strlen($sName) < 2 ){ echo 'at least 2 characters'; }
// echo 'all good';

// *****************************************************************
//add a number to it self , the amount of the number
// function addNumber($iNumber){
//     $iFinalNumber = 0;    
//     for ($i=0; $i < $iNumber; $i++) { 
//         //$iFinalNumber = $iFinalNumber + $iNumber;
//         $iFinalNumber += $iNumber;
//     }
//     return $iFinalNumber;
// }
// echo addNumber(10);


// get name and last name, make a function that concats them to full name
// $sName = $_GET['name'];
// $sLastName = $_GET['lastName'];

// function getFullName($first, $last){
//      $fullName = $first." ".$last;

//     echo $fullName;
// }
// getFullName($sName, $sLastName);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

  

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>

//2 params + concatenate
// function displayName(sName, sLastName){
//     let message = 'your name is '+sName+' and your last name is '+sLastName
//     console.log(message)
// }
// displayName('pernille', 'lee')

//3 params + concatenate
// function showData(sName, sLastName, iYear){
//     let data = 'your name is '+sName+' and your last name is '+sLastName+' and you are '+iYear+' years old'
//     console.log(data)
// }
// showData('pernille','lee','25')

//void function in javascript
// function displaySomething(){
//     console.log('A')
// }
// displaySomething()

//return function in javascript
// function sum(iNumberHere, iNumberThere){
//     let iTotal = iNumberHere + iNumberThere
//     return iTotal
// }
// console.log(sum(10, 20))


// function fullName(sName, sLastName){
//     let fullName = sName + sLastName
//     return fullName
// }
// console.log(fullName('pernille', 'lee'))

//make 2 buttons in HTML with same class
// $('.button').click(function(){
//     console.log($(this))
// })


//json (javascript object)
//add a key to an object in js
// let person = {
//     "name":"A",
//     "lastName":"B"
// }
// person.nickName = "C"
// console.log(person)

//get length of something in js (strlen(variable) in php)
// let name = 'pernille'
// console.log(name.length)



// Lav en funktion der tager en bruger som så oprettet den samme bruger 10 gange i databasen 
// $sName = $_GET['name'];

// $sData = file_get_contents('data/data.json');
// $jData = json_decode($sData);

// function getName($sUsername, $iNumUsers){
    
//     for($i=0; $i < $iNumUsers; $i++){
//         $sUserId = uniqid();
//         $jData->$sUserId = new stdClass();

//         $jUser = new stdClass();
//         $jUser->name = $sUsername;
//         $jData->$sUserId = $jUser;

//         $sFinalData = json_encode($jData, JSON_PRETTY_PRINT);
//         file_put_contents('data/data.json', $sFinalData);
//     }
// }

// getName($sName, 10);







</script>
</body>
</html>









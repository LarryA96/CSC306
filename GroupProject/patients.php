/* Name: Larry Alston
   Class: CSC306
   Date: 7/17/2026
*/

<?php

//Function to create date of birth
function Birth(){
    //Randomly generate date so patient is 18+
    $youngest = strtotime("-18 years");
    $oldest = strtotime("-60 years");
    return date("F j, Y", mt_rand($oldest, $youngest));
}

//Function to create phone number, accepting area code as the parameter
function Phone($areaCode){
    //Randomly create 3-digit code
    $middle = (string)rand(0,9).(string)rand(0,9).(string)rand(0,9);

    //Randomly create 4-digit code
    $end = (string)rand(0,9).(string)rand(0,9).(string)rand(0,9).(string)rand(0,9);

    //Prep array for join method
    $phone = [$middle, $end];

    //Combine into (xxx) xxx-xxxx format
    return "($areaCode) ".join("-", $phone);
}

//Function to create full name [first, last]
function Name(){
    $first = ["Ethan", "Harper", "Mason", "Evelyn", "Logan", "Ella", "Avery", "Aria", "Jackson", "Scarlett", 
    "Lucas", "Chloe", "Oliver", "Layla", "Jack", "Penelope", "Ryan", "Lina", "Owen", "Nora", "Liam", "Olivia", 
    "Noah", "Emma", "Oliver", "Ava", "Elijah", "Charlotte", "William", "Sophia", "James", "Amelia", "Benjamin", 
    "Isabella", "Lucas", "Mia", "Henry", "Evelyn", "Alexander", "Harper", "James", "Mary", "John", "Patricia", 
    "Robert", "Jennifer", "Michael", "Linda", "William", "Elizabeth", "David", "Barbara", "Richard", "Susan", 
    "Joseph", "Jessica", "Thomas", "Sarah", "Charles", "Karen"];

    $last = ["Smith","Johnson","Williams","Brown","Jones","Garcia","Miller","Davis","Rodriguez","Martinez",
    "Hernandez","Lopez","Gonzalez","Wilson","Anderson","Thomas","Taylor","Moore","Jackson","Martin","Lee",
    "Perez","Thompson","White","Harris","Sanchez","Clark","Ramirez","Lewis","Robinson"];

    $ranF = rand(0, count($first) -1);
    $ranL = rand(0, count($last) -1);

    return ["$first[$ranF]", "$last[$ranL]"];
}

//Function to create email address from name
function Email($first, $last){
    //Create list of domains to use
    $domains = ["@hotmail.com", "@gmail.com", "@yahoo.com", "@outlook.com", "@icloud.com"];

    //Create random number to decide domain handle and naming method
    $ranD = rand(0, count($domains) -1);
    $ranNum = rand(0,2);

    //Email naming methods 
    switch($ranNum){
        case 0:
            $email = strtolower("$first$last$domains[$ranD]");
            break;
        case 1:
            $email = strtolower("$first[0]$last$domains[$ranD]");
            break;
        case 2: 
            $email = strtolower("$first$last[0]$domains[$ranD]");
            break;
    }

    return $email;
}

function Insurance(){
    $providers = ["Guardian", "Ameritas", "Cigna", "Delta Dental", "Humana"];
    return $providers[rand(0, count($providers) -1)];
}

function Address(){
    //List of cities and states
    $cities = [
    ["212", "New York", "NY"],["213", "Los Angeles", "CA"],["312", "Chicago", "IL"],["713", "Houston", "TX"],
    ["602", "Phoenix", "AZ"],["215", "Philadelphia", "PA"],["210", "San Antonio", "TX"],["619", "San Diego", "CA"],
    ["214", "Dallas", "TX"],["408", "San Jose", "CA"],["512", "Austin", "TX"],["904", "Jacksonville", "FL"],
    ["817", "Fort Worth", "TX"],["614", "Columbus", "OH"],["704", "Charlotte", "NC"],["415", "San Francisco", "CA"],
    ["317", "Indianapolis", "IN"],["206", "Seattle", "WA"],["303", "Denver", "CO"],["202", "Washington", "DC"],
    ["617", "Boston", "MA"],["313", "Detroit", "MI"],["615", "Nashville", "TN"],["504", "New Orleans", "LA"],
    ["702", "Las Vegas", "NV"],["414", "Milwaukee", "WI"],["804", "Richmond", "VA"],["918", "Tulsa", "OK"],
    ["402", "Omaha", "NE"],["808", "Honolulu", "HI"]
    ];

    //Collection of street names
    $streets =["Main St.","Market St.","Oak St.","Maple St.","Pine St.","Elm St.","Cedar St.","Walnut St.",
    "Chestnut St.","River St.","Hill St.","Lake St.","Park St.","Washington St.","Jefferson St.","Lincoln St.",
    "Franklin St.","Madison St.","Adams St.","Jackson St.","Sunset Dr.","Meadow Dr.","Forest Dr.","Valley Dr.",
    "Highland Dr.","Ridge Dr.","Brookside Dr.","Creek Dr.","Willow Dr.","Magnolia Dr.","Park Ave.","Central Ave.",
    "Grand Ave.","Liberty Ave.","College Ave.","Broadway Ave.","Prospect Ave.","Highland Ave.","Victoria Ave.",
    "Union Ave.","Martin Luther King Jr. Blvd.","Commerce Blvd.","Memorial Blvd.","Presidential Blvd.","Veterans Blvd.",
    "Lakeside Blvd.","Sunrise Blvd.","Gateway Blvd.","Heritage Blvd.","Independence Blvd.","Ash Cir.","Birch Cir.",
    "Dogwood Cir.","Holly Cir.","Juniper Cir.","Laurel Cir.","Sycamore Cir.","Spruce Cir.","Evergreen Cir.","Orchard Cir.",
    "Acorn Ct.","Fox Ct.","Hawthorn Ct.","Kingfisher Ct.","Stone Ct.","Whispering Ct.","Hidden Ct.","Harvest Ct.","Pebble Ct.",
    "Cypress Ct."];

    //Choose a random city
    $city = $cities[rand(0, count($cities) -1)];

    //Generate street address elements
    $streetNumber = (string)rand(1, 2000);
    $streetName = $streets[rand(0, count($streets) -1)];
    $cityState = "$city[1], $city[2]";

    //Combine elements into address string
    $address = "$streetNumber $streetName $cityState";

    return [$address, $city[0]];
}

function Age($birth){
    $date = new DateTime($birth);
    $age = new DateTime();
    $age = $age -> diff($date);
    return $age -> format("%y years old");
}


//Function to generate and insert patient data 
$patientList = fopen(__DIR__."/patientList.csv" , "w") or die("Error: Could not open file.");

if ($patientList){
   
    //Insert headers
    fputcsv($patientList, ["Name", "Age", "Email", "D.O.B", "Phone", "Insurance", "Address", "Patient_ID"]);

    //Insert patient data rows
    for($i = 1; $i <= 100; $i++){

        //Call functions for the fields
        $pName = Name();
        $pEmail = Email($pName[0], $pName[1]);
        $pBirth = Birth();
        $pAge = Age($pBirth);
        $pInsurance = Insurance();
        $pAddress = Address();
        $pPhone = Phone($pAddress[1]);

        //Write data to line
        fputcsv($patientList, [join(" ", $pName), $pAge, $pEmail, $pBirth, $pPhone, $pInsurance, $pAddress[0]], $i);
    };
} else {
    die("Error: file couldn't be edited.");
};

fclose($patientList);

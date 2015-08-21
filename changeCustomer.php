<?php
session_start();
$time = time();
require "config.php";
$sql="select * from customer where username='".$_SESSION['username']."' AND password='".$_SESSION['password']."';";
$res=mysql_query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <link href="style/style.css" rel="stylesheet" type="text/css">
    <script>



        function checkField(x){

            email= x.email.value;
            phone= x.phone.value;
            bState= x.bState.value;
            State= x.State.value;
            var states = [
                "AL", "AK", "AZ", "AR", "CA", "CO", "CT", "DE", "FL", "GA",
                "HI", "ID", "IL", "IN", "IA", "KS", "KY", "LA", "ME", "MD",
                "MA", "MI", "MN", "MS", "MO", "MT", "NE", "NV", "NH", "NJ",
                "NM", "NY", "NC", "ND", "OH", "OK", "OR", "PA", "RI", "SC",
                "SD", "TN", "TX", "UT", "VT", "VA", "WA", "WV", "WI", "WY",
                "AS", "DC", "FM", "GU", "MH", "MP", "PR", "PW", "VI"
            ];
            reg = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
            var current=new Date();
            if(phone.toString().length<10 || phone.toString().length>11){
                alert("phone number must be 10 digits or 11 digits");
                return false;
            } else if(/\d/.test(x.firstName.value)){
                alert("First Name can't have number");
                return false;
            }else if(/\d/.test(x.lastName.value)){
                alert("Last Name can't have number");
                return false;
            }
            else if(!email.match(reg)){
                alert("email format is wrong");
                return false;

            } else if(x.bzip.value.toString().length!=5){
                alert("Billing zip code must be 5 digits");
                return false;
            } else if(x.zip.value.toString().length!=5){
                alert("Shipping zip code must be 5 digits");
                return false;
            } else if(x.cardnumber.value.toString().length!=16){
                alert("card number must be 16 digits");
                return false;
            } else if(x.security.value.toString().length<3 || x.security.value.toString().length>4){
                alert("security number must be 3 or 4 digits");
                return false;
            }else if(x.year.value==current.getFullYear() && x.month.value<(current.getMonth()+1) ){
                alert("your card has expired");
                return false;
            }else if(/\d/.test(x.bstreetName.value)){
                alert("Billing Street Name can't have number");
                return false;
            }else if(/\d/.test(x.streetName.value)){
                alert("Shipping Street Name can't have number");
                return false;
            }else if(/\d/.test(x.bcity.value)){
                alert("City Name can't  have number");
                return false;
            }else if(/\d/.test(x.city.value)){
                alert("City Name can't have number");
                return false;
            }
            else{
                arrayLength=states.length;
                for( var i=0;i<arrayLength;i++){
                    if(bState==states[i]){
                        break;
                    }
                }
                for( var j=0;j<arrayLength;j++){
                    if(State==states[j]){
                        break;
                    }
                }
                if(i>=arrayLength){
                    alert("The State entered is invalid. Please enter as 'CA'");
                    return false;
                }
                else if(j>=arrayLength){
                    alert("The State entered is invalid. Please enter as 'CA'");
                    return false;
                }else {
                    return true;

                }
            }
        }
    </script>

</head>
<body background="back2.jpg">
<a href ="saleWeb.php">Back</a>


<?php
if(!$res){
    require 'prelogin.html';
    echo '<p style="color:red"> Please Login First</p>';
    require 'postlogin.html';
    session_destroy();
}
elseif(($time - $_SESSION['start']) > 500) {
    require 'prelogin.html';
    echo '<p style="color:red" id="error"> Timeout</p>';
    require 'postlogin.html';
    session_destroy();
} else {
	$firstName=$_POST['firstName'];
$lastName=$_POST['lastName'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$bstreetNum=$_POST['bstreetNumber'];
$bstreetName=$_POST['bstreetName'];
$bapt=$_POST['bapt'];
$bcity=$_POST['bcity'];
$bstate=$_POST['bState'];
$bzip=$_POST['bzip'];
$streetNum=$_POST['streetNumber'];
$streetName=$_POST['streetName'];
$apt=$_POST['apt'];
$city=$_POST['city'];
$state=$_POST['State'];
$zip=$_POST['zip'];
$cardnumber=$_POST['cardnumber'];
$security=$_POST['security'];
$month=$_POST['month'];
$year=$_POST['year'];
$username=$_POST['username'];
$password=$_POST['password'];
$change=$_POST['change'];


	if($change=="change") {
		if($row=mysql_fetch_array($res)){
		require "Pre_customer_register.html";
				echo '<form id="reg" action="changeCustomer.php" method="POST" onSubmit="return checkField(this)">
<fieldset>
<legend>Customer Information</legend>
First Name:<br>
<input type="text" name="firstName" value="'.$row['firstName'].'" required ><br>
Last Name:<br>
<input type="text" name="lastName" value="'.$row['lastName'].'" required><br>
Email:<br>
<input type="email" name="email" value="'.$row['email'].'" required><br>
Phone:<br>
<input type=number name="phone" value="'.$row['phone'].'" required><br>
Billing Address:<br>
Street Number:
<input type="number" name="bstreetNumber" style="width:50px;"size="50" value="'.$row['billStreetNum'].'" required>
Steet Name:<input type="text" name="bstreetName" style="width:150px;" size="50" value="'.$row['billStreet'].'" required><br>
APT:<input type="number" name="bapt" size="50" style="width:40px;" value="'.$row['billAPT'].'" min="0"><br>
City:<input type="text" name="bcity" style="width:100px;" class="isstate" value= "'.$row['billCity'].'" required>
STATE:<input type="text" name="bState" style="width:40px;" class="isstate" value= "'.$row['billState'].'" required>
ZIPCODE:<input type="text" name="bzip" style="width:60px;" size="50" value= "'.$row['billZip'].'" required><br>
Shipping Address:<br>
Street Number:
<input type="number" name="streetNumber" style="width:50px;"size="50" value= "'.$row['shipStreetNum'].'" required>
Steet Name:<input type="text" name="streetName" style="width:150px;" size="50" value= "'.$row['shipStreet'].'"  required><br>
APT:<input type="number" name="apt" size="50" style="width:40px;" value= "'.$row['shipAPT'].'" min="0" ><br>
City:<input type="text" name="city" style="width:100px;" class="isstate" value= "'.$row['shipCity'].'" required>
STATE:<input type="text" name="State" style="width:40px;" class="isstate" value= "'.$row['shipState'].'" required>
ZIPCODE:<input type="text" name="zip" style="width:60px;" size="50" value= "'.$row['shipZip'].'" required><br>
Credit Card Number:<br>
<input type="number" name="cardnumber" style="width:120px;" value= "'.$row['cardNumber'].'" required><br>
Secutiry Number:<br>
<input type="number" maxlength="4" size="4" name="security" style="width:40px;" value= "'.$row['security'].'" required><br>
Expiration Date:<br>
Month:<input type="number" name="month" size="2" maxlength="2" style="width:30px;" min="1" max="12" value= "'.$row['cardMonth'].'" required> 
Year:<input type="number" name="year" maxlength="4" style="width:40px;" value= "'.$row['cardYear'].'" min="2015" required><br>
Username: <br>
<input type="text" name="username"  value= "'.$row['username'].'" readonly><div id="user"></div><br>
Password:<br>
<input type="text" name="password" value= "'.$row['password'].'" required><br>
<input type="submit" name="change" value="submit">
</fieldset>
</form>

</body>
</html>';
     unset($_POST['change']);
		     
 	}
  	else {
  		echo "<p style='color:red;'> invalid user input </p>";
  		unset($_POST['change']);
  	}

	} else if($change=="submit"){
  		$sql = "update customer set firstName='" . $firstName . "', lastName='" . $lastName . "', BillStreetNum='" . $bstreetNum . "', billStreet='" . $bstreetName .
                    "', billAPT='" . $bapt . "', billCity='" . $bcity . "', billState=''" . $bstate . ", billZip='" . $bzip . "', shipStreetNum='" . $streetNum . "', shipStreet='" . $streetName . "', shipAPT='"
                    . $apt . "', shipCity='" . $city . "', shipState='" . $state . "', shipZip='" . $zip . "', cardNumber='" . $cardnumber . "', cardMonth='" . $month . "', cardYear='" .
                    $year . "'email='" . $email . "', phone='" . $phone . "', security='" . $security . "', username='" . $username . "', password='" . $password . "' where username='" . $_SESSION['username'] . "';";
  		$res=mysql_query($sql);
  		$_SESSION['password']=$password;
		if(!$res){
			require 'prelogin.html';
			echo '<p style="color:red"> Unable to update</p>';
			echo $sql;
			require 'postlogin.html';
			session_destroy();
			unset($_POST['change']);
		} else {
			echo '<p style="color:green"> Update successfully,please click back to the main page</p>';
			unset($_POST['change']);
		}	 
	}
}
?>


</body>
</html>
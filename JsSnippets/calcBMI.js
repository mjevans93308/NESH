function calcBMI()
  {
	// retrieve the value entered for height and weight
	var height1 = document.getElementById("height").value;
	var weight1 = document.getElementById("weight").value;

	if (height1 == "") {// a value is not entered
		alert ("Enter a value for Height");
		document.getElementById("height").focus();
	}
	if (weight1 == "") {// a value is not entered
		alert ("Enter a value for Weight");
		document.getElementById("weight").focus();
	}
	// Assume that a valid Student is a string of 9 digits
	// with 4 0s followed by any other 5 digits.

	var BMI="";
	var formatPattern = /^[0-9]+$/;
	if (height1.match(formatPattern)&& weight1.match(formatPattern)){
		var val = weight1/(height1*height1)*703;
		alert(BMI = "your BMI is: " + val + "\n");
		return true;
	}
	else {
		alert ("Invalid Format. Re-enter correctly.");
		return false;
	}
  }
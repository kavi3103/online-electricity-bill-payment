function calculate() {
	var unit=document.forms["myForm"]["units"].value;
	var amount = unit * 3;
	document.getElementById("demo").innerHTML = amount;
	// body...
}
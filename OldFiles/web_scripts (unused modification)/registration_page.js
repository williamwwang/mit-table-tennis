/*********************
***Cap events at 3****
**********************/
function checkEvents(j){
  var events=0;
  for(var i=0; i<document.form['fEvents[]'].length; i++){
    if(document.form['fEvents[]'][i].checked==true){
      events=events+1;				      
    }
    if(events>3){
      document.form['fEvents[]'][j].checked=false;
      return false;
    }
  }
}


/***********************************
*****Set costs based on ratings*****
***********************************/
function setCosts() {

	if(document.form.fRatingSource[0].checked==0 
			&& document.form.fRatingSource[1].checked==0
			&& document.form.fRatingSource[2].checked==0) {
		alert("Please select your ratings source.");
	}

	var rating = 0;

	if (document.form.fRatingSource[0].checked==1) {
		rating = parseInt(document.form.fRating.value);
	}

	else if (document.form.fRatingSource[1].checked==1) {
		rating = parseInt(document.form.fRating.value) + 200;
	}

	else {
		rating = -100;
	}

	if (rating < 0) {
		document.getElementById("U2100Cost").innerHTML="$15";
		document.getElementById("U1900Cost").innerHTML="$15";
		document.getElementById("U1700Cost").innerHTML="$15";
		document.getElementById("U1500Cost").innerHTML="$15";
		document.getElementById("U1300Cost").innerHTML="$15";
		document.getElementById("U1100Cost").innerHTML="$15";
	}

	else {
		document.getElementById("U2100Cost").innerHTML="$20";
		document.getElementById("U1900Cost").innerHTML="$20";
		document.getElementById("U1700Cost").innerHTML="$20";
		document.getElementById("U1500Cost").innerHTML="$20";
		document.getElementById("U1300Cost").innerHTML="$20";
		document.getElementById("U1100Cost").innerHTML="$20";

		if (rating <= 1800)
					document.getElementById("U2100Cost").innerHTML="$15";
		if (rating <= 1600)
					document.getElementById("U1900Cost").innerHTML="$15";
		if (rating <= 1400)
					document.getElementById("U1700Cost").innerHTML="$15";
		if (rating <= 1200)
					document.getElementById("U1500Cost").innerHTML="$15";
		if (rating <= 1000)
					document.getElementById("U1300Cost").innerHTML="$15";
		if (rating <= 700)
					document.getElementById("U1100Cost").innerHTML="$15";

	}

}



/****************************
***Compute and print cost****
*****************************/
function computeCost(){

	var rating;
  var event_costs = new Array(30, 20, 20, 20, 20, 20, 20, 20, 10, 10);

	if (document.form.fRatingSource[0].checked==1) {
		rating = parseInt(document.form.fRating.value);
	}
	else if (document.form.fRatingSource[1].checked==1) {
		rating = parseInt(document.form.fRating.value) + 200;
	}
	else {
		rating = -100;
	}


	if (rating < 0) {
		for(var i = 1; i < 8; i++) event_costs[i] = 15;
	}
	else {
		if (rating <= 1800)
					event_costs[1] = 15;
		if (rating <= 1600)
					event_costs[2] = 15;
		if (rating <= 1400)
					event_costs[3] = 15;
		if (rating <= 1200)
					event_costs[4] = 15;
		if (rating <= 1000)
					event_costs[5] = 15;
		if (rating <= 700)
					event_costs[6] = 15;
	}

  var membership_costs = new Array(0, 49, 130, 90, 250, 25, 25, 60, 10);
	var membership_items = new Array(" ", "Adult - 1 year", "Adult - 3 years", "Household - 1 year", "Household - 3 years", "College student - 1 year", "Junior U-17 - 1 year", "Junior U-15 - 3 years", "One-time tournament pass");

  var total_cost=10;
  var events = 0;

	var print_items = "";
	var print_fee = "";

  for(var i=0; i<document.form['fEvents[]'].length; i++){
		if(document.form['fEvents[]'][i].checked) {
			total_cost += event_costs[i];
			events += 1;

			print_items += document.form['fEvents[]'][i].value + " Singles<br>";
			print_fee += "$"+event_costs[i] + ".00<br>";
//    total_cost += document.form['fEvents[]'][i].checked * event_costs[i];
//    events = events+document.form['fEvents[]'][i].checked;
  	}
	}

	if(document.form.fMembershipFee.value > 0) {
		var index = document.form.fMembershipFee.value;
  	total_cost += membership_costs[index];
		print_items += membership_items[index]+"<br>";
		print_fee += "$"+membership_costs[index]+".00<br>";
	}


	print_items += "Registration and ratings<br>";
	print_fee += "$10.00<br>";

  if(events==3) {
		total_cost-=5;
		print_items += "3 Event Discount<br>";
		print_fee += "-$5.00<br>";
	}

  if(document.form.fStudent[0].checked==1 && events > 1) {
		total_cost-=5;
		print_items += "Student Discount<br>";
		print_fee += "-$5.00<br>";
		document.getElementById("student_requirement").innerHTML = "($5 discount for 2 events or more; valid student ID required at check-in)";
	}
	else if(document.form.fStudent[0].checked==1 && events == 1) {
		document.getElementById("student_requirement").innerHTML = "(<u>$5 discount for 2 events or more;</u> valid student ID required at check-in)";
		//document.getElementById("student_requirement").style.text-decoration = 'underline';
	}
	else {
		document.getElementById("student_requirement").innerHTML = "($5 discount for 2 events or more; valid student ID required at check-in)";
		//document.getElementById("student_requirement").style.text-decoration = 'none';
	}

  //document.getElementById("fEntryFee").innerHTML="$"+total_cost;
  document.form.fTotalFee.value = "$"+total_cost; //for php

	print_items+="<hr>";
	print_fee+="<hr>";
	document.getElementById("costItems").innerHTML=print_items;
	document.getElementById("costFee").innerHTML=print_fee;
	document.getElementById("costTotal").innerHTML="$"+total_cost+".00";
}



/***********************
*****Customize form*****
***********************/

/*************wants to be USATT rated******************/
//STILL NEEDS WORK (DEFAULT VALUES ON CLICKS)
function wantsUSARated(i){
		//wants to be USATT rated
    if(i==1) {
      document.getElementById("usattRated").style.display="block";			
      document.getElementById("registrationFee").style.display="block";			
      document.getElementById("usattInfo").style.display="none";
      document.getElementById("usattMembership").style.display="none";
			document.form.fMember.required="required";
			//default all values
      document.form.fMembershipFee.value="0";			
			document.form.fStreet.value="";
			document.form.fCity.value="";
			document.form.fState.value="";
			document.form.fZip.value="";
			document.form.fPhone.value="";
			document.form.fBirthdate.value="";
      document.form.fMemberNumber.value="";
      document.form.fExpires.value="";
    }     
		//does not want USATT rating
    else {
      document.getElementById("usattRated").style.display="none";
      document.getElementById("registrationFee").style.display="none";			
			document.form.fMember.removeAttribute("required");
			//default all values
      document.form.fMembershipFee.value="0";
      document.form.fMemberNumber.value="";
      document.form.fExpires.value="";
			document.form.fMemberNumber.removeAttribute("required");
			document.form.fExpires.removeAttribute("required");
			document.form.fStreet.value="";
			document.form.fCity.value="";
			document.form.fState.value="";
			document.form.fZip.value="";
			document.form.fPhone.value="";
			document.form.fBirthdate.value="";
    }
}

/*********show doubles partner field**********/
function showDoubles() {

	if(document.form['fEvents[]'][8].checked || document.form['fEvents[]'][9].checked) {
      document.getElementById("doublesPartner").style.display="block";
	}

	else {
      document.getElementById("doublesPartner").style.display="none";			
			document.form.fDoublesPartner.value="";
	}

}

/**********USATT membership status************/
function isMember(i){
		//is member
    if(i==1) {
      document.getElementById("usattInfo").style.display="block";
      document.getElementById("usattMembership").style.display="none";
			document.form.fMemberNumber.required="required";
			document.form.fExpires.required="required";
			document.getElementById("usattApp").style.display="none";
			document.form.fStreet.removeAttribute("required");
			document.form.fCity.removeAttribute("required");
			document.form.fState.removeAttribute("required");
			document.form.fZip.removeAttribute("required");
			document.form.fPhone.removeAttribute("required");
			//default all values
      document.form.fMembershipFee.value="0";			
			document.form.fStreet.value="";
			document.form.fCity.value="";
			document.form.fState.value="";
			document.form.fZip.value="";
			document.form.fPhone.value="";
			document.form.fBirthdate.value="";
      document.form.fMemberNumber.value="";
      document.form.fExpires.value="";
			document.form.fRating.required="required";
    }     
		//is not member
    else {
      document.getElementById("usattInfo").style.display="none";
			document.getElementById("usattApp").style.display="block";
      document.getElementById("usattMembership").style.display="block";
      document.form.fMembershipFee.value="0";
      document.form.fMemberNumber.value="";
      document.form.fExpires.value="";
			document.form.fMemberNumber.removeAttribute("required");
			document.form.fExpires.removeAttribute("required");
			document.form.fStreet.value="";
			document.form.fCity.value="";
			document.form.fState.value="";
			document.form.fZip.value="";
			document.form.fPhone.value="";
			document.form.fBirthdate.value="";
			document.form.fStreet.required="required";
			document.form.fCity.required="required";
			document.form.fState.required="required";
			document.form.fZip.required="required";
			document.form.fPhone.required="required";
			document.form.fBirthdate.required="required";
			document.form.fRating.removeAttribute("required");
    }
}

/*******************************************
****Check mandatory fields on submission****
********************************************/
function checkValid(){
    var event=0;
    for(var i=0; i<document.form['fEvents[]'].length; i++){
       if(document.form['fEvents[]'][i].checked==true) {
          event=1;
          break;
       }
    }
    if(event==0) {
       alert("Please select events to enter.");
       document.form['fEvents[]'][0].focus();
       return false;
    }
    if(document.form.fMember[1].checked && document.form.fMembershipFee.value==0) {
				alert("Please select a USATT membership option.");
        document.form.fMembershipFee.focus();
        return false;
    }
    else return true; 
}






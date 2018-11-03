function onRegister(){
	console.log('final input check: ');
	var name = checkname();
	var email = checkemail();
	var password1 = checkpassword();
	var password2 = checkpassword2();
	var address = checkaddress();
	var cardno = checkcardno();
	var ccv = checkccv();
	var cardtype= checkcardtype();
	var postalcode = checkpostalcode();
	//Check if there are still any mistakes before sending to DB
	var checkinput= [name, password2, email, address, cardno, ccv, cardtype, postalcode];
	console.log(checkinput);
	if(checkinput.includes(false)){
		
	} else{
		document.getElementById("registerForm").submit();
		console.log(document.getElementById("registerForm"));
	}
}

function checkname() {
	var regex=/^[A-Za-z]{6,}$/;
	ele=document.getElementById('name');
	console.log(ele.value);
	if(regex.test(ele.value)){
		//alert('succeed');
		ele.style.border='1px solid #00B3B3';
		document.getElementById('nameWarning').style.display='none';
		return ele.value;
	}else{
		//alert('Name Error! Must be more than 2 characters');
		ele.style.border='1px solid #B91D47';
		document.getElementById('nameWarning').style.display='inline';
		return false;
	}
}

function checkemail(){
	var regex=/^([\w.-_]+)(\@)([A-Za-z]{2,})(\.{1}[A-Za-z]{2,}){1,3}$/;
	ele=document.getElementById('email');
	console.log(ele.value);
	if(regex.test(ele.value)){
		//alert('succeed');
		ele.style.border='1px solid #00B3B3';
		document.getElementById('emailWarning').style.display='none';
		return ele.value;
	}else{
		//alert('Email Invalid. Please enter email again.');
		ele.style.border='1px solid #B91D47';
		document.getElementById('emailWarning').style.display='inline';
		return false;
	}
}

function checkpassword(){
	var regex=/^[A-Za-z0-9]{6,}$/;
	ele=document.getElementById('password');
	console.log(ele.value);
	if(regex.test(ele.value)){
		document.getElementById('passwordWarning').style.display='none';
		ele.style.border='1px solid #00B3B3';
		return ele.value;
	}else{
		ele.style.border='1px solid #B91D47';
		document.getElementById('passwordWarning').style.display='inline';
		//alert('Error! Password must be at least 6 alpha-numeric characters');
		return false;
	}
}

function checkpassword2(){
	var regex=/^[A-Za-z0-9]{6,}$/;
	ele1=document.getElementById('password');
	ele2=document.getElementById('retypepassword');
	console.log(ele1.value);
	console.log(ele2.value);
	if(regex.test(ele1.value)){
		if(ele1.value==ele2.value){
			ele1.style.border='1px solid #00B3B3';
			ele2.style.border='1px solid #00B3B3';
			document.getElementById('passwordWarning').style.display='none';
			document.getElementById('retypepasswordWarning').style.display='none';
			return ele1.value;			
		}else{
			//alert('Password mismatched!');
			document.getElementById('passwordWarning').style.display='inline';
			document.getElementById('retypepasswordWarning').style.display='inline';
			ele1.style.border='1px solid #B91D47';
			ele2.style.border='1px solid #B91D47';
			return false;
		}
	}else{
		ele1.style.border='1px solid #B91D47';
		ele2.style.border='1px solid #B91D47';	
		document.getElementById('passwordWarning').style.display='inline';
		document.getElementById('retypepasswordWarning').style.display='inline';
		//alert('Error! Password must be at least 6 alpha-numeric characters');
		return false;
	}
}

function checkaddress(){
	var regex=/^[A-Za-z0-9\s]{5,}$/;
	ele=document.getElementById('address');
	console.log(ele.value);
	if(regex.test(ele.value)){
		document.getElementById('addressWarning').style.display='none';
		ele.style.border='1px solid #00B3B3';
		return ele.value;
	}else{
		document.getElementById('addressWarning').style.display='inline';
		ele.style.border='1px solid #B91D47';
		//alert('Address needs to be a minimum of 5 characters');
		return false;
	}
}

function checkcardno(){
	var regex=/^[0-9]{16}$/;
	ele=document.getElementById('cardno');
	console.log(ele.value);
	if(regex.test(ele.value)){
		document.getElementById('cardnoWarning').style.display='none';
		ele.style.border='1px solid #b3b3b3';
		return ele.value;
	}else{
		ele.style.border='1px solid #B91D47';
		document.getElementById('cardnoWarning').style.display='inline';
		//alert('Incorrect Card Number. Card Numbers must be 16 digits');
		return false;
	}	
}

function checkccv(){
	var regex=/^[0-9]{3}$/;
	ele=document.getElementById('ccv');
	console.log(ele.value);
	if(regex.test(ele.value)){
		document.getElementById('ccvWarning').style.display='none';
		ele.style.border='1px solid #b3b3b3';
		return ele.value;
	}else{
		ele.style.border='1px solid #B91D47';
		document.getElementById('ccvWarning').style.display='inline';
		//alert('Incorrect CCV. CCV Numbers must be 3 digits');
		return false;
	}	
}
function checkcardtype(){
	ele=document.getElementById('cardtype');
	console.log(ele.value);
	if(ele.value==""){
		document.getElementById('cardtypeWarning').style.display='inline';
		ele.style.border='1px solid #B91D47';
		//alert('Select card type');
		return false;
	}else {
		document.getElementById('cardtypeWarning').style.display='none';
		ele.style.border='1px solid #b3b3b3';
		return ele.value;
	}
		
}

function checkpostalcode(){
	const regex=/^[0-9]{6}$/;
	ele=document.getElementById('postalcode');
	console.log(ele.value);
	if(regex.test(ele.value)){
		document.getElementById('postalcodeWarning').style.display='none';
		ele.style.border='1px solid #b3b3b3';
		return ele.value;
	}else{
		document.getElementById('postalcodeWarning').style.display='inline';
		ele.style.border='1px solid #B91D47';
		//alert('Incorrect Postalcode. Must have 6 digits');
		return false;
	}
}
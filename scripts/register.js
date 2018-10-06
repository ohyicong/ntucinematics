/*
function onRegister (){
	var name=document.getElementById('name').value;
	var email = document.getElementById('email').value;
	var password=document.getElementById('password').value;
	var retypepassword= document.getElementById('retypepassword').value;
	if(name==''||email==''||password==''||retypepassword==''){
		alert("Please fill up all required information");
		return;
	}
	if(password!=retypepassword){
		alert("Retyped password not same");
		document.getElementById('password').value='';
		document.getElementById('retypepassword').value='';
		return
	}
	console.log(name);
}

//onclick="onRegister()"
*/

function sendData(table_name, array){
		var ajax = new XMLHttpRequest();
		let datainput =  new FormData();
		var method = "POST";
		var url = "./php/register.php";
		var asynchronous = true;
		// Add data into packet
		name=array[0];
		password=array[1];
		email=array[2];
		address=array[3];
		cardno=array[4];
		ccv=array[5];

		datainput.append("table_name", table_name);
		datainput.append("name", name);
		datainput.append("password", password);
		datainput.append("email", email);
		datainput.append("address", address);
		datainput.append("cardno", cardno);
		datainput.append("ccv", ccv);

		//For posting
		ajax.open(method, url, asynchronous);	
		ajax.send(datainput);


		ajax.onreadystatechange= function(){
			if(this.readyState==4 && this.status ==200){
				try{
					var data = JSON.parse(this.responseText);
					console.log(this.responseText);
				}catch{
					console.log(this.responseText);
					console.log("Error occured");
				}
		};
	}
}


function onRegister(){
	console.log('final input check: ');
	var name = checkname();
	var email = checkemail();
	var password1 = checkpassword();
	var password2 = checkpassword2();
	var address = checkaddress();
	var cardno = checkcardno();
	var ccv = checkccv();
	//Check if there are still any mistakes before sending to DB
	var checkinput= [name, password2, email, cardno, address, ccv];
	if(checkinput.includes(false)){
		alert('Try Again! Please check if your information is keyed correctly.');
	} else{
		sendData('user_accounts', checkinput);
		//alert('Registration Successful!');
		window.location.href = './login.html';
		alert('Registration Successful!');
	}
}


function checkname() {
	var regex=/^[A-Za-z]{2,}$/;
	input=document.getElementById('name').value;
	console.log('name: ', input);
	if(regex.test(input)){
		//alert('succeed');
		return input;
	}else{
		alert('Name Error! Must be more than 2 characters');
		return false;
	}
}

function checkemail(){
	var regex=/^([\w.-_]+)(\@)([A-Za-z]{2,})(\.{1}[A-Za-z]{2,}){1,3}$/;
	input=document.getElementById('email').value;
	console.log('email: ', input);
	if(regex.test(input)){
		//alert('succeed');
		return input;
	}else{
		alert('Email Invalid. Please enter email again.');
		return false;
	}
}

function checkpassword(){
	var regex=/^[A-Za-z0-9]{6,}$/;
	input=document.getElementById('password').value;
	console.log('password1: ', input);
	if(regex.test(input)){
		return input;
	}else{
		alert('Error! Password must be at least 6 alpha-numeric characters');
		return false;
	}
}

function checkpassword2(){
	var regex=/^[A-Za-z0-9]{6,}$/;
	input1=document.getElementById('password').value;
	input2=document.getElementById('retypepassword').value;
	console.log('password2: ', input2);
	if(regex.test(input)){
		if(input1==input2){
			return input1;			
		}else{
			alert('Password mismatched!')
			return false;
		}
	}else{
		alert('Error! Password must be at least 6 alpha-numeric characters');
		return false;
	}
}

function checkaddress(){
	var regex=/^[A-Za-z0-9]{5,}$/;
	input=document.getElementById('address').value;
	console.log('address: ', input);
	if(regex.test(input)){
		return input;
	}else{
		alert('Address needs to be a minimum of 5 characters');
		return false;
	}
}

function checkcardno(){
	var regex=/^[0-9]{16}$/;
	input=document.getElementById('cardno').value;
	console.log('cardno: ', input);
	if(regex.test(input)){
		return input;
	}else{
		alert('Incorrect Card Number. Card Numbers must be 16 digits');
		return false;
	}	
}

function checkccv(){
	var regex=/^[0-9]{3}$/;
	input=document.getElementById('ccv').value;
	console.log('ccv: ', input);
	if(regex.test(input)){
		return input;
	}else{
		alert('Incorrect CCV. CCV Numbers must be 3 digits');
		return false;
	}	
}
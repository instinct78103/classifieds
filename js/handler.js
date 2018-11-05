//div#data
const code = document.querySelector('#code');
const textAndPhone = document.querySelector('#text');
const info = document.querySelector('#info');

//div#old_classifieds
const oldClassifieds = document.querySelector('#old_classifieds');

//div#new_classifieds
const newClassifieds = document.querySelector('#new_classifieds');

//После ввода третьего символа в коде курсор перескакивает на ввод текста ниже

code.oninput = function(){
	code.value = code.value.replace(/[^\d]/, '');
	if(code.value.length == 3){
		text.focus();
	}
}

function showNewClassifieds(){
	let xhr = new XMLHttpRequest();
	
	xhr.open('GET', 'show_new.php')
	xhr.onreadystatechange = function(){
		if(xhr.readyState == 4 && xhr.status == 200){
			newClassifieds.innerHTML = xhr.response
		}
		else if(xhr.status != 200){
			newClassifieds.innerHTML = 'Ошибка: ' + xhr.status
		}
	}
	xhr.send();
}

function start(){
	id = setInterval('showNewClassifieds()', 1000);
}

newClassifieds.onload = start();


textAndPhone.oninput = function(){
	let find = 'find=' + textAndPhone.value;
	let xhr = new XMLHttpRequest();
	xhr.open('POST', 'show_old.php');
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	
	xhr.onreadystatechange = function(){
		if(xhr.readyState == 4 && xhr.status == 200){
			oldClassifieds.innerHTML = xhr.response;
			let matches = document.querySelectorAll('p.matches');
			matches.forEach(function(item){
				item.ondblclick = function(){
					let strArr = item.innerHTML.split('	');
					code.value = strArr[0];
					textAndPhone.value = strArr[1];
					textAndPhone.focus();
				}
			});
		}
		else{
			oldClassifieds.innerHTML = 'Ошибка: ' + xhr.status;
		}
	}
	
	xhr.send(find);
}

textAndPhone.onkeydown = function(event){
	if(event.which == 13){
		event.preventDefault();
		var data = 'code=' + code.value + '&' + 'textAndPhone=' + textAndPhone.value;
		
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'data_check.php');
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onreadystatechange = function(){
			if(xhr.readyState == 4 && xhr.status == 200){
				if(xhr.responseText == '1'){
					code.value = '';
					code.focus();
					textAndPhone.value = '';
					oldClassifieds.innerHTML = '';
					info.innerHTML = '';
					setTimeout('info.innerHTML = ""', 3000);
				}
				else{
					info.innerHTML = xhr.response;
				}
			}
		}
		xhr.send(data);
	}				
}
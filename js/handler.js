const code = document.querySelector('#code');
const textAndPhone = document.querySelector('#text');
const info = document.querySelector('#info');
const oldClassifieds = document.querySelector('#old_classifieds');
const newClassifieds = document.querySelector('#new_classifieds');
const dwlbutton = document.querySelector('#download')

//После ввода третьего символа в коде курсор перескакивает на ввод текста ниже

code.oninput = () => {
	code.value = code.value.replace(/[^\d]/, '');
	if(code.value.length >= 3){
		text.focus();
	}
}

/*dwlbutton.onclick = () => {
	let xhr = new XMLHttpRequest();
	xhr.open('GET', 'downloadFile.php')
	xhr.send();

	xhr.onreadystatechange = () => {
		if(xhr.readyState == 4 && xhr.status == 200){
			info.innerHTML = xhr.response
		}
		else if(xhr.status != 200){
			info.innerHTML = 'Ошибка: ' + xhr.status
		}
	}
}*/

code.onpaste = (e) => {
	e.preventDefault();
	e.stopPropagation();
}

textAndPhone.oninput = searching;
newClassifieds.onready = start();

function showNewClassifieds(){
	let xhr = new XMLHttpRequest();
	xhr.open('GET', 'show_new.php')
	xhr.send();
	
	xhr.onreadystatechange = function(){
		if(xhr.readyState == 4 && xhr.status == 200){
			newClassifieds.innerHTML = xhr.response
		}
		else if(xhr.status != 200){
			newClassifieds.innerHTML = 'Ошибка: ' + xhr.status
		}
	}	
}

function start(){
	setInterval(showNewClassifieds, 1000);
}

function searching(phpHandler){
	phpHandler = 'show_old.php';
	let find = JSON.stringify({
		"find": textAndPhone.value
	});
	let xhr = new XMLHttpRequest();
	
	xhr.open('POST', phpHandler);
	xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
	xhr.send(find);
	
	xhr.onreadystatechange = function(){
		if(xhr.readyState == 4 && xhr.status == 200){
			oldClassifieds.innerHTML = xhr.response;
			let matches = document.querySelectorAll('p.matches');
			for(let elem of matches){
				elem.ondblclick = function(){
					let strArr = elem.innerHTML.split('	');
					code.value = strArr[0];
					textAndPhone.value = strArr[1].replace(/[\n]/, '');
					textAndPhone.focus();
				} 
			}
		}
	}
}

//Формируем массив из двух элементов, чтобы потом произвести перебор
let elems = [code, textAndPhone];
for(let elem of elems){
	elem.onkeydown = function(event){
		//клавиша TAB, переключаем курсор 
		if(event.which == 9){
			if(elem == code){
				textAndPhone.focus();
			}
			else{
				code.focus();
			}
			return false;
		}
		//клавиша ENTER
		else if(event.which == 13){
			event.preventDefault();
			
			let xhr = new XMLHttpRequest();
			let json = JSON.stringify({
				"code": code.value,
				"textAndPhone": textAndPhone.value
			});
			
			xhr.open('POST', 'addNew.php');
			xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
			xhr.send(json);
			
			xhr.onreadystatechange = function(){
				if(xhr.readyState == 4 && xhr.status == 200){
					if(xhr.responseText == 'Success! New line has been added!'){
						code.value = '';
						textAndPhone.focus();
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
		}
		//клавишы CTRL + SPACE
		else if(event.ctrlKey && event.which == 32 && newClassifieds.innerHTML){
			found = newClassifieds.children[0]
			.innerText
			.match(/[.] ([0-9].+)$/);
			textAndPhone.value = found[1].trim();
			//и здесь же поиск
			searching();
		}
	}
}
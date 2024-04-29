var modal, _frame;
function designAlert(pobj){
_frame = document.getElementById("modal_frame");
modal = document.getElementById("modal_main");
modal.style.display = "block";
var contents = document.getElementsByClassName('content');
for(var x=0; x<contents.length; x++)
	contents[x].style.width = parseInt(500 *0.8);


	obj = pobj;
	document.getElementById("modal_options").innerHTML = '';
	var mod_opt_padding = 52.5;
	for(var x=0; x<obj.options[0].length; x++){
		document.getElementById("modal_options").innerHTML += "<button id='btn_opt_bal' onclick="+obj.options[1][x]+">"+obj.options[0][x]+"</button>";
		mod_opt_padding-=10;
	}
		document.getElementById("modal_options").style.paddingLeft = mod_opt_padding+"%";
		document.getElementById("modal_title").innerHTML = obj.title;
		document.getElementById("modal_text").innerHTML = obj.text;
		document.getElementById("modal_logo").src = obj.logo;
		//for shape
		if(obj.shape == 'box'){
			_frame.style.height = "50%";
			_frame.style.width = "50%";
			_frame.style.borderRadius =  '0%';
			
		}
		
		else if(obj.shape == 'oblong'){
			_frame.style.height = "50%";
			_frame.style.width = "65%";
			_frame.style.borderRadius =  '100%';
		}
		
		else if(obj.shape == 'circle'){
			_frame.style.height = "50%";
			_frame.style.width = "50%";
			_frame.style.borderRadius = '100%';
		}
		
		else {
			_frame.style.height = "50%";
			_frame.style.width = "65%";
			_frame.style.borderRadius = '0%';
		}
}

	
function closeDesignAlert(){
modal.style.display = "none";
}
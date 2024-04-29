<style>
	#sideleft, #sideright{
		height:100%;
		width:20%;
		background:#0007;
		float:left;
		position:absolute;
	}
	
	#sideleft{
		top:0;
		left:0;
	}
	
	#sideright{
		top:0;
		left:80%;
	}
	
	#middle{
		width:100%;
		height:100%;
		position:absolute;
		background:#fffc;
		left:0
		top:0;
	}
	
	#mid_frame{
		height:80%;
		width:60%;
		background:ddfa;
		position:absolute;
		left:20%;
		top:0;
		overflow:hidden;
	}
	
	.word_box{
		position:absolute;
		height:50px;
		background:url('images/drop.png') no-repeat;
		background-size: 100% 100%;
		opacity:20%;
		font-weight:bold;
		padding-top:15px;		
	}
	
	.word_box_freeze{
		position:absolute;
		height:50px;
		background:url('images/crystal.png') no-repeat;
		background-size: 100% 100%;
		opacity:20%;
		font-weight:bold;
		padding-top:15px;		
	}
	
	body{
		position:relative;
		background:url('images/lightning.gif') no-repeat;
		background-size: 100% 100%;
		overflow:hidden;
	
	}
	
	.included{
		color:cyan;
		weight:bold;
	}
	
	.cylinder{
		float:left;
		margin-right:10px;
		-ms-transform: rotate(180deg); /* IE 9 */
		-webkit-transform: rotate(180deg); /* Safari */
		transform: rotate(180deg);
	}
	
	#hp{
		background: url("images/cylinder1.png") no-repeat;
		background-size:100% 400px;
		height:400px;
		width:100px;
	}
	
	#mp{
		background: url("images/cylinder2.png") no-repeat;
		background-size:100% 400px;
		height:400px;
		width:100px;
	}
	
	#profile{
		height:50%;
	}
	
	#word_display{
		position:fixed;
		font-family: Impact;
		font-size:550%;
		color:white;
		text-shadow: 0px 0px 40px #222277;
		text-align:center;
		top:800px;
		left:30%;
		width:40%;
		height:100px;
	}
	
	#menu{
		margin:0 auto; width:80%; height:70%; margin-top:10%;
		background:url('images/typing_flash.png') no-repeat;
		background-size: 100% 100%;
	}
	
	#menu button{
		width:60%;
		height:30%;
		margin-left:20%;
		background: #0005;
		margin-top:1%;
		border-radius: 30%;
		color:white;
		font-weight:bold;
		font-size:3vw;
	}
	
	#menu button:hover{
		color:#aaa;
		text-shadow:0 0 10px;
		font-size:3.1vw;
		background:#0056;
	}
	
</style>


<script src="bitter_alert.js"></script>
<link rel="stylesheet" href="bal.css" type="text/css"/>


<body >


<section id="menu">
<div style="padding-top:30%; height:35%;">
	<button onclick="init()">Start</button>
	<button>Setting</button>
	<button>Help</button>
</div>
</section>

<section id="arena" style="display:none">
	<div id="word_display"></div>
	<section id="sideleft">
		<div style="width:100%; height:20%; background:#000a; text-align:center; color:white; text-shadow: 0 0 10px orange; font-size:3vw;">
			<div style="width:100%; height:50%; background:orange">Points</div>
			<div id="tot_points" style="width:100%; height:50%; background:#0005">1000</div>
		</div>
	</section>
		<section id="mid_frame">
			<div id="middle"></div>
		</section>
	<section id="sideright">
		<div id="profile"></div>
		<div class="cylinder" id="hp"></div>
		<div class="cylinder" id="mp"></div>
		<!--<div class="cylinder" id="mp"></div>-->
	</section>

	<div id="modal_main"><!--for bitter alert-->
		<div id="modal_frame">
			<div class="content" id="modal_title"></div>
			<div class="content" id="modal_text"></div>
			<div class="content" id="modal_logo" ><img id="logo_pic" src="images/warning.jpg"></img></div>
			<div class="content" id="modal_options"></div>
		</div>
	</div>
</section>
</body>

<script>
var timer_is_on;
var loop_function, whole_word;
var words, life, mp;
var cntr;
var got_ind;
var mid_frame_height;
var middle = document.getElementById("middle");
var tot_points;
var freeze;
document.addEventListener("keyup", keyPress, false);

function createTheWordsFlow(){
	//set the word difficulty
	setWordDifficulty();
	
	//create words
	createWords();
	
	//create width
	createWidth();
	
	//create height
	createHeight();
	
	//create word boxes
	createWordBoxes();
}

function createWidth(){
	for(var x=0; x<words[0].length; x++){
		words[2][x] = parseInt((Math.random()*80)) + "%";
		//console.log(words[2][x]);
	}
	
}

function createHeight(){
	for(var x=0; x<words[0].length; x++){
		words[1][x] =   -screen.height + mid_frame_height-(35*x);
		
		//console.log(words[1][x]);
	}
}

function createWordBoxes(){
	document.getElementById("middle").innerHTML ="";
	for(var x=0; x<words[0].length; x++){
		document.getElementById("middle").innerHTML += "<div id="+x+" class='word_box' style='top:"+ words[1][x]+"; left:"+words[2][x]+"'>"+words[0][x]+"</div>";
	}
}

function createWords(){
	<!-- for(var x=0; x<words.length; x++){ -->
		words[0] = readTextFile();
		for(var x=0; x<words[0].length; x++){//trimming each word
				words[0][x] = words[0][x].substring(0, words[0][x].indexOf('\r'));
				//console.log(words[0][x]+ " = "+words[0][x].indexOf('\r'));
		}
		console.log(words[0].length);
		mid_frame_height = 200*words[0].length;// the total value of height of the middle frame
		middle.style.height = mid_frame_height +screen.height;
		for(var x=1; x<3; x++){
			words[x] = new Array(words[0].length);
		}
		//console.log(middle.style.top+"top");
	<!-- } -->
	
	
}

function exitGame(){
	closeDesignAlert();
	init();
}

function getTime(){
	cntr++;
	document.getElementById("middle").style.top = -mid_frame_height+screen.height +cntr;
	seeOpenWords();
	seeCloseWords();
	var t = setTimeout(loop_function,20);	
}

function getTimeInFreeze(){
	if(freeze > 0){
		freeze--;
	seeOpenWords();
	seeCloseWords();
	}
	
	else{
		for(var x=recent_word_ind; x<last_word_ind; x++)
			document.getElementById(x).className = "word_box";
			loop_function = "getTime()";
	}
	
	var t = setTimeout(loop_function,20);
}

function highlightWords(){
	console.log((words[0][recent_word_ind].substring(0,whole_word.length).toUpperCase() == whole_word) + " = "+whole_word + "+"+words[0][recent_word_ind]);
	for(var x=recent_word_ind; x<last_word_ind; x++){
		if(words[0][x].substring(0,whole_word.length).toUpperCase() == whole_word){//if found like words
			document.getElementById(x).innerHTML = "<span class='included'>"+whole_word.toLowerCase()+"</span>"+words[0][x].substring(whole_word.length,words[0][x].length);//colorized the affected words
			if(words[0][x].length == whole_word.length){//if found exact words
					got_ind = x;
					//console.log(x - "the index");
			}
		}
		else{
			document.getElementById(x).innerHTML = words[0][x];
		}
	
	}
	
}

function init(){
	document.getElementById('arena').style.display = "block";
	document.getElementById('menu').style.display = "none";
	timer_is_on = false;
	cntr=0;
	got_ind = -1;
	life=400;
	mp=400;
	recent_word_ind = 0;
	last_word_ind = 0;
	loop_function = "getTime()";
	whole_word = "";
	tot_points = 0;
	freeze = 0;
	words = new Array(3);
	createTheWordsFlow();
	startTime();
}

function keyPress(e){

	keyCode = e.keyCode;
	if(keyCode == 13){
		seeSkill();
		seeGotWord();
		whole_word = "";
	}
	
	else if(keyCode == 8){//delete
	whole_word = whole_word.substring(0,whole_word.length-1);
	}
	
	else{
		whole_word += String.fromCharCode(keyCode);
	}
	
		document.getElementById("word_display").innerHTML = whole_word;
		highlightWords();
}

function readTextFile(file){
	return [<?$myfile = fopen("words1.txt", "r") or die("Unable to open file!");
	// Output one line until end-of-file
	while(!feof($myfile)) {
	  echo json_encode(fgets($myfile)) . ",";
	}
	fclose($myfile);
	?>]
}

function seeGotWord(){
	if(got_ind !=-1)
	{
		//alert(document.getElementById(got_ind).innerHTML);
		document.getElementById(got_ind).style.display = "none";
		got_ind =-1;//back to default
		tot_points += whole_word.length*2;
		document.getElementById("tot_points").innerHTML = tot_points;
	}
}

function seeCloseWords(){
	//console.log((words[1][recent_word_ind])+":"+(mid_frame_height-cntr));
	if(words[1][recent_word_ind] >= (mid_frame_height-cntr-100) ){//if the recent word is near 
		if(document.getElementById(recent_word_ind).style.display == 'none')//if the word got, it will not reduced the hp
			console.log("check");
		else{
			life-=20;
			document.getElementById("hp").style.height = life;
			
			if(life <= 0)
				loop_function = "stopTime()";
		}
		//alert(words[0][recent_word_ind]);
		//console.log("close - " + (words[0][recent_word_ind])+":"+(mid_frame_height-cntr));
		console.log("close - " + (words[0][recent_word_ind]));
		recent_word_ind++;
	}
}

function seeOpenWords(){
	//console.log(words[1][last_word_ind] + ","+(mid_frame_height-screen.height - cntr));
	if( words[1][last_word_ind] > (mid_frame_height-screen.height - cntr)){
		//document.getElementById(last_word_ind).style.display = "block";
		last_word_ind++;
		//console.log(words[0][last_word_ind-1]+":open"+last_word_ind);
	}
}

function seeSkill(){
	if(whole_word == '1' && mp >=9){
		for(var x=recent_word_ind; x<last_word_ind; x++){
			document.getElementById(x).style.display = "none";
		}
		
		mp-=90;
	}
	
	else if(whole_word == '2' && mp >=8){
		freeze = 500;
		for(var x=recent_word_ind; x<last_word_ind; x++){
			document.getElementById(x).className = "word_box_freeze";
		}
		
		loop_function = "getTimeInFreeze()";
		mp-=90;
	}
		document.getElementById("mp").style.height = mp;
}

function startTime(){	
	if(timer_is_on == false)
	{
		timer_is_on=true;
		getTime();
	}
}

function setWordDifficulty(){
	
}

function stopTime(){
	var options = [['OK'], ['exitGame()']];
	obj = {
			options:options, 
			title:"Game Over!",
			text:"You did a great job!",
			logo:"images/raindrop.png",
			shape:'circle',
	}

	designAlert(obj);
}


</script>

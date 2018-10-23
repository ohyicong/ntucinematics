const bannerLinks=['./img/crazyrichasian-banner.jpg','./img/downadarkhall-banner.jpg','./img/firstpurge-banner.jpg']
const movies=["Crazy Rich Asian (PG)","Down A Dark Hall (PG)","The First Purge (M18)"];
const imglinks=["./crazyrichasian.php","./downadarkhall.php",'./thefirstpurge.php'];
var count=0;
//Photo slider
function banner() {  	 
	var bannerElement= document.getElementById('banner');
	var movie= document.getElementById('movie');
	var imglink=document.getElementById('imglink');
	count++;
	if(count<bannerLinks.length){
		bannerElement.setAttribute("src", bannerLinks[count]);	
		imglink.href=imglinks[count];
		movie.innerHTML=movies[count];
		console.log(movie.innerHTML);
	}else{
		count=0;
		bannerElement.setAttribute("src", bannerLinks[count]);
		movie.innerHTML=movies[0];
	}
	
}
function onBookNow(){
	location.href=imglinks[count];
}
setInterval(banner,3000);




var nav = document.getElementById("main_nav");//get a reference to the nav bar
var navA = nav.getElementsByTagName("a");//get a refernce on the anchors in the nav bar
console.log(navA);
window.onscroll =function(){//put a listener on scrolling
    if(document.body.scrollTop > 200 || document.documentElement.scrollTop > 200){
        nav.style.backgroundColor = "rgba(0, 100, 250, 0.85)";//set a back ground 
        navA[0].style.color = "rgb(253, 150, 25)";//change the anchors text color
        navA[1].style.color = "rgb(253, 150, 25)";
        navA[2].style.color = "rgb(253, 150, 25)";
        navA[3].style.color = "rgb(253, 150, 25)";
		navA[4].style.color = "rgb(253, 150, 25)";
        nav.style.minHeight = "30px";
    }else{
        nav.style.backgroundColor = "transparent";
        navA[0].style.color = "rgb(255, 255, 255)";
        navA[1].style.color = "rgb(255, 255, 255)";
        navA[2].style.color = "rgb(255, 255, 255)";
        navA[3].style.color = "rgb(255, 255, 255)";
		navA[4].style.color = "rgb(255, 255, 255)";
        nav.style.minHeight = "auto";
    }
};

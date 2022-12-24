var arr = document.getElementsByTagName("tr");
console.log(arr);
var i =0;
for(i=0;i<arr.length;i++){
    if(arr[i].id == "")continue;
    console.log(arr[i].id);
    console.log(i);
    var splitted = arr[i].id.split("_");
    
    console.log(splitted[0]+"_inner");

    if(splitted[1] == "row"){
        const j = i;
        arr[j].addEventListener("mouseover",event=>{
            console.log(arr[j])
            splitted = arr[j].id.split("_");
            console.log(splitted[0]);
            console.log(j)
            arr[j].getElementsByClassName(splitted[0]+"_inner")[0].style.visibility = "visible";
        });
        arr[j].addEventListener("mouseout",event=>{
            splitted = arr[j].id.split("_");
            arr[j].getElementsByClassName(splitted[0]+"_inner")[0].style.visibility = "hidden";
        });
        
    }
}


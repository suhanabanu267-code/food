const input = document.getElementById("ingredient");
if(input){
    input.addEventListener("keyup", ()=>{
        fetch("autocomplete.php?term=" + input.value)
            .then(res=>res.json())
            .then(data=>console.log(data)); // You can enhance UI later
    });
}

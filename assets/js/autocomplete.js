const input = document.getElementById("keyword");
const list = document.getElementById("suggestions");

if (input) {
    input.addEventListener("keyup", () => {
        let query = input.value;

        if (query.length > 0) {
            fetch("autocomplete.php?term=" + encodeURIComponent(query))
                .then(res => res.json())
                .then(data => {
                    list.innerHTML = ""; 
                    data.forEach(item => {
                        const li = document.createElement("li");
                        li.textContent = item;

                       
                        li.addEventListener("click", () => {
                            input.value = item;
                            list.innerHTML = "";
                        });

                        list.appendChild(li);
                    });
                })
                .catch(err => console.error("Error:", err));
        } else {
            list.innerHTML = "";
        }
    });
}

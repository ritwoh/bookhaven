// Función para filtrar la tabla
function searchTable() {
    let input = document.getElementById("searchInput").value.toLowerCase();
    let table = document.querySelector("table");
    let rows = table.querySelectorAll("tbody tr");

    rows.forEach(row => {
        let data = row.textContent.toLowerCase();
        if (data.indexOf(input) > -1) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

// Función para cambiar el tema

const darkMode = document.querySelector(".dark-mode");
const body = document.body;

darkMode.addEventListener("click",()=>{
    body.classList.toggle("active");
});
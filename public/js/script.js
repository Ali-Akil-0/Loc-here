const body = document.querySelector("body");
const modeToggle = body.querySelector(".mode-toggle");

modeToggle.addEventListener("click", () => {
    body.classList.toggle("dark");
});

function commaSeparateNumber(val) {
    while (/(\d+)(\d{3})/.test(val.toString())) {
        val = val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    }
    return val;
}

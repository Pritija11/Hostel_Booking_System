document.getElementById("roomType").addEventListener("change", function () {
    const type = this.value;

    if (!type) return;

    fetch("check_availability.php?type=" + type)
        .then(res => res.text())
        .then(data => {
            document.getElementById("availability").innerHTML = data;
        });
});

BX(() => {
    let loc = window.location.pathname;
    let temp = loc.substring(0, loc.lastIndexOf('/'));
    let id = temp.substring(temp.lastIndexOf('/') + 1);
    let complaintBtn = document.getElementById("complaint-ajax");
    let complaintRes = document.getElementById("complaint-result");

    if(complaintBtn) {
        complaintBtn.onclick = (e) => {
            e.preventDefault();
    
            BX.ajax.loadJSON(
                loc,
                {
                    "type": "AJAX",
                    "id": id
                },
                (data) => {
                    complaintRes.innerText = "Ваше мнение учтено, №" + data["id"];
                },
                (data) => {
                    complaintRes.innerText = "Ошибка!";
                }
            );
        };
    }
});
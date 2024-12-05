document.addEventListener("DOMContentLoaded", function() {
    const selectBtns = document.querySelectorAll(".select-btn");
    const listItems = document.querySelectorAll(".list-items");
    
    selectBtns.forEach(selectBtn => {
        const correspondingList = selectBtn.nextElementSibling;
        
        selectBtn.addEventListener("click", function(event) {
            event.stopPropagation(); 

            listItems.forEach(list => {
                if (list !== correspondingList) {
                    list.classList.remove("open");
                    list.previousElementSibling.classList.remove("open"); 
                }
            });
            
            correspondingList.classList.toggle("open");
            selectBtn.classList.toggle("open");
        });
    });

    document.addEventListener("click", function() {
        listItems.forEach(list => {
            list.classList.remove("open");
            list.previousElementSibling.classList.remove("open"); 
        });
    });

    listItems.forEach(list => {
        list.addEventListener("click", function(event) {
            event.stopPropagation(); 
        });
    });

    const items = document.querySelectorAll(".item");
    items.forEach(item => {
        item.addEventListener("click", function() {
            item.classList.toggle("checked");

            const checked = document.querySelectorAll(".item.checked");
            const btnText = item.closest('.select-btn').querySelector(".btn-text");

            if (checked.length > 0) {
                btnText.innerText = `${checked.length} Seleccionados`;
            } else {
                btnText.innerText = "Seleccionar Filtros";
            }
        });
    });
});


$(document).ready(function(){
    $(".select-btn").click(function(){
        $(this).toggleClass("open");
        $(this).next(".list-items").slideToggle();
    });
});

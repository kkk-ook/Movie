'use strict';
{
/*レビュー画面 レンジ*/
    document.addEventListener('input', inputChange)

    function inputChange(event) {
        if(event.target.classList.contains('js-range')) {
            event.target.nextElementSibling.innerText = event.target.value;

        }
    }



    document.addEventListener('data-stored', function (event) {
    element.backgroundColor = '#F8B400';
    element.style.opacity = '1';
    });

}
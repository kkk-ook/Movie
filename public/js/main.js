'use strict';
{
/*レビュー画面 レンジ*/
    document.addEventListener('input', inputChange)

    function inputChange(event) {
        if(event.target.classList.contains('js-range')) {
            event.target.nextElementSibling.innerText = event.target.value;

        }
    }

    const open = document.getElementById('open');
    const boxes1 = document.getElementById('boxes-1');
    const boxes2 = document.getElementById('boxes-2');

    open.addEventListener('click', () =>{
        boxes1.classList.toggle('visible');
        boxes2.classList.toggle('visible');
        open.classList.toggle('visible');
    });

}
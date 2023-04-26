'use strict';
{
/*レビュー画面*/
//モーダル画面のレンジ
    document.addEventListener('input', inputChange)

    function inputChange(event) {
        if(event.target.classList.contains('js-range')) {
            event.target.nextElementSibling.innerText = event.target.value;

        }
    }


//削除ボタン
const jsDeletes = document.querySelectorAll('.js-delete');
const editDeletes = document.querySelectorAll('.edit-delete');
const editCancels = document.querySelectorAll('.edit-cancel');

jsDeletes.forEach((jsDelete, element) => {
    jsDelete.addEventListener('click', () => {
        jsDelete.classList.toggle('hidden');
        editDeletes[element].classList.toggle('visible');
        editCancels[element].classList.toggle('visible');
    });

editCancels[element].addEventListener('click', () => {
    jsDelete.classList.toggle('hidden');
    editDeletes[element].classList.toggle('visible');
    editCancels[element].classList.toggle('visible');
});
});

//詳細ボタン
const tools = document.querySelectorAll('.tool');

tools.forEach((tool) => {
    let timer;
    const detail = tool.querySelector('.detail');
    detail.addEventListener('mouseenter', () => {
        timer = setTimeout(() => {
            tool.classList.add('visible');
        }, 700);
    });
    detail.addEventListener('mouseleave', () => {
        clearTimeout(timer);
        tool.classList.remove('visible');
    });
});

}
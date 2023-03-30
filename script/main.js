//window loda
window.addEventListener('load', () => {
    const CHECK_BOXES = document.querySelectorAll('input[type="checkbox"]');

    let localTodoList = localStorage.getItem('todoList'); 
    let arrayTodoList = JSON.parse(localTodoList);


    //localStorageチェック
    if (localTodoList) {
        for (let index = 0; index < arrayTodoList.length; index++) {
            const element = arrayTodoList[index];
            if (element) {
                CHECK_BOXES[index].checked = true;
                CHECK_BOXES[index].parentNode.parentNode.classList.add('finished');
            }
        }
        localStorage.clear();
    } else {
        initializeArrayTodoList();
    }

    //チェックボックスのイベント
    CHECK_BOXES.forEach((check_box) => {
        check_box.addEventListener('change', (event) => {
            if (check_box.checked) {
                //親要素の親要素にfinishedクラスを付与
                check_box.parentNode.parentNode.classList.add('finished');
                //localStorageに保存
                let number = check_box.id.split("-")[1];
                arrayTodoList[Number(number)] = true;
                let jsonTodoList = JSON.stringify(arrayTodoList);
                localStorage.setItem('todoList', jsonTodoList);
            } else {
                //親要素の親要素からfinishedクラスを削除
                check_box.parentNode.parentNode.classList.remove('finished');
                //localStorageから削除
                let number = check_box.id.split("-")[1];
                arrayTodoList[Number(number)] = false;
                let jsonTodoList = JSON.stringify(arrayTodoList);
                localStorage.setItem('todoList', jsonTodoList);
            }
        });
    });

    //リセットボタンのイベント
    const RESET_BUTTON = document.getElementById('reset');

    RESET_BUTTON.addEventListener('click', (event) => {
        CHECK_BOXES.forEach((check_box) => {
            check_box.checked = false;
            check_box.parentNode.parentNode.classList.remove('finished');
        });
        localStorage.clear();
        initializeArrayTodoList();
    });

    /**
     * arrayTodoListを初期化する
     */
    function initializeArrayTodoList() {
        arrayTodoList = new Array(CHECK_BOXES.length);
        for (let index = 0; index < arrayTodoList.length; index++) {
            arrayTodoList[index] = false;
        }
    }
});
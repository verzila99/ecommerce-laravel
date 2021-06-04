let adminMenuItems = document.querySelectorAll('.admin-menu__item');
let modals = document.querySelectorAll('.admin-modal');

adminMenuItems.forEach((elem) => {

  elem.addEventListener('click', () => {
    adminMenuItems.forEach((el) => {
      el.classList.remove('is-active');
    });
    modals.forEach(el => {
      el.classList.add('is-hidden');
    });
    document.getElementById(elem.dataset.link).classList.remove('is-hidden');
    elem.classList.add('is-active');

  });
});

let categorySelect = document.getElementById('category');
let categoryProps = document.querySelector('.category-props');
if (categorySelect) {
  categorySelect.addEventListener('change', (e) => {

    axios.get('api/getPropsOfCategory/' + e.target.value)
         .then(response => {
           console.log(response.data);
           while (categoryProps.lastChild) {
             categoryProps.lastChild.remove();
           }
           response.data.forEach((el => {
             let div = document.createElement('div');
             div.classList.add('field');
             div.innerHTML = ` <label class="label" >${el.name_ru}</label >
      <div class="control" >
        <input class="input" type="text" placeholder="${el.name_ru}"  name="${el.name}">
      </div >`;
             categoryProps.appendChild(div);
           }));
         })
         .catch(err => {console.log(err);});
  });
}
//clone file input
if (document.querySelector('.file-inputs')) {
  cloneFileInput();
  showFileName();
}

function cloneFileInput() {
  document.querySelector('.file-inputs').lastElementChild.lastElementChild.addEventListener('click', (e) => {
    let newDiv = e.target.parentNode.cloneNode(true);
     let child = e.target.parentNode.parentNode.appendChild(newDiv);
    child.querySelector('span[class=file-label]').textContent = 'Выберите файл';
    child.querySelector('span[class=file-name]').textContent = '';
    child.querySelector('.file-image').src ='';

    cloneFileInput();
    showFileName();
  });
}
function showFileName(){
  let inputs = document.querySelectorAll('.file-input');
  inputs.forEach((elem)=>{
    elem.addEventListener('change',()=>{
      elem.parentNode.querySelector('span[class=file-label]').textContent='';
      elem.parentNode.querySelector('span[class=file-name]').textContent=elem.files.item(0).name;
      elem.parentNode.parentNode.querySelector('.file-image').src= URL.createObjectURL(elem.files[0]);
    });
  });
}

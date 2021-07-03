

//get Props Of Category
let categorySelect = document.getElementById('category');
let categoryProps = document.querySelector('.category-props');
if (categorySelect) {
  categorySelect.addEventListener('change', (e) => {

    axios.get('/api/getPropsOfCategory/' + e.target.value)
         .then(response => {

           while (categoryProps.lastChild) {
             categoryProps.lastChild.remove();
           }
           response.data.forEach((el => {
             let div = document.createElement('div');
             div.classList.add('field');
             div.innerHTML = ` <label class="label" >${el.name}</label >
      <div class="control" >
        <input class="input" type="text" placeholder="${el.name}"  name="${el.name}">
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
  deleteImage();
}

function cloneFileInput() {
  document.querySelector('.file-inputs').lastElementChild.lastElementChild.addEventListener('click', (e) => {
    let newDiv = e.target.parentNode.cloneNode(true);
     let child = e.target.parentNode.parentNode.appendChild(newDiv);
    child.querySelector('span[class=file-label]').textContent = 'Choose a file';
    child.querySelector('span[class=file-name]').textContent = '';
    child.querySelector('.file-image').src ='';

    cloneFileInput();
    showFileName();
    deleteImage();
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
function deleteImage() {
  let deleteButtons = document.querySelectorAll('.icon-delete');
  deleteButtons.forEach((elem)=>{
    elem.addEventListener('click', (e)=>{
      e.target.parentNode.parentNode.remove();
    });
  });
}

//  active tab

const adminTabs = document.querySelectorAll('.admin-menu__item');
let urlObject = new URL(document.location.href);

let path = urlObject.pathname;

adminTabs.forEach(elem => {
  if (elem.getAttribute('data-path') === path) {
    elem.classList.add('is-active');

  } else if (elem.classList.contains('is-active')) {

    elem.classList.remove('is-active');
  }
});

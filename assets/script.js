console.log("Hello")



// > Add Piece > "Add Images" button
document
  .querySelectorAll('.addFormImagesLink')
  .forEach(btn => {
      btn.addEventListener("click", addFormToCollection)
  });

  // > Add Piece > "Add Videos" button
  document
    .querySelectorAll('.addFormVideosLink')
    .forEach(btn => {
        btn.addEventListener("click", addFormToCollection)
    });

// > Add Influencer > "Add Socials" button
  document
    .querySelectorAll('.addFormSocialsLink')
    .forEach(btn => {
        btn.addEventListener("click", addFormToCollection)
    });


    
// > Add Piece > Pushing images/videos forms in the DOM 
function addFormToCollection(e) {
const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);

const item = document.createElement('li');

item.innerHTML = collectionHolder
    .dataset
    .prototype
    .replace(
    /__name__/g,
    collectionHolder.dataset.index
    );

collectionHolder.appendChild(item);

collectionHolder.dataset.index++;
};



// Delete modal
const deleteConfirm = document.querySelectorAll(".deleteConfirm")
const openModal = document.querySelectorAll(".openModal")
const closeModal = document.querySelectorAll(".closeModal")

deleteConfirm.forEach((delConf, index) => {
    delConf.addEventListener("click", function () {
    openModal[index].showModal()
    })
});

closeModal.forEach((cloMo, index) => {
    cloMo.addEventListener("click", function () {
    openModal[index].close()
    })
});

openModal.forEach(opMo => {
    window.addEventListener("click", function (event) {
        if (event.target === opMo) {
            opMo.close()
        }
    })
});



// Add comment field size adjust
const addComment = document.querySelectorAll(".addComment")

function adjustHeight(addCo) {
    addCo.style.height = 'auto'
    addCo.style.height = addCo.scrollHeight + 'px'
}

addComment.forEach((addCo) => {
    addCo.addEventListener('input', () => adjustHeight(addCo));
    adjustHeight(addCo)
});


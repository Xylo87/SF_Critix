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


// > Display more comment content
const comments = document.querySelectorAll(".commentDisplay")

comments.forEach(comment => {
    const paragraph = comment.querySelector("p")
    const expandBtn = comment.querySelector(".moreBtn")
    const expandIcon = comment.querySelector(".moreIcon")

    if (paragraph.scrollHeight <= paragraph.clientHeight) {
        expandBtn.style.display = "none"
    }

    expandBtn.addEventListener("click", function () {
        if (comment.classList.contains("expanded")) {
            comment.classList.remove("expanded")
            expandIcon.classList.replace("fa-minus", "fa-plus")
        } else {
            comment.classList.add("expanded")
            expandIcon.classList.replace("fa-plus", "fa-minus")
        }
    })
})



// > AJAX flash messages setup
const flashMessageContainer = document.getElementById('flashMessages')
const flashMessage = document.createElement('strong')


// > AJAX for Critics Save button
const saveButtons = document.querySelectorAll('.save-critics-btn')

saveButtons.forEach(button => {
    button.addEventListener('click', async() => {

        const pieceId = button.dataset.pieceId
        const action = button.dataset.action

        try {
            const response = await fetch(`/critics/${pieceId}/${action}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                }
            })
        
            const data = await response.json()

            if (data.success) {
                if (action === 'save') {
                    button.textContent = 'Unsave page'
                    button.dataset.action = 'unsave'
                    flashMessage.textContent = data.message
                } else {
                    button.textContent = 'Come back later'
                    button.dataset.action = 'save'
                    flashMessage.textContent = data.message
                }
            } else {
                flashMessage.textContent = data.message
            }
    
            flashMessageContainer.appendChild(flashMessage)
            setTimeout(() => {
                flashMessage.remove();
            }, 5000);

        } catch (error) {
            console.error('Error', error)
            alert('Internal server error has occured')
        }
    })
});
    





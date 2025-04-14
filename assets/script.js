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
    // openModal[index].close()
    const parentModal = this.closest('.openModal')
    parentModal.close()
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
    const scrollPos = window.scrollY;

    addCo.style.height = 'auto'
    addCo.style.height = addCo.scrollHeight + 'px'

    window.scrollTo({
        top: scrollPos,
        behavior: "instant" // "auto" sur les navigateurs plus anciens
    });
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
const flashMessageContainer = document.querySelector('nav')

// > AJAX for Critics Save button
const saveButtons = document.querySelectorAll('.save-critics-btn')
const saveIcon = document.querySelectorAll('.fa-bookmark')
const criticDashTitle = document.getElementById('criticDashTitle')

saveButtons.forEach(button => {
    button.addEventListener('click', async() => {

        const pieceId = button.dataset.pieceId
        const action = button.dataset.action
        const savedCriticDash = document.getElementById(`savedCriticDash${pieceId}`)

        try {
            const response = await fetch(`/critics/${pieceId}/${action}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                }
            })
        
            const data = await response.json()

            const flashMessage = document.createElement('div')

            if (data.success) {
                if (action === 'save') {
                    // .classList.replace('fa-solid', 'fa-regular')
                    button.dataset.action = 'unsave'
                } else {
                    // .classList.replace('fa-regular', 'fa-solid')
                    button.dataset.action = 'save'

                    if (savedCriticDash) {
                        savedCriticDash.remove()
                    }

                    if (criticDashTitle) {
                        if (criticDashTitle.nextElementSibling != document.querySelector('[id^="savedCriticDash"]') || 
                        criticDashTitle.nextElementSibling === null) {

                            criticDashTitle.remove()
                        }
                    }
                }
                flashMessage.textContent = data.message
                flashMessage.classList.add('alert')
                flashMessage.classList.add('alert-success')
            } else {
                flashMessage.textContent = data.message
                flashMessage.classList.add('alert')
                flashMessage.classList.add('alert-danger')
            }

            flashMessageContainer.appendChild(flashMessage)
            setTimeout(() => {
                flashMessage.classList.add('fade-out')
                setTimeout(() => 
                    flashMessage.remove(), 500)
            }, 3000);

        } catch (error) {
            console.error('Error', error)
            alert('Internal server error has occured')
        }
    })
});

// > AJAX for Influencer Like button
const likeButtons = document.querySelectorAll('.like-influencer-btn')
const influencerDashTitle = document.getElementById('influencerDashTitle')

likeButtons.forEach(button => {
    button.addEventListener('click', async() => {

        const influencerId = button.dataset.influencerId
        const action = button.dataset.action
        const likedInfluencerDash = document.getElementById(`likedInfluencerDash${influencerId}`)

        try {
            const response = await fetch(`/influencer/${influencerId}/${action}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                }
            })
        
            const data = await response.json()

            const flashMessage = document.createElement('div')

            if (data.success) {
                if (action === 'like') {
                    button.textContent = 'Unlike'
                    button.dataset.action = 'unlike'
                    flashMessage.textContent = data.message
                    flashMessage.classList.add('alert')
                    flashMessage.classList.add('alert-success')
                } else {
                    button.textContent = 'Like'
                    button.dataset.action = 'like'
                    flashMessage.textContent = data.message
                    flashMessage.classList.add('alert')
                    flashMessage.classList.add('alert-success')

                    if (likedInfluencerDash) {
                        likedInfluencerDash.remove()
                    }

                    if (influencerDashTitle) {
                        if (influencerDashTitle.nextElementSibling != document.querySelector('[id^="likedInfluencerDash"]') ||
                        influencerDashTitle.nextElementSibling === null ) {
                            
                            influencerDashTitle.remove()
                        }  
                    }
                }
            } else {
                flashMessage.textContent = data.message
                flashMessage.classList.add('alert')
                flashMessage.classList.add('alert-danger')
            }
    
            flashMessageContainer.appendChild(flashMessage)
            setTimeout(() => {
                flashMessage.classList.add('fade-out')
                setTimeout(() => 
                    flashMessage.remove(), 500)
            }, 3000);

        } catch (error) {
            console.error('Error', error)
            alert('Internal server error has occured')
        }
    })
});
  


// > Flash Messages vanish
const flashVanish = document.querySelectorAll(".alert")
flashVanish.forEach(flash => {
    setTimeout(() => {
        flash.classList.add('fade-out')
        setTimeout(() => 
            flash.remove(), 500)
    }, 3000);
});



// > Waiting loaded DOM for hash scroll
window.onload = function() {
    setTimeout(function() {
        if (window.location.hash) {
            let targetElement = document.querySelector(window.location.hash)
            targetElement.scrollIntoView({ behavior: 'smooth' })
        }
    }, 100); // Ajustez le délai si nécessaire
};


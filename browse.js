// Global Declaration
let username = document.getElementById("username").innerHTML.trim();
let dishName = document.getElementById("dish-name");
let dishDesc = document.getElementById("dish-desc");
let ingredients = document.getElementById("ingredient-post");
let instructions = document.getElementById("instruction-post");
let prv = document.getElementById("img-preview");
let prvContainer = document.getElementById("previewCon");
let prvText = document.getElementById("preview-text");
let fileUpload = document.getElementById("recipe-photo");
let createDish = document.getElementById("create-dish");
let recipeCards = document.getElementById("recipe-cards");
let xmlhttp = new XMLHttpRequest();

// Style javascript

const hamburger = document.querySelector(".hamburger");
const navMenu = document.querySelector(".nav-menu");

hamburger.addEventListener("click", mobileMenu);

function mobileMenu() {
    hamburger.classList.toggle("active");
    navMenu.classList.toggle("active");
}

const navLink = document.querySelectorAll(".nav-link");

navLink.forEach(n => n.addEventListener("click", closeMenu));

function closeMenu() {
    hamburger.classList.remove("active");
    navMenu.classList.remove("active");
}

let date = new Date();
let day = String(date.getDate()).padStart(2, '0');
let month = String(date.getMonth() + 1).padStart(2, '0');
let year = date.getFullYear();
date = month + '/' + day + '/' + year;
document.getElementById('date').text = date;

// Get the modal
let modal = document.getElementById('id01');
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
// end style javascript


// Disable backtick
function disableBt(element) {
    element.value = element.value.split("`").join(" ");
}
dishName.addEventListener("input", function() {
    disableBt(this);
});
dishDesc.addEventListener("input", function() {
    disableBt(this);
});
ingredients.addEventListener("input", function() {
    disableBt(this);
});
instructions.addEventListener("input", function() {
    disableBt(this);
});

// Call every cards in database
function callCards() {
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            recipeCards.innerHTML = this.responseText;
            this.addEventListener("load", openDetails);
        }
    }
    xmlhttp.open("GET", "../AAR/ajax/recipecards.php", true);
    xmlhttp.send();
}
callCards();

// Recipe upload to database through AJAX
createDish.addEventListener("click", function() {
    let dishName = document.getElementById("dish-name");
    let dishDesc = document.getElementById("dish-desc");
    let dishIngr = document.getElementById("ingredient-post");
    let dishInst = document.getElementById("instruction-post");
    let photo = document.getElementById("recipe-photo").files[0];

    let formData = new FormData();
    formData.append("dish-name", dishName.value);
    formData.append("dish-desc", dishDesc.value);
    formData.append("ingredient-post", dishIngr.value);
    formData.append("instruction-post", dishInst.value);
    formData.append("username", username);
    formData.append("photo", photo);
    
    if (dishName.value.trim() != "" || dishDesc.value.trim() != "" || dishIngr.value.trim() != "" || dishInst.value.trim() != "") {
        xmlhttp.open("POST", "../AAR/ajax/uploadpic.php", false);
        xmlhttp.send(formData);
        callCards();
        prvText.innerHTML = "-";
        prv.style.display = "none";
        prvContainer.style.borderStyle = "dashed";
        dishName.value = "";
        dishDesc.value = "";
        dishIngr.value = "";
        dishInst.value = "";
        document.getElementById("id01").style.display = "none";
    }
});

// Image Preview
fileUpload.addEventListener("change", function(e) {
    prvText.innerHTML = fileUpload.value;
    prv.src = URL.createObjectURL(e.target.files[0]);
    prv.style.display = "block";
    prvContainer.style.borderStyle = "none";
});

function likepost() {
    let likebtn = document.getElementById("likebtn");
    let recipeId = likebtn.getAttribute("value");
    let likecount = document.getElementById("like-count");
    likebtn.addEventListener("click", function() {
        if (!(likebtn.classList.contains("likebtn-liked"))) {
            this.classList.add("likebtn-liked");
            likecount.innerHTML = parseInt(likecount.innerHTML) + 1;
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log("liked");
                }
            }
            xmlhttp.open("GET", "../AAR/ajax/like.php?username=" + username + "&rid=" + recipeId, true);
            xmlhttp.send();
        }
    });
}

// Assign ajax called elements with a function to open recipe details
function openDetails() {
    let cards = document.getElementsByClassName("openDetails");
    for(let i = 0; i < cards.length; i++) {
        cards[i].addEventListener("click", function() {
            let recipeID = this.getAttribute("value");
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    let container = document.getElementById("id02");
                    container.innerHTML = "Fetching data...";
                    let response = this.responseText;
                    container.innerHTML = response;

                    this.addEventListener("load", likepost);
                }
            }
            xmlhttp.open("GET", "../AAR/ajax/getrecipe.php?keyword=" + recipeID + "&browse=true&username=" + username, true);
            xmlhttp.send();
        });
    }
}


// Live search
let search = document.getElementById("search-input");
search.addEventListener("input", () => {
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            recipeCards.innerHTML = this.responseText;
            this.addEventListener("load", openDetails);
        }
    }
    xmlhttp.open("GET", "../AAR/ajax/recipecards.php?keyword=" + search.value, true);
    xmlhttp.send();
});


document.addEventListener("click", function() {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log("click");
        }
    }
    xhr.open("GET", "../AAR/ajax/addclicks.php?username=" + username, true);
    xhr.send();
});
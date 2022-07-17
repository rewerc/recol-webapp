// Global Declaration
const hamburger = document.querySelector(".hamburger");
const navMenu = document.querySelector(".nav-menu");
let username = document.getElementById("username").innerHTML.trim();
let dishName = document.getElementById("dish-name");
let dishDesc = document.getElementById("dish-desc");
let ingredients = document.getElementById("ingredient-post");
let instructions = document.getElementById("instruction-post");
let recipeCards = document.getElementById("recipe-cards");
let prv = document.getElementById("img-preview");
let prvContainer = document.getElementById("previewCon");
let prvText = document.getElementById("preview-text");
let fileUpload = document.getElementById("recipe-photo");
let createDish = document.getElementById("create-dish");
let search = document.getElementById("search-input");
let xmlhttp = new XMLHttpRequest();

// Style javascript
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

// Call recipe cards
function callCards() {
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            recipeCards.innerHTML = this.responseText;
            this.addEventListener("load", openDetails);
        }
    }
    xmlhttp.open("GET", "../AAR/ajax/recipecards.php?username=" + username, true);
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
    console.log(photo);
    let formData = new FormData();
    formData.append("dish-name", dishName.value);
    formData.append("dish-desc", dishDesc.value);
    formData.append("ingredient-post", dishIngr.value);
    formData.append("instruction-post", dishInst.value);
    formData.append("username", username);
    formData.append("photo", photo);
    
    if (dishName.value.trim() != "" || dishDesc.value.trim() != "" || dishIngr.value.trim() != "" || dishInst.value.trim() != "") {
        let xmlhttp = new XMLHttpRequest();
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

// Change the recipe detail layout into input boxes and text areas
function changetoInput () {
    document.getElementById("editbtn").addEventListener("click", function() {

        let preName = document.getElementById("name-con").innerHTML.trim();
        let preDesc = document.getElementById("description-con").innerHTML.trim();
        let preIngr = document.getElementById("ingredient-con").innerHTML.trim();
        let preInst = document.getElementById("instruction-con").innerHTML.trim();
        
        
        document.getElementById("name-con").innerHTML = '<input id="update-name" name="update-name" type="text" style="width: 400px">';
        let nameUpdate = document.getElementById("update-name");
        nameUpdate.value = preName;
        
        document.getElementById("description-con").innerHTML = '<textarea name="update-desc" id="update-desc" cols="80" rows="3" class="update-ta"></textarea>';
        let descUpdate = document.getElementById("update-desc");
        descUpdate.value = preDesc.trim().split("<br>").join("`").split("`").join("");
        
        document.getElementById("ingredient-con").innerHTML = '<textarea name="update-ingr" id="update-ingr" cols="80" rows="5" class="update-ta"></textarea>';
        let ingrUpdate = document.getElementById("update-ingr");
        ingrUpdate.value = preIngr.split("<br>").join("`").split("`").join("");
        
        document.getElementById("instruction-con").innerHTML = '<textarea name="update-inst" id="update-inst" cols="80" rows="5" class="update-ta"></textarea>';
        let instUpdate = document.getElementById("update-inst");
        instUpdate.value = preInst.split("<br>").join("`").split("`").join("");
        
        nameUpdate.addEventListener("input", function() {
            disableBt(this);
        });
        descUpdate.addEventListener("input", function() {
            disableBt(this);
        });
        ingrUpdate.addEventListener("input", function() {
            disableBt(this);
        });
        instUpdate.addEventListener("input", function() {
            disableBt(this);
        });

        let recipeID = this.getAttribute("value");
        document.getElementById("edit-container").innerHTML = '<button id="editbtn" value=' + recipeID + ' name="update" type="submit" class="editbtn" style="padding-bottom:7px;">Save</button>'

    })
}

// Assign ajax called elements with a function to open recipe details
function openDetails() {
    let cards = document.getElementsByClassName("openDetails");
    for(let i = 0; i < cards.length; i++) {
        cards[i].addEventListener("click", function() {
            let recipeID = this.getAttribute("value");
            console.log(this);
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    let container = document.getElementById("id02");
                    container.innerHTML = "Fetching data...";
                    let response = this.responseText;
                    container.innerHTML = response;

                    this.addEventListener("load", changetoInput);
                }
            }
            xmlhttp.open("GET", "../AAR/ajax/getrecipe.php?keyword=" + recipeID, true);
            xmlhttp.send();
        });
    }
}


// Live search
search.addEventListener("input", () => {
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            recipeCards.innerHTML = this.responseText;
            this.addEventListener("load", openDetails);
        }
    }
    xmlhttp.open("GET", "../AAR/ajax/recipecards.php?keyword=" + search.value + "&username=" + username, true);
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
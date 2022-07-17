<div id="id01" class="modal">
   <form class="modal-content animate">
      <div class="iconcontainer">
         <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      </div>

      <div class="modal_container">
         <h2 class="upload-title" style="text-align: left;">Create your own recipe </h2>
      </div><hr style="color:rgb(189, 189, 189); font-weight:200">

      <div class="modal_container2" style="padding-left:69px">
         <div>
            <label style="padding-right: 13px;" for="ingredient-post" class="label-post">Recipe Name</label>
            <input id="dish-name" style="width: 74%;" type="text" placeholder="Recipe name..." name="uname" required>
         </div>
         <div>
            <input type="file" name="recipe-photo" id="recipe-photo" accept=".png,.jpg,.jpeg,.gif">
         </div>

         <div>
            <label for="recipe-photo" id="recipe-photo-click">
               <span style="color: yellow; font-size: 25px;">+</span> Add photo
            </label>
         </div>
         <div>
            <p style="font-size: 16px; padding: 9px;">
               Preview: <span id="preview-text">-</span> </p></div>

         <div id="previewCon">
            <img id="img-preview" style="width: 150px; height: 100px">
         </div>

         <div>
            <textarea name="dish-desc" id="dish-desc" class="form-control" rows="3" placeholder="Describe this dish..." required></textarea>
         </div>

         <div>
            <label for="ingredient-post" class="label-post">Ingredients</label>
            <br>
            <textarea name="ingredient-post" id="ingredient-post" class="form-control no-hspan" rows="5" placeholder="- 1 Apple" required></textarea>
         </div> 

         <div>
            <label for="instruction-post" class="label-post">Instructions</label>
            <br>
            <textarea name="instruction-post" id="instruction-post" class="form-control no-hspan" rows="5" placeholder="1. Peel the apples" required></textarea>
         </div> 
      </div>

      <br><hr>
      <div class="modal_container" style="padding: 17px; text-align:right;">
         <button type="button" onclick="document.getElementById('id01').style.display='none'" class="closebtn" style="padding-bottom:7px;">Close</button>
         <button id="create-dish" type="button" class="createbtn" style="padding-bottom:7px;">Create</button>
      </div>
      </form>
</div>



(function(win, doc, _) {

  var loaders = doc.querySelectorAll(".side-bar-loader");
  var sideBar = doc.getElementById("side-bar");
  var sideBarContent = doc.getElementById("side-bar-content");
  var sideBarClose = doc.getElementById("close-side-bar");

  var imageFiles;

  sideBarClose.addEventListener("click", closeSidebar, false);

  for ( var i = 0; i < loaders.length; i++ ) {
    loaders[i].addEventListener("click", loadSidebar, false);
  }

  function loadSidebar(e) {
    e.preventDefault();
    var src = e.target;
    // var loads = src.getAttribute('data-loads');
    var loads = src.getAttribute("data-loads");
    var updates = src.getAttribute("data-updates");

    ajax.get(loads, function(text) {
      sideBarContent.innerHTML = text;

      var btn = doc.createElement("button");
      btn.className = "btn ajax-btn side-bar-confirm";
      btn.setAttribute("data-updates", updates);
      btn.innerHTML = "Confirm";
      btn.addEventListener("click", updateDetails, false);
      btn.addEventListener("click", closeSidebar, false);
      sideBarContent.firstElementChild.appendChild(btn);
      sideBarContent.querySelectorAll('input, textarea')[0].focus();
      assignEvents();
    });

    sideBar.classList.remove("side-panel__closed");
    sideBar.classList.add("side-panel__open");
  }

  function updateDetails(e) {
    var src = e.target;
    var form = src.parentElement;
    var updates = src.getAttribute("data-updates");
    var details = doc.getElementById(updates);
    var formData = collectFormData(form);
    var send = "json=" + JSON.stringify(formData);

    console.log(send);

    ajax.post(updates, send, function(rep) {
      // doc.write(rep);
      ajax.get(updates, function(data) {
        // doc.write(data);
        details.innerHTML = data;
      });
    });

  }

  function collectFormData(form) {
    var inputs = form.querySelectorAll("input, textarea, select");
    var data = [];

    for ( var i = 0; i < inputs.length; i++ ) {
      var pair = {};
      pair.key = inputs[i].id;

      if ( inputs[i].type == "radio" || inputs[i].type == "checkbox") {
        pair.value = inputs[i].checked;
      } else {
        pair.value = inputs[i].value;
      }

      data.push(pair);
    }

    return data;
  }

  function assignEvents() {
    var imageInput = doc.getElementById('image-input');
    var ajaxBtns = doc.querySelectorAll('.ajax-btn');
    for ( var i = 0; i < ajaxBtns.length; i++ ) {
      ajaxBtns[i].addEventListener("click", function(e) {
        e.preventDefault();
      }, false);
    }

    console.log(imageInput);

    if ( imageInput ) {
      imageInput.addEventListener('change', updateImages, false);
    }
  }

  function closeSidebar(e) {
    e.preventDefault();
    sideBarContent.innerHTML = "";
    sideBar.classList.remove("side-panel__open");
    sideBar.classList.add("side-panel__closed");
  }


  function updateImages(e) {
    var src = e.target;

    imageFiles = this.files;

    for ( var i = 0; i < imageFiles.length; i++ ) {
      addToImageList(imageFiles[i], i);
    }
  }

  function addToImageList(file, index) {
    var list = doc.getElementById('image-list');
    var name = doc.createElement('span');
    var preview = doc.createElement('img');
    var upload = doc.createElement('a');
    var wrap = doc.createElement('div');

    wrap.classList.add("image-item");

    upload.classList.add("upload-image-btn");
    upload.setAttribute("data-image-id", index);
    upload.innerHTML = "Upload";
    upload.href = "image-upload";
    upload.addEventListener('click', uploadImage, false);

    name.innerHTML = file.name;
    name.classList.add("image-filename");
    preview.file = file;
    preview.classList.add("image-upload-preview");
    wrap.appendChild(preview);
    wrap.appendChild(name);
    wrap.appendChild(upload);

    list.appendChild(wrap);

    // REFERENCE: https://developer.mozilla.org/en/docs/
    // Using_files_from_web_applications#Example_Showing_thumbnails_of_user-selected_images
    var fr = new FileReader();
    fr.onload = (function(img) {
      return function(e) {
        img.src = e.target.result;
      };
    }) (preview);

    fr.readAsDataURL(file);
  }

  function uploadImage(e) {
    e.preventDefault();
    var src = e.target;
    var index = src.getAttribute("data-image-id");
    // get the image...

    var fr = new FileReader();

    fr.onload = function(e) {
      ajax.setContentType("image/png;base64");
      ajax.post(src.href, e.target.result, function(rep) {
        doc.write(rep);
      });
    }
    // fr.readAsBinaryString(imageFiles[index]);
    fr.readAsDataURL(imageFiles[index]);
  }

} (window, document, _))
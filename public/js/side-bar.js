(function(win, doc, _) {

  var loaders = doc.querySelectorAll(".side-bar-loader");
  var sideBar = doc.getElementById("side-bar");
  var sideBarContent = doc.getElementById("side-bar-content");
  var sideBarClose = doc.getElementById("close-side-bar");

  var toCancel = doc.querySelectorAll("input[type='text'], input[type='number']");

  for ( var i = 0; i < toCancel.length; i++ )
  {
    toCancel[i].addEventListener('keypress', function(e) {
      if ( e.keyCode === 13 ) {
        e.preventDefault();
      }
    })
  }

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
      assignSidebarEvents();
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

    console.log(formData);

    ajax.setContentType("application/x-www-form-urlencoded");
    ajax.post(updates, send, function(rep) {
      // doc.write(rep);
      ajax.get(updates, function(data) {
        // doc.write(data);
        details.innerHTML = data;
      });
    });

  }

  function collectFormData(form) {
    var inputs = form.querySelectorAll("textarea, select, input:not([type='file'])");
    var checkboxes = form.querySelectorAll("input[type='checkbox']");

    if ( checkboxes.length !== 0 ) {
      return checkboxData(checkboxes);
    }

    var pairs = {};

    for ( var i = 0; i < inputs.length; i++ ) {
      if ( inputs[i].type == "radio" ) {
        if ( inputs[i].checked ) {
          pairs[inputs[i].name] = inputs[i].id;
        }
      } else {
        pairs[inputs[i].id] = inputs[i].value;
      }
    }

    return pairs;
  }

  function checkboxData(cbs) {
    var data = [];

    for ( var i = 0; i < cbs.length; i++ ) {
      var pair = {};

      if ( cbs[i].checked ) {
        pair[cbs[i].name] = cbs[i].id;
        data.push(pair);
      }
    }

    return data;
  }

  function assignSidebarEvents() {
    var imageInput = doc.getElementById('image-input');
    var ajaxBtns = doc.querySelectorAll('.ajax-btn');
    var sideBarConfirm = doc.querySelector('.side-bar-confirm');
    for ( var i = 0; i < ajaxBtns.length; i++ ) {
      ajaxBtns[i].addEventListener("click", function(e) {
        e.preventDefault();
      }, false);
    }

    if ( imageInput ) {
      imageInput.addEventListener('change', updateImages, false);
      sideBarConfirm.removeEventListener('click', updateDetails, false);
      sideBarConfirm.addEventListener('click', function(e) {
        var src = e.target;
        var updates = src.getAttribute("data-updates");
        var details = doc.getElementById(updates);
        var data = JSON.parse(sessionStorage.getItem('images'));

        for ( var i = 0; i < data.length; i++ ) {
          var div = doc.createElement("div");
          var img = doc.createElement("img");
          img.src = data[i].preview;
          img.alt = data[i].name;
          img.classList.add("image-upload-preview");
          div.innerHTML = data[i].name;
          details.appendChild(img);
          details.appendChild(div);
        }
      }, false);
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
    upload.setAttribute("data-image-name", file.name);
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
    var name = src.getAttribute("data-image-name");

    var fr = new FileReader();

    fr.onload = function(e) {
      // allow jpg.
      ajax.setContentType("image/png;base64");
      ajax.post(src.href, e.target.result, function(rep) {
        // doc.write(rep);
        var rep = JSON.parse(rep);
        var elem = doc.createElement('span');
        elem.innerHTML = rep.status;
        src.parentElement.appendChild(elem);

        if (rep.status === "success" ) {

          images = JSON.parse(sessionStorage.getItem("images"));
          if ( !images ) images = [];

          var image = {
            id: rep.id,
            name: name,
            preview: e.target.result
          }

          images.push(image);
          sessionStorage.setItem('images', JSON.stringify(images));

          src.href = "remove-image/" + rep.id;
          src.innerHTML = "Remove";
          src.removeEventListener('click', uploadImage, false);
          src.addEventListener('click', removeImage, false);
        }
      });
    }
    // fr.readAsBinaryString(imageFiles[index]);
    fr.readAsDataURL(imageFiles[index]);
  }

  function removeImage(e) {
    e.preventDefault();
    var src = e.target;

    ajax.get(src.href, function(rep) {
      // doc.write(rep);
      rep = JSON.parse(rep);

      if ( rep.status === "success" ) {
        // change button back.
      }
    });

  }



} (window, document, _))
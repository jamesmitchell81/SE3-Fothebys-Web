(function(win, doc, _) {

  var loaders = doc.querySelectorAll(".side-bar-loader");
  var sideBar = doc.getElementById("side-bar");
  var sideBarContent = doc.getElementById("side-bar-content");
  var sideBarClose = doc.getElementById("close-side-bar");

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
      btn.className = "btn ajax-btn";
      btn.setAttribute("data-updates", updates);
      btn.innerHTML = "Confirm";
      btn.addEventListener("click", updateDetails, false);
      btn.addEventListener("click", closeSidebar, false);
      sideBarContent.firstElementChild.appendChild(btn);
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

    ajax.post(updates, send, function(rep) {
      // doc.write(rep);
      ajax.get(updates, function(data) {
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
    var ajaxBtns = doc.querySelectorAll('.ajax-btn');

    for ( var i = 0; i < ajaxBtns.length; i++ ) {
      ajaxBtns[i].addEventListener("click", function(e) {
        e.preventDefault();
      }, false);
    }
  }

  function closeSidebar(e) {
    e.preventDefault();
    sideBarContent.innerHTML = "";
    sideBar.classList.remove("side-panel__open");
    sideBar.classList.add("side-panel__closed");
  }


} (window, document, _))
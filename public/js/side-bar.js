(function(win, doc) {

  var loaders = doc.querySelectorAll(".side-bar-loader");
  var sideBar = doc.getElementById("side-bar");

  for ( var i = 0; i < loaders.length; i++ ) {
    loaders[i].addEventListener("click", loadSidebar, false);
  }

  function loadSidebar(e) {
    e.preventDefault();
    var src = e.target;
    var loads = src.getAttribute('data-loads');

    ajax.get(loads, function(text) {
      sideBar.innerHTML = text;
    });

    sideBar.classList.remove("side-panel__closed");
    sideBar.classList.add("side-panel__open");
  }

  function closeSidebar(e) {
    e.preventDefault();


    sideBar.classList.remove("side-panel__open");
    sideBar.classList.add("side-panel__closed");
  }


} (window, document))
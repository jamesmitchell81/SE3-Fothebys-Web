(function(win, doc, _) {

  var search = _.throttle(function(e) {
    var src = e.target;
    var searchPath = src.getAttribute("data-search");
    var value = src.value;
    var searchData = searchPath + encodeURI(value);

    if ( value.length === 0 ) return;

    ajax.get(searchData, function(text) {
      src.nextElementSibling.innerHTML = text;
    });

  }, 1000);

  var searchFields = doc.querySelectorAll('.search-field');
  for ( var i = 0; i < searchFields.length; i++ ) {
    searchFields[i].addEventListener("keyup", search, false);
  }

} (window, document, _))
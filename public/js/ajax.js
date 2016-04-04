window.ajax = (function() {

  var http = new XMLHttpRequest();

  http.onreadystatechange = function() {
    if ( http.readyState === 4 ) {
      if ( http.status === 200 ) {
        ajax.callback(http.responseText);
      }
    }
  }

  var ajax = {
    contentType: "application/x-www-form-urlencoded",
    responseType: "", // may need for blob
    get: function(url, callback) {
      this.callback = callback;
      http.open("GET", url);
      http.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      http.setRequestHeader('Content-Type', this.contentType);
      http.send();
    },
    post: function(url, data, callback) {
      this.callback = callback;
      http.open("POST", url);
      http.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      http.setRequestHeader('Content-Type', this.contentType);
      http.send(data);
    },
    JSON: function() {
      this.contentType = "application/json"; //charset=UTF-8";
      return this;
    },
    XML: function() {
      this.contentType = "application/xml";
      return this;
    },
    form: function() {
      this.contentType = "application/x-www-form-urlencoded";
      return this;
    },
    setResponseType: function(type) {
      http.responseType = type;
    },
    setContentType: function(type) {
      this.contentType = type;
      return this;
    },
    callback: function(){}
  };

  return ajax;
})();
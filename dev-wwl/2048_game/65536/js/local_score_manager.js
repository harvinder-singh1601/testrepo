window.fakeStorage = {
  _data: {},

  setItem: function (id, val) {
    return this._data[id] = String(val);
  },

  getItem: function (id) {
    return this._data.hasOwnProperty(id) ? this._data[id] : undefined;
  },

  removeItem: function (id) {
    return delete this._data[id];
  },

  clear: function () {
    return this._data = {};
  }
};

function LocalScoreManager() {
  var localSupported = !!window.localStorage;

  this.key     = "bestScore";
  this.storage = localSupported ? window.localStorage : window.fakeStorage;
}

LocalScoreManager.prototype.get = function () {
  var bestscore = 0;
    var id=1;
    $.ajax({
        type: 'get',
        data: "id="+id,
        url: '../getData.php',
        async: false, // <- this turns it into synchronous
        success: function(data) {
            bestscore = data.bestscore;
        }
    });
  return bestscore;
};

LocalScoreManager.prototype.set = function (score) {
  var datastring = "bestScore="+score;
    $.ajax({
        type: 'post',
        data: datastring,
        url: '../postData.php',
        async: false, // <- this turns it into synchronous
    });
};


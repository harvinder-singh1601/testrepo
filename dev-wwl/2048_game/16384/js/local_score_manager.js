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
  this.key     = "bestScore";

  var supported = this.localStorageSupported();
  this.storage = supported ? window.localStorage : window.fakeStorage;
}

LocalScoreManager.prototype.localStorageSupported = function () {
  var testKey = "test";
  var storage = window.localStorage;

  try {
    storage.setItem(testKey, "1");
    storage.removeItem(testKey);
    return true;
  } catch (error) {
    return false;
  }
};

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
  this.storage.setItem(this.key, score);
};


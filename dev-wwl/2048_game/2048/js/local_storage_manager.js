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

function LocalStorageManager() {
  this.bestScoreKey     = "bestScore";
  this.gameStateKey     = "gameState";

  var supported = this.localStorageSupported();
  this.storage = supported ? window.localStorage : window.fakeStorage;
}

LocalStorageManager.prototype.localStorageSupported = function () {
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

// Best score getters/setters
LocalStorageManager.prototype.getBestScore = function () {
  var bestscore = 0;
    var id=document.getElementById("game_id").value;
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

LocalStorageManager.prototype.setBestScore = function (score) {
   var game_id=document.getElementById("game_id").value;
  var datastring = "bestScore="+score+"&game_id="+game_id;
    $.ajax({
        type: 'post',
        data: datastring,
        url: '../postData.php',
        async: false, // <- this turns it into synchronous
    });
};

// Game state getters/setters and clearing
LocalStorageManager.prototype.getGameState = function () {
  var stateJSON = null;
    var id=document.getElementById("game_id").value;
    $.ajax({
        type: 'get',
        data: "id="+id,
        url: '../getData.php',
        async: false, // <- this turns it into synchronous
        success: function(data) {
            stateJSON = data;
        }
    });
  return  null;
};

LocalStorageManager.prototype.setGameState = function (gameState) {
  this.storage.setItem(this.gameStateKey, JSON.stringify(gameState));
};

LocalStorageManager.prototype.clearGameState = function () {
  this.storage.removeItem(this.gameStateKey);
};

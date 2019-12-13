/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/embed-video-for-iframe.js":
/*!************************************************!*\
  !*** ./resources/js/embed-video-for-iframe.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  var create = 'user-replay.create';
  var edit = 'user-replay.edit';
  var method = $('#src_iframe').data('check');

  if (method === edit) {
    var src_iframe = $('#src_iframe').data('src');

    if ($('#src_iframe').val() === '') {
      $('#video_iframe_set').removeClass('d-none').attr('src', src_iframe);
    }
  }

  if (method === create) {
    if ($('#video_iframe_url').val()) {
      if (localStorage.success === 'true') {
        updateDataIfSuccess();
      }

      if (localStorage.success === 'false') {
        updateDataIfError();
      }

      if (localStorage.success !== 'false' && localStorage.success !== 'true') {
        refreshAllData();
      }
    } else {
      refreshAllData();
    }
  }
}); //setup before functions

var typingTimer; //timer identifier

var doneTypingInterval = 1500; //time in ms (1.5 seconds)
//on keyup, start the countdown

$('#video_iframe_url').keyup(function () {
  clearTimeout(typingTimer);

  if ($('#video_iframe_url').val()) {
    typingTimer = setTimeout(doneTyping, doneTypingInterval);
  } else {
    refreshAllData();
  }
}); //user is "finished typing," do something

function doneTyping() {
  var token = $('meta[name="csrf-token"]').attr('content');
  var video_iframe_url = $('#video_iframe_url').val();
  var url = $('#video_iframe_url').data('url');
  sendAjax(token, video_iframe_url, url);
}

function sendAjax(token, video_iframe_url, url) {
  $.ajax({
    url: url,
    method: 'POST',
    data: {
      _token: token,
      video_iframe_url: video_iframe_url
    },
    success: function success(data) {
      updateLocalStorage(data.success, data.message);
      updateDataIfSuccess();
    },
    error: function error(data) {
      updateLocalStorage(data.responseJSON.success, data.responseJSON.message);
      updateDataIfError();
    }
  });
}

function updateDataIfSuccess() {
  $('#src_iframe').val(localStorage.message);
  $('#video_iframe_set').removeClass('d-none').attr('src', localStorage.message);
  $("#video_iframe_error").addClass('d-none').html('');
}

function updateDataIfError() {
  $('#src_iframe').val('');
  $('#video_iframe_set').addClass('d-none').attr('src', '');
  $("#video_iframe_error").removeClass('d-none').html(localStorage.message);
}

function updateLocalStorage(success, message) {
  delete localStorage.success;
  delete localStorage.message;
  localStorage.success = success;
  localStorage.message = message;
}

function refreshAllData() {
  delete localStorage.success;
  delete localStorage.message;
  $('#src_iframe').val('');
  $('#video_iframe_set').addClass('d-none').attr('src', '');
  $("#video_iframe_error").addClass('d-none').html('');
}

/***/ }),

/***/ 2:
/*!******************************************************!*\
  !*** multi ./resources/js/embed-video-for-iframe.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Users\Sergey\Desktop\OSPanel 3.3.5\domains\reps\resources\js\embed-video-for-iframe.js */"./resources/js/embed-video-for-iframe.js");


/***/ })

/******/ });
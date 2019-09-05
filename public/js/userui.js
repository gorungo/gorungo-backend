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
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/userui.js":
/*!********************************!*\
  !*** ./resources/js/userui.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

var showNotification = function showNotification(text, msg_type) {
  var auto_hide = true; // сообщение о результате операции

  var result_message_wnd = $("<div>", {
    "id": "result_message",
    "class": "result_message"
  }); //result_message_wnd = $("#result_message");

  res_msg_class = '';

  switch (msg_type) {
    case 'red':
      // красное сообщение
      res_msg_class = "res_msg_red";
      break;

    case 'green':
      // зеленое сообщение
      res_msg_class = "res_msg_green";
      text = '<img src="/images/svg/checkmark.svg" width="64px" height="64px"/><br/>' + text;
      break;

    case 'modal':
      // красное сообщение
      res_msg_class = "res_msg_modal";
      auto_hide = false;
      break;

    default:
      break;
  }

  if (text != '') {
    text_lenght = text.length; // длина сообщения

    msg_time = 30 * text_lenght;

    if (res_msg_class != '') {
      $(result_message_wnd).addClass(res_msg_class);
    }

    $(result_message_wnd).html(text);
    $("body").append(result_message_wnd);
    $(result_message_wnd).css("top", $(window).height() / 2 - $(result_message_wnd).height() / 2).css("left", $(document).width() / 2 - $(result_message_wnd).width() / 2 - $(result_message_wnd).width() * 0.07);

    if (auto_hide) {
      $(result_message_wnd).fadeIn(200).delay(msg_time).fadeOut(200);
    } else {
      $(result_message_wnd).fadeIn(200).delay(4 * msg_time).fadeOut(200);
    }
  }

  $(result_message_wnd).click(function () {
    $(result_message_wnd).hide();
    $(result_message_wnd).detach();
  });
};

var showProgress = function showProgress() {
  // show loading progress
  var loading = $("<div>", {
    "class": "ds-loading"
  }); //выравним div по центру страницы

  $(loading).css("top", $(window).height() / 2).css("left", $(document).width() / 2 - 110); //добавляем созданный div в конец документа

  $("body").append(loading);
};

var hideProgress = function hideProgress() {
  // hide loading progress
  $(".ds-loading").detach();
};

var showNoInternetNotification = function showNoInternetNotification() {
  this.showNotification('Нет связи с сетью, повторите попытку', 'red', 'center');
};

module.exports.showProgress = showProgress;
module.exports.hideProgress = hideProgress;
module.exports.showNotification = showNotification;
module.exports.showNoInternetNotification = showNoInternetNotification;

/***/ }),

/***/ 3:
/*!**************************************!*\
  !*** multi ./resources/js/userui.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/denispetrov/Work/Web/gorungo2/resources/js/userui.js */"./resources/js/userui.js");


/***/ })

/******/ });
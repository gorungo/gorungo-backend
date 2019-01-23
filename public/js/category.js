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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/category.js":
/*!**********************************!*\
  !*** ./resources/js/category.js ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports) {

addCategory = function addCategory() {
  categoriesCount++;
  categoryIndex = categoriesCount;
  var categoryItemHtml = '' + '<input type="hidden" name="categories[' + categoryIndex + '][id]" id="frm-category-' + categoryIndex + '" value="0" />\n' + '<span id="category-item-' + categoryIndex + '-title">New catgory</span>\n' + '<button type="button" class="btn btn-category" onclick="editCategory(' + categoryIndex + ');" title="Edit category">\n' + '<span class="glyphicon glyphicon-pencil"></span>\n' + '</button>\n' + '<button type="button" class="btn btn-category" onclick="removeCategory(' + categoryIndex + ');">Delete</button>'; // добавляем поле

  var categoryItem = $("<div>", {
    "id": "category-item-" + categoryIndex,
    "class": "category-item"
  });
  $(categoryItem).html(categoryItemHtml);
  $('#category-selector-block').append(categoryItem);
  editCategory(categoryIndex); // редактируем данные поля
};
/**
 * Устанавливает id главной категории
 * @param categoryIndex
 */


setMainCategory = function setMainCategory(categoryIndex) {
  categoryId = $('#frm-category-' + categoryIndex).val();
  $('#frm_main_category_id').val(categoryId);
  alert(categoryId);
}; // нажата кнопка редактировать категорию


editCategory = function editCategory(categoryIndex) {
  try {
    $('#category-selector-modal').modal('show');
    categoryId = $('#frm-category-' + categoryIndex).val();
    $('#category-editing-index').text(categoryIndex);
    loadDataToModal(categoryId);
  } catch (e) {
    console.log('Не могу загрузить данные в модальную форму' + e);
  }
}; // нажата кнопка сохранить в окне редактирования категории


saveCategory = function saveCategory() {
  loadDataFromModal();
  $('#category-selector-modal').modal('hide');
};

removeCategory = function removeCategory(categoryIndex) {
  try {
    var categoryItem = document.getElementById("category-item-" + categoryIndex);
    categoryItem.parentNode.removeChild(categoryItem);
  } catch (e) {
    console.log(e);
  }
};

loadDataToModal = function loadDataToModal(categoryId) {
  // загружаем инфу по подкатегориям (запрашиваем деток категории у вселленной)
  $('#category-editing-id').text(categoryId);
  categories = loadCategoryParents(categoryId);
};

loadDataFromModal = function loadDataFromModal() {
  var categoryTitle = '';
  var newCatId = 0;
  categoryId = $('#category-editing-id').text();
  categoryIndex = $('#category-editing-index').text();
  catId1 = $('#cat_id_1').val();
  catId2 = $('#cat_id_2').val();
  catId3 = $('#cat_id_3').val();

  if (catId1 != 0) {
    newCatId = catId1;
    categoryTitle = $('#cat_id_1 option:selected').text();
  }

  if (catId2 != 0) {
    newCatId = catId2;
    categoryTitle = $('#cat_id_2 option:selected').text();
  }

  if (catId3 != 0) {
    newCatId = catId3;
    categoryTitle = $('#cat_id_3 option:selected').text();
  }

  $('#frm-category-' + categoryIndex).val(newCatId);
  $('#category-item-' + categoryIndex + '-title').text(categoryTitle);
};

generateCategorySelectorHTML = function generateCategorySelectorHTML(result) {
  if (result.type === 'error') {
    $(listItem).html('<option>No categories</option>');
    $(listItem).attr('disabled', true);
    $('#cat_sel_3').hide();
    return false;
  } else {
    var options0 = '';
    var options1 = '';
    var options2 = '';
    var catCount0 = 0;
    var catCount1 = 0;
    var catCount2 = 0;
    $(result.data.parentCategoryList[0]).each(function () {
      sel_text = '';
      if ($(this).attr('id') === result.data.categorySelected[0]) sel_text = 'selected';
      options0 += '<option value="' + this.id + '" ' + sel_text + '>' + this.localised_category_title.title + '</option>';
      catCount0++;
    });
    $(result.data.parentCategoryList[1]).each(function () {
      sel_text = '';
      if ($(this).attr('id') === result.data.categorySelected[1]) sel_text = 'selected';
      options1 += '<option value="' + this.id + '" ' + sel_text + '>' + this.localised_category_title.title + '</option>';
      catCount1++;
    });
    $(result.data.parentCategoryList[2]).each(function () {
      sel_text = '';
      if ($(this).attr('id') === result.data.categorySelected[2]) sel_text = 'selected';
      options2 += '<option value="' + this.id + '" ' + sel_text + '>' + this.localised_category_title.title + '</option>';
      catCount2++;
    });
    $('#cat_id_1').html('<option value="0">Select category</option>' + options0);
    $('#cat_id_1').attr('disabled', false);
    $('#cat_id_2').html('<option value="0">Select category</option>' + options1);
    if (options1 === '') $('#cat_id_2').attr('disabled', true);
    $('#cat_id_3').html('<option value="0">Select category</option>' + options2);
    if (options2 === '') $('#cat_id_3').attr('disabled', true);
    return true;
  }
};

loadCategoryParents = function loadCategoryParents(categoryId) {
  $.ajax({
    url: '/api/categories/' + categoryId + '/fullcategorieslisting',
    method: 'GET',
    dataType: 'JSON',

    /* что нужно сделать до отправки запрса */
    beforeSend: function beforeSend() {},
    success: function success(result) {
      if (result.type === 'error') {
        return false;
      } else {
        generateCategorySelectorHTML(result);
      }
    },
    error: function error() {
      return false;
    }
  });
};

$(document).ready(function () {
  $('#cat_id_1').change(function () {
    // выбор категории и подгрузка подкатегорий
    var cat_id = $('#cat_id_1 :selected').val();

    if (cat_id == '0') {
      $('#cat_id_2').html('<option value="0">Select category</option>');
      $('#cat_id_2').attr('disabled', true);
      $('#cat_id_3').html('<option value="0">Select category</option>');
      $('#cat_id_3').attr('disabled', true);
      $('#f_submit').attr('disabled', true);
      return false;
    }

    $('#cat_id_2').attr('disabled', true);
    $('#cat_id_2').html('<option>загрузка...</option>');
    loadCategoryList(2, cat_id);
  });
  $('#cat_id_2').change(function () {
    var cat_id = $('#cat_id_2 :selected').val();

    if (cat_id == '0') {
      $('#cat_id_3').html('<option value="0">Select category</option>');
      $('#cat_id_3').attr('disabled', true);
      $('#cat_sel_3').hide();
      $('#f_submit').attr('disabled', true);
      return false;
    }

    $('#cat_id_3').attr('disabled', true);
    $('#cat_id_3').html('<option>загрузка...</option>');
    loadCategoryList(3, cat_id);
  });
  $('#cat_id_3').change(function () {
    var cat_id = $('#cat_id_3 :selected').val();

    if (cat_id == '0') {
      $('#f_submit').attr('disabled', true);
      return false;
    }
  });
});

loadCategoryList = function loadCategoryList(listId, cat_id) {
  var lastCat_id = 0;

  if (listId == 1) {
    listItem = '#cat_id_1';

    if (typeof cat_id_1 !== "undefined") {
      lastCat_id = cat_id_1;
    }
  }

  if (listId == 2) {
    listItem = '#cat_id_2';

    if (typeof cat_id_2 !== "undefined") {
      lastCat_id = cat_id_2;
    }
  }

  if (listId == 3) {
    listItem = '#cat_id_3';

    if (typeof cat_id_3 !== "undefined") {
      lastCat_id = cat_id_3;
    }
  }

  $.ajax({
    /* адрес файла-обработчика запроса */
    url: '/api/categories/' + cat_id + '/child',

    /* метод отправки данных */
    method: 'GET',
    dataType: 'JSON',

    /* что нужно сделать до отправки запрса */
    beforeSend: function beforeSend() {},
    success: function success(result) {
      if (result.type == 'error') {
        $(listItem).html('<option value="0">No categories</option>');
        $(listItem).attr('disabled', true);
        $('#cat_sel_3').hide();
        return false;
      } else {
        var options = '';
        var cat_count = 0;
        $(result).each(function () {
          sel_text = '';
          if ($(this).attr('cat_id') == lastCat_id) sel_text = 'selected';
          options += '<option value="' + this.id + '" ' + sel_text + '>' + this.localised_category_title.title + '</option>';
          cat_count++;
          console.log(this.localised_category_title.title);
        });

        if (listId == 1) {
          $('#cat_id_1').html('<option value="0">Select category</option>' + options);
          $('#cat_id_1').attr('disabled', false);
          $('#cat_id_2').html('<option value="0">Select category</option>');
          $('#cat_id_2').attr('disabled', true);
          $('#cat_id_3').html('<option>Select category</option>');
          $('#cat_id_3').attr('disabled', true);
          $('#cat_sel_3').hide();
        }

        if (listId == 2) {
          if (cat_count != 0) {
            $('#cat_id_2').html('<option value="0">Select category</option>' + options);
            $('#cat_id_2').attr('disabled', false);
            $('#cat_id_3').html('<option value="0">Select category</option>');
            $('#cat_id_3').attr('disabled', true);
            $('#f_submit').attr('disabled', true);
          }
        }

        if (listId == 3) {
          if (cat_count != 0) {
            $('#cat_id_3').html('<option value="0">Select category</option>' + options);
            $('#cat_id_3').attr('disabled', false);
            $('#cat_sel_3').show();
            $('#f_submit').attr('disabled', true);
          }
        }

        return true;
      }
    }
  });
};

/***/ }),

/***/ 1:
/*!****************************************!*\
  !*** multi ./resources/js/category.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/denispetrov/Work/Web/gorungo2/resources/js/category.js */"./resources/js/category.js");


/***/ })

/******/ });
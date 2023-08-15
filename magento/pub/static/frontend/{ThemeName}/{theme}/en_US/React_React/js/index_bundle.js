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
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/index.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("throw new Error(\"Module build failed (from ./node_modules/babel-loader/lib/index.js):\\nSyntaxError: /var/www/mage/app/code/React/React/src/index.js: Support for the experimental syntax 'jsx' isn't currently enabled (19:37):\\n\\n\\u001b[0m \\u001b[90m 17 |\\u001b[39m             }\\u001b[0m\\n\\u001b[0m \\u001b[90m 18 |\\u001b[39m\\u001b[0m\\n\\u001b[0m\\u001b[31m\\u001b[1m>\\u001b[22m\\u001b[39m\\u001b[90m 19 |\\u001b[39m             \\u001b[36mreturn\\u001b[39m \\u001b[33mReactDOM\\u001b[39m\\u001b[33m.\\u001b[39mrender( \\u001b[33m<\\u001b[39m \\u001b[33mApp\\u001b[39m\\u001b[0m\\n\\u001b[0m \\u001b[90m    |\\u001b[39m                                     \\u001b[31m\\u001b[1m^\\u001b[22m\\u001b[39m\\u001b[0m\\n\\u001b[0m \\u001b[90m 20 |\\u001b[39m             parameter \\u001b[33m=\\u001b[39m {parameter}\\u001b[0m\\n\\u001b[0m \\u001b[90m 21 |\\u001b[39m             \\u001b[33m/\\u001b[39m\\u001b[33m>\\u001b[39m\\u001b[33m,\\u001b[39m document\\u001b[33m.\\u001b[39mgetElementById(element))\\u001b[33m;\\u001b[39m\\u001b[0m\\n\\u001b[0m \\u001b[90m 22 |\\u001b[39m         }\\u001b[0m\\n\\nAdd @babel/preset-react (https://github.com/babel/babel/tree/main/packages/babel-preset-react) to the 'presets' section of your Babel config to enable transformation.\\nIf you want to leave it as-is, add @babel/plugin-syntax-jsx (https://github.com/babel/babel/tree/main/packages/babel-plugin-syntax-jsx) to the 'plugins' section to enable parsing.\\n    at instantiate (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:72:32)\\n    at constructor (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:366:12)\\n    at Parser.raise (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:3453:19)\\n    at Parser.expectOnePlugin (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:3510:18)\\n    at Parser.parseExprAtom (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:13215:18)\\n    at Parser.parseExprSubscripts (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:12785:23)\\n    at Parser.parseUpdate (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:12764:21)\\n    at Parser.parseMaybeUnary (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:12734:23)\\n    at Parser.parseMaybeUnaryOrPrivate (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:12525:61)\\n    at Parser.parseExprOps (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:12532:23)\\n    at Parser.parseMaybeConditional (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:12502:23)\\n    at Parser.parseMaybeAssign (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:12454:21)\\n    at /var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:12412:39\\n    at Parser.allowInAnd (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:14486:12)\\n    at Parser.parseMaybeAssignAllowIn (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:12412:17)\\n    at Parser.parseExprListItem (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:14191:18)\\n    at Parser.parseCallExpressionArguments (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:13011:22)\\n    at Parser.parseCoverCallAndAsyncArrowHead (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:12908:29)\\n    at Parser.parseSubscript (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:12833:19)\\n    at Parser.parseSubscripts (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:12802:19)\\n    at Parser.parseExprSubscripts (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:12791:17)\\n    at Parser.parseUpdate (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:12764:21)\\n    at Parser.parseMaybeUnary (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:12734:23)\\n    at Parser.parseMaybeUnaryOrPrivate (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:12525:61)\\n    at Parser.parseExprOps (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:12532:23)\\n    at Parser.parseMaybeConditional (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:12502:23)\\n    at Parser.parseMaybeAssign (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:12454:21)\\n    at Parser.parseExpressionBase (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:12390:23)\\n    at /var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:12384:39\\n    at Parser.allowInAnd (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:14480:16)\\n    at Parser.parseExpression (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:12384:17)\\n    at Parser.parseReturnStatement (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:15192:28)\\n    at Parser.parseStatementContent (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:14831:21)\\n    at Parser.parseStatement (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:14777:17)\\n    at Parser.parseBlockOrModuleBlockBody (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:15420:25)\\n    at Parser.parseBlockBody (/var/www/mage/app/code/React/React/node_modules/@babel/parser/lib/index.js:15411:10)\");\n\n//# sourceURL=webpack:///./src/index.js?");

/***/ })

/******/ });
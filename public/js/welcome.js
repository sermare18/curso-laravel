/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/welcome.js":
/*!*********************************!*\
  !*** ./resources/js/welcome.js ***!
  \*********************************/
/***/ (() => {

eval("// Creamos un nuevo archivo por que este archivo solo lo queremos en una vista, no en todas.\nvar navbar = document.querySelector(\".navbar\");\nvar welcome = document.querySelector(\".welcome\");\nvar navbarToggle = document.querySelector(\"#navbarSupportedContent\");\nvar resizeBakgroundImg = function resizeBakgroundImg() {\n  var height = window.innerHeight - navbar.clientHeight;\n  welcome.style.height = \"\".concat(height, \"px\");\n};\nnavbarToggle.ontransitionend = resizeBakgroundImg;\nnavbarToggle.ontransitionstart = resizeBakgroundImg;\nwindow.onresize = resizeBakgroundImg;\nwindow.onload = resizeBakgroundImg;\n\n//Para quitar el padding de la ventana maestra únicamente en esta ventana de welcome\ndocument.querySelector('main').classList.remove('py-4');//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJuYW1lcyI6WyJuYXZiYXIiLCJkb2N1bWVudCIsInF1ZXJ5U2VsZWN0b3IiLCJ3ZWxjb21lIiwibmF2YmFyVG9nZ2xlIiwicmVzaXplQmFrZ3JvdW5kSW1nIiwiaGVpZ2h0Iiwid2luZG93IiwiaW5uZXJIZWlnaHQiLCJjbGllbnRIZWlnaHQiLCJzdHlsZSIsImNvbmNhdCIsIm9udHJhbnNpdGlvbmVuZCIsIm9udHJhbnNpdGlvbnN0YXJ0Iiwib25yZXNpemUiLCJvbmxvYWQiLCJjbGFzc0xpc3QiLCJyZW1vdmUiXSwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2pzL3dlbGNvbWUuanM/MjZkMiJdLCJzb3VyY2VzQ29udGVudCI6WyIvLyBDcmVhbW9zIHVuIG51ZXZvIGFyY2hpdm8gcG9yIHF1ZSBlc3RlIGFyY2hpdm8gc29sbyBsbyBxdWVyZW1vcyBlbiB1bmEgdmlzdGEsIG5vIGVuIHRvZGFzLlxuY29uc3QgbmF2YmFyID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcihcIi5uYXZiYXJcIik7XG5jb25zdCB3ZWxjb21lID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcihcIi53ZWxjb21lXCIpO1xuY29uc3QgbmF2YmFyVG9nZ2xlID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcihcIiNuYXZiYXJTdXBwb3J0ZWRDb250ZW50XCIpO1xuXG5jb25zdCByZXNpemVCYWtncm91bmRJbWcgPSAoKSA9PiB7XG4gIGNvbnN0IGhlaWdodCA9IHdpbmRvdy5pbm5lckhlaWdodCAtIG5hdmJhci5jbGllbnRIZWlnaHQ7XG4gIHdlbGNvbWUuc3R5bGUuaGVpZ2h0ID0gYCR7aGVpZ2h0fXB4YDtcbn07XG5cblxubmF2YmFyVG9nZ2xlLm9udHJhbnNpdGlvbmVuZCA9IHJlc2l6ZUJha2dyb3VuZEltZztcbm5hdmJhclRvZ2dsZS5vbnRyYW5zaXRpb25zdGFydCA9IHJlc2l6ZUJha2dyb3VuZEltZztcbndpbmRvdy5vbnJlc2l6ZSA9IHJlc2l6ZUJha2dyb3VuZEltZztcbndpbmRvdy5vbmxvYWQgPSByZXNpemVCYWtncm91bmRJbWc7XG5cbi8vUGFyYSBxdWl0YXIgZWwgcGFkZGluZyBkZSBsYSB2ZW50YW5hIG1hZXN0cmEgw7puaWNhbWVudGUgZW4gZXN0YSB2ZW50YW5hIGRlIHdlbGNvbWVcbmRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJ21haW4nKS5jbGFzc0xpc3QucmVtb3ZlKCdweS00JylcbiJdLCJtYXBwaW5ncyI6IkFBQUE7QUFDQSxJQUFNQSxNQUFNLEdBQUdDLFFBQVEsQ0FBQ0MsYUFBYSxDQUFDLFNBQVMsQ0FBQztBQUNoRCxJQUFNQyxPQUFPLEdBQUdGLFFBQVEsQ0FBQ0MsYUFBYSxDQUFDLFVBQVUsQ0FBQztBQUNsRCxJQUFNRSxZQUFZLEdBQUdILFFBQVEsQ0FBQ0MsYUFBYSxDQUFDLHlCQUF5QixDQUFDO0FBRXRFLElBQU1HLGtCQUFrQixHQUFHLFNBQXJCQSxrQkFBa0JBLENBQUEsRUFBUztFQUMvQixJQUFNQyxNQUFNLEdBQUdDLE1BQU0sQ0FBQ0MsV0FBVyxHQUFHUixNQUFNLENBQUNTLFlBQVk7RUFDdkROLE9BQU8sQ0FBQ08sS0FBSyxDQUFDSixNQUFNLE1BQUFLLE1BQUEsQ0FBTUwsTUFBTSxPQUFJO0FBQ3RDLENBQUM7QUFHREYsWUFBWSxDQUFDUSxlQUFlLEdBQUdQLGtCQUFrQjtBQUNqREQsWUFBWSxDQUFDUyxpQkFBaUIsR0FBR1Isa0JBQWtCO0FBQ25ERSxNQUFNLENBQUNPLFFBQVEsR0FBR1Qsa0JBQWtCO0FBQ3BDRSxNQUFNLENBQUNRLE1BQU0sR0FBR1Ysa0JBQWtCOztBQUVsQztBQUNBSixRQUFRLENBQUNDLGFBQWEsQ0FBQyxNQUFNLENBQUMsQ0FBQ2MsU0FBUyxDQUFDQyxNQUFNLENBQUMsTUFBTSxDQUFDIiwiZmlsZSI6Ii4vcmVzb3VyY2VzL2pzL3dlbGNvbWUuanMuanMiLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/js/welcome.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/js/welcome.js"]();
/******/ 	
/******/ })()
;
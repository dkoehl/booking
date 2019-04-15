/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
import '../css/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.

// loads the jquery package from node_modules
// const $ = require('jquery');
// import bootstrap from "bootstrap";


// import M from "materialize";
import React from "react";
import ReactDOM from "react-dom";
import Button from '@material-ui/core/Button';
import icons from "@material-ui/core/Icon";
import css from 'materialize-css';
import $ from 'jquery/dist/jquery.min';

import M from 'materialize-css'
import 'material-icons';


if (typeof window !== 'undefined') {
    window.$ = $;
    window.jQuery = $;
    require('materialize-css');
}
// var elems = document.querySelectorAll('.sidenav');
// var instance = M.Sidenav.getInstance(elem);
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems, {
        edge: 'left',
        draggable: true,
        inDuration: 250,
        outDuration: 200,
        onOpenStart: true,
        onOpenEnd: true,
        onCloseStart: false,
        onCloseEnd: false,
        preventScrolling: true
    });
});

// Initialize collapsible (uncomment the lines below if you use the dropdown variation)
// var collapsibleElem = document.querySelector('.collapsible');
// var collapsibleInstance = M.Collapsible.init(collapsibleElem, options);

// Or with jQuery

// $(document).ready(function(){
//     // $('.sidenav').sidenav();
// });
// // topbar
// import {MDCTopAppBar} from '@material/top-app-bar/index';
//
// // Instantiation
// const topAppBarElement = document.querySelector('.mdc-top-app-bar');
// const topAppBar = new MDCTopAppBar(topAppBarElement);





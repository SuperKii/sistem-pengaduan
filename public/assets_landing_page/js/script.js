'use strict';


const addEventOnElem = function (elem, type, callback){
    if(elem.length > 1){
        for (let i = 0; i < elem.length; i++) {
            elem[i].addEventListener(type, callback); 
        }
    }else {
        elem.addEventListener(type, callback);
    }
}


// navbar toggle

const navbar = document.querySelector("[data-navbar]");
const navToggler = document.querySelectorAll("[data-nav-toggler]");
const overlay = document.querySelector("[data-overlay]");

const togglerNavbar = function() {
    navbar.classList.toggle("active");
    overlay.classList.toggle("active");
}

addEventOnElem(navToggler, "click", togglerNavbar);

//close navbar when clicked on navbar links 

const navLinks = document.querySelectorAll("[data-nav-link]");

const closeNavbar = function() {
    navbar.classList.remove("active");
    overlay.classList.remove("active");
}

addEventOnElem(navLinks, "click", closeNavbar)


//Header active when scroll

const header = document.querySelector("[data-header]");

const headerActive = function () {
    if(window.scrollY > 100){
        header.classList.add("active");
    }else{
        header.classList.remove("active");
    }
}

addEventOnElem(window, "scroll", headerActive)

// accordion toggle

const accordionAction = document.querySelectorAll("[data-accordion-action]");

const toggleAccordion = function () {
    this.classList.toggle("active");
}

addEventOnElem(accordionAction, "click", toggleAccordion);
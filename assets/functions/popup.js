import { $ } from "./dom";

/**
 * @param {number } position 
 * @param {string} type 
 * @param {number} width 
 */
export function displayPopup(position, type, width = 350)
{
    const popUpElement = $('gcrdt-popup-dropdown', document)

    popUpElement.style.width = `${width}px`
    popUpElement.style.display = 'block'
    popUpElement.style.left = `${position - (popUpElement.clientWidth + 5)}px`
    popUpElement.setAttribute('popup', type)
}

/**
 * 
 * @param {{x, y}} position 
 * @param {number} width 
 */
export function displaySearchbox(position, width)
{
    /** @var HTMLElement searchBoxElement */
    const searchBoxElement = $('gcrdt-popup-searchbox', document)

    searchBoxElement.style.left = `${position.x}px`
    searchBoxElement.style.top = `${parseInt(position.y) + 6}px`
    searchBoxElement.style.width = `${width}px`
    searchBoxElement.style.display = 'block'
}
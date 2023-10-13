import { $ } from "./dom";

export function displayPopup(position: number, type: string, width: number = 350)
{
    const popUpElement = $('gcrdt-popup-dropdown')
    if (popUpElement === null) return

    popUpElement.style.width = `${width}px`
    popUpElement.style.display = 'block'
    popUpElement.style.left = `${position - (popUpElement.clientWidth + 5)}px`
    popUpElement.setAttribute('popup', type)
}

export function displaySearchbox(position: {x: number, y: number}, width: number)
{
    const searchBoxElement = $('gcrdt-popup-searchbox')
    if (searchBoxElement === null) return

    searchBoxElement.style.left = `${position.x}px`
    searchBoxElement.style.top = `${position.y + 6}px`
    searchBoxElement.style.width = `${width}px`
    searchBoxElement.style.display = 'block'
}
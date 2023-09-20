import React, { useState } from 'react'
import { $ } from '/functions/dom'
import { useDisplayPopUp } from '/functions/hooks'
import { RenderContentMenu, RenderHeaderMenu } from './Menu'
import { RenderContentNotification, RenderHeaderNotification } from './Notification'
import { usePopup } from '/elements/App'

export const PopupContainer = () =>
{
	return (
		<gcrdt-popup-container>
            <RenderPopUp />
        </gcrdt-popup-container>
	)
}

function RenderPopUp()
{
    console.log(usePopup(), 'hehehehe')
    return (
        <div>
            <PopUpDropDown />
        </div>
    )
}

function PopUpDropDown()
{
    const [popUpType, setPopUpType] = useState(null)
    
    const elementName = 'gcrdt-popup-dropdown'
    const displayed = useDisplayPopUp(
        elementName, () => setPopUpType(
            $(elementName, document).getAttribute('popup') ?? null
        )
    )
    
    return (
        <gcrdt-popup-dropdown class="gcrdt-popup-container" style={{display: 'none', outline: 'none', position: 'fixed'}}>
            <RenderDropDwonWrapper type={popUpType} displayed={displayed} />
        </gcrdt-popup-dropdown>
    )
}

function RenderDropDwonWrapper({displayed, type})
{
    if (!displayed) return 
    console.log(type, "le type de popup")
    return (
        <div className="popup-wrapper" >
            <div id="spinner"></div>
            <RenderHeader type={type} />
            <RenderContent type={type} />
        </div>
    )
}

function RenderHeader({type})
{
    switch (type) {
        case "menu":
            return <RenderHeaderMenu />
        case "notification":
            return <RenderHeaderNotification />
        default:
            break;
    }
}

function RenderContent({type})
{    
    switch (type) {
        case "menu":
            return <RenderContentMenu />
        case "notification":
            return <RenderContentNotification />
        default:
            break;
    }
}


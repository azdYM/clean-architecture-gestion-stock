import { useState } from 'react'
import { $ } from '../functions/dom'
import { useDisplayPopUp } from '../functions/hooks'
import { RenderContentMenu, RenderHeaderMenu } from './Menu'
import { RenderContentNotification, RenderHeaderNotification } from './Notification'

export const PopupContainer = () =>
{
	return (
		<gcrdt-popup-container>
			<RenderPopUp />
		</gcrdt-popup-container>
	)
}

const RenderPopUp = function()
{
	return (
		<div>
			<PopUpDropDown />
		</div>
	)
}

const PopUpDropDown = function()
{
	const [popUpType, setPopUpType] = useState<string|null>(null)
	const elementName = 'gcrdt-popup-dropdown'

	const handleSetPopUpTyep = () => {
		const element = $(elementName) as HTMLElement
		const typePopUp = element.getAttribute('popup') ?? null
		setPopUpType(typePopUp)
	}
	
	const displayed = useDisplayPopUp(elementName, handleSetPopUpTyep)
	
	return (
		<gcrdt-popup-dropdown class="gcrdt-popup-container" style={{display: 'none', outline: 'none', position: 'fixed'}}>
			<RenderDropDwonWrapper type={popUpType} displayed={displayed} />
		</gcrdt-popup-dropdown>
	)
}

const RenderDropDwonWrapper = function({displayed, type}: {displayed: boolean, type: string|null})
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

const RenderHeader = function({type}: {type: string|null})
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

const RenderContent = function({type}: {type: string|null})
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
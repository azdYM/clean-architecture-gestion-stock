import ReactDOM from 'react-dom/client'
import React, { useContext, createContext, useRef } from 'react'
import { Navbar } from '/components/Navbar'
import { PopupContainer } from '/components/PopUpContainer'

const PopupContext = createContext({popupActived: false})
const AppContext = createContext({})

const PopupProvider = ({ children }) => {
	const popup = useRef(true)
	console.log(popup, 'child')
  	return (
		<PopupContext.Provider value={{popupActived: popup, updatePopup: () => !popup.current}}>
			{ children }
		</PopupContext.Provider>
	)
}

const AppProvider = ({ children }) => {
	return (
		<AppContext.Provider value={{}}>
			{ children }
		</AppContext.Provider>
	)
}

export const usePopup = () => {
	return useContext(PopupContext)
}

export default class App extends HTMLElement
{
	connectedCallback()
	{
		ReactDOM.createRoot(this).render(<Container />)
	}
}

function Container()
{
	return (
		<AppProvider>
			<PopupProvider >
				<Navbar />
				<Sidebar />
				<Content />
				<PopupContainer />
			</PopupProvider>
		</AppProvider>
	)
}

function Sidebar()
{
	return (
		<div></div>
	)
}

function Content()
{
	return (
		<div></div>
	)
}
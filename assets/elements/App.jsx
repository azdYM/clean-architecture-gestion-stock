import ReactDOM from 'react-dom/client'
import React from 'react'
import { MastheadContainer } from './Navbar'
import { AppContext } from '/functions/context'
import { RendererGuideContent } from './Guide'
import { AppPageManager } from './AppPageManager'
import { PopupContainer } from '/components/PopUpContainer'
import { BrowserRouter } from 'react-router-dom'

export default class App extends HTMLElement
{
	connectedCallback()
	{
		ReactDOM.createRoot(this).render(
			<BrowserRouter>
				<Container />
			</BrowserRouter>
		)
	}
}

const AppProvider = ({ children }) => {
	return (
		<AppContext.Provider value={{}}>
			{ children }
		</AppContext.Provider>
	)
}

function Container()
{
	return (
		<AppProvider>
			<div id='content'>
				<MastheadContainer />

				<div id='guide-wrapper'>
					<div id="guide-space"></div>
					<RendererGuideContent />
				</div>
				<AppPageManager />
			</div>
			<PopupContainer />
		</AppProvider>
	)
}

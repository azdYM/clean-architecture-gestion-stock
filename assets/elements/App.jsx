import ReactDOM from 'react-dom/client'
import React, { useRef } from 'react'
import { MastheadContainer } from './Navbar'
import { AppContext, PopupContext } from '/functions/context'
import { RendererGuideContent } from './Guide'
import { PageManager } from './PageManager'
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
				<PageManager />
			</div>
			<PopupContainer />
		</AppProvider>
	)
}

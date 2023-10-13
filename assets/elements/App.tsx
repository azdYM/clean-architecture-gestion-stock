import React from 'react'
import ReactDOM from 'react-dom/client'
import { BrowserRouter } from 'react-router-dom'
import { AppContext } from '../functions/context'
import { QueryClient, QueryClientProvider } from '@tanstack/react-query'
import { MastheadContainer } from './Navbar'
import { RendererGuideContent } from './Guide'
import { AppPageManager } from './AppPageManager'
import { PopupContainer } from '../components/PopUpContainer'

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

const AppProvider = ({ children }: React.PropsWithChildren) => {
	return (
		<AppContext.Provider value={{}}>
			{ children }
		</AppContext.Provider>
	)
}


function Container()
{
	const queryClient = new QueryClient()

	return (
		<AppProvider>
			<QueryClientProvider client={queryClient}>
				<div id='content'>
					<MastheadContainer />
					<div id='guide-wrapper'>
						<div id="guide-space"></div>
						<RendererGuideContent />
					</div>
					<AppPageManager />
				</div>
				<PopupContainer />
			</QueryClientProvider>
		</AppProvider>
	)
}
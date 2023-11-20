import ReactDOM from 'react-dom/client'
import { BrowserRouter, ErrorResponse } from 'react-router-dom'
import { QueryClient, QueryClientProvider, useQuery } from '@tanstack/react-query'
import { MastheadContainer } from './Navbar'
import { GuideContent } from './Guide'
import { AppPageManager } from './AppPageManager'
import { PopupContainer } from '../components/PopUpContainer'
import { AppProvider } from '../components/Providers'
import { UserData, getCurrentUser } from '../api/user'

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

const Container = function()
{
	const queryClient = new QueryClient()
	
	
	
	return (
		<QueryClientProvider client={queryClient}>
      		<AppWrapper />
		</QueryClientProvider>
	)
}

const AppWrapper = function () {
	const {data} = useQuery<UserData, ErrorResponse>({
		queryKey: ['current_user'],
		queryFn: () => getCurrentUser(),
	})

	return (
		<>
			<AppProvider user={data} >
				<div id='content'>
					<MastheadContainer />
					<div id='guide-wrapper'>
						<div id="guide-space"></div>
						<GuideContent />
					</div>
					<AppPageManager />
				</div>
				<PopupContainer />
			</AppProvider>
		</>
	)
}
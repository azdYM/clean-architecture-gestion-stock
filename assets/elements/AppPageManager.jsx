import { Routes, Route } from 'react-router-dom'
import { routes } from '/functions/links'
import { 
	AddOrUpdatedCustomer, 
	Attestations, 
	EvaluateGage, 
	History, 
	Home, 
	ShowAttestation, 
	ShowCustomer, 
	ShowGage 
} from '../pages'
import { CreateCredit } from '/pages/CreateCredit'
import { ShowCredit } from '/pages/ShowCredit'
import { Contracts } from '/pages/Contracts'

export const AppPageManager = () => {
	return (
		<Routes>
			<Route path={routes.home} element={<Home />} />
			<Route path={routes.history} element={<History />} />
			<Route path={routes.addCustomer} element={<AddOrUpdatedCustomer />} />
			<Route path={routes.showCustomer} element={<ShowCustomer />} />
			<Route path={routes.evaluateGage} element={<EvaluateGage />} />
			<Route path={routes.showGage} element={<ShowGage />} />
			<Route path={`${routes.attestations}/*`} element={<Attestations />} />
			<Route path={routes.showAttestation} element={<ShowAttestation />} />
			<Route path={routes.createCredit} element={<CreateCredit />} />
			<Route path={routes.showCredit} element={<ShowCredit />} />
			<Route path={routes.credits} element={<Contracts />} />
		</Routes>
	)
}
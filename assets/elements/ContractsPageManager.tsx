import { Routes, Route } from 'react-router-dom'
import { routes } from '../functions/links'
import { 
	ContractsAll,
} from '../pages'

export const ContractsPageManager = function() {
	return (
		<Routes>
			<Route 
				path={`${routes.allConctracts}`} 
				element={<ContractsAll />} 
			/>
		</Routes>
	)
}
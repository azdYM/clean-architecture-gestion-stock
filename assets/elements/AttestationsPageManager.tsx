import { Routes, Route } from 'react-router-dom'
import { routes } from '../functions/links'
import { 
	AttestationsAccepted,
	AttestationsAll,
	AttestationsForPawnCredit,
	AttestationsRejected,
} from '../pages'

export const AttestationsPageManager = () => {
	return (
		<Routes>
			
			<Route 
				path={`${routes.allAttestations}`} 
				element={<AttestationsAll />} 
			/>
			<Route 
				path={`${routes.attestationsAccepted}`} 
				element={<AttestationsAccepted />} 
			/>
			<Route
				path={`${routes.attesationsRejected}`} 
				element={<AttestationsRejected />} 
			/>
			<Route
				path={`${routes.attestationsForPawnCredit}`} 
				element={<AttestationsForPawnCredit />} 
			/>
		</Routes>
	)
}
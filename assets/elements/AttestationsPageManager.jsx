import { Routes, Route } from 'react-router-dom'
import { routes } from '/functions/links'
import { AcceptedAttestationsRenderer, AllAttestationsRenderer, RejectedAttestationRenderer } from '/pages'

export const AttestationsPageManager = () => {
	return (
		<Routes>
			<Route 
				path={`${routes.allAttestations}`} 
				element={<AllAttestationsRenderer />} 
			/>
			<Route 
				path={`${routes.attestations}/${routes.acceptedAttestations}`} 
				element={<AcceptedAttestationsRenderer />} 
			/>
			<Route
				path={`${routes.attestations}/${routes.rejectedAttestations}`} 
				element={<RejectedAttestationRenderer />} 
			/>
		</Routes>
	)
}
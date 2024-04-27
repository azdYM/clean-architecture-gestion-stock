import { forwardRef } from 'react'
import { CardResource } from './CardAndItemResource'


type CardAttestationProps = {
	width?: string,
	height?: string,
	multiAttestation?: boolean
}

export const CardAttestation = forwardRef<HTMLDivElement, CardAttestationProps>(function({multiAttestation, width = '280px', height = '90vh'}, ref) {

	return (
		<CardResource
			width={width}
			height={height}
			ref={ref}
		>
			{multiAttestation ? 'Afficher plusieurs attestation' : 'Afficher une seule attestation'}
		</CardResource>
	)
})
